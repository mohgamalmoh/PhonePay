<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use App\Services\TransactionsVerificationService;

class TwilioService
{

    private $transactionsVerificationService;

    function __construct(TransactionsVerificationService $transactionsVerificationService) {
        $this->transactionsVerificationService = $transactionsVerificationService;
    }

    public function callUserToVerifyTransaction($user,$transaction)
        {
            $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            $client->calls->create(
                $user->mobile,
                env('TWILIO_PHONE_NUMBER'),
                ["url" => env('EXPOSED_DOMAIN')."/twillio-webhook/".$transaction->id]
                
            );
        }

        public function webhook($id)
        {

            $response = new VoiceResponse();
            // Use the <Gather> verb to collect user input
            $gather = $response->gather(array('numDigits' => 3, 'action' => '/verify-transaction/'.$id));
            // use the <Say> verb to request input from the user
            $gather->say('Please enter one hundred twenty three to verify the transaction');
            // If the user doesn't enter input, loop
            $response->redirect('/twillio-webhook/'.$id);
            // Render the response as XML in reply to the webhook request
            
            header('Content-Type: text/xml');
            echo $response;


        }


        public function verification($transaction_id)
        {
            $response = new VoiceResponse();
            switch ($_POST['Digits']) {
    
                case 123:
                    $response->say($this->transactionsVerificationService->verifyTransactionById($transaction_id) == true ? 
                    'we are processing your transaction, thank you!' : 'Sorry the transaction is expired');
                    break;
        
                default:
                    $response->say('Sorry, I don\'t understand that choice.');
                    $response->redirect('/twillio-webhook/'.$transaction_id);
                    
                }
            
            header('Content-Type: text/xml');
            echo $response;
        }


}