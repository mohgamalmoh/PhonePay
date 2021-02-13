# PhonePay is a simple mobile app that allows users to transfer money to each other using mobile numbers.

## The implementation has been done using Laravel framework as it facilitates dependency injection and it has some other good features.

## These are the available endpoints:

### 1- Registration:
        URL: /register
        Method: POST
        Body Parameters: 
            "name"
            "mobile"
            "password"

### 2- Login:
        URL: /login
        Method: POST
        Body Parameters: 
            "mobile"
            "password"

### 3- Make a money transfere:
        URL: /transaction
        Method: POST
        Body Parameters: 
            "amount"
            "to" (mobile number to transfere money to it, it should be registered in our system).
        Header Parameters:
            "Authorization" (this value is returned after a successful 
             login in the response of the login API above)

### 4-Twilio Webhook (used by twillio to tell the user how to verify his/her transaction)
        URL: twillio-webhook/{transaction_id}  

### 5-Twilio verification callback (used by twillio to get user input over the phone and take an action accordingly)
        URL: verify-transaction/{transaction_id} 

### 6-Get the transactions list of the currently authenticated user:
        URL: /transactions
        Method: GET
        Header Parameters:
            "Authorization" (this value is returned after a successful login 
             in the response of the login API above)

### 7-Get the wallet balance of the currently authenticated user:
        URL: /wallet-balance
        Method: GET
        Header Parameters:
            "Authorization" (this value is returned after a successful 
            login in the response of the login API above)


## Installation steps:
    1- Clone the repository
    2- assuming you have a local environment ready for laravel, run these two 
       commands inside the root folder of the cloned repository:
            - php artisan migrate (to create the needed database tables)
            - php artisan serve (to run the local development environment)
    3- you will also need to have some configuration values in your .env file, this is a .env sample :
            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=dl
            DB_USERNAME=dbusername
            DB_PASSWORD=dbpassword

            TWILIO_ACCOUNT_SID=ACb2af0dadbee4c5c41aa04c97ca08309c
            TWILIO_AUTH_TOKEN=496fd1fc4536116eb584aa8b2c9ee192
            TWILIO_PHONE_NUMBER=+12017338319
            EXPOSED_DOMAIN=https://cedb2df42c5d.ngrok.io
    the "EXPOSED_DOMAIN" value is used by twilio to access your local 
    development environment, i used ngrok tool to have it.


## My thoughts about the solution:
  ### I tried as much as possible to stick to these principles:
        1- The bussiness logic is held in service classes not in the controllers.
        2- I use dependency injection wherever i can, to have a cleaner architecture.
        3- Database access is done using repository classes, to give us the flexibilty 
            of changing the underlying implementation of the database accessing logic 
            without changing the classes reponsible for the bussiness logic like the service classes.
        4- The aplication is modularized, i separated every related set of functionality in a separate 
            module according to my current understanding, and also according to the current scale (if 
            the initial scale was bigger we might have had different modules)
        5- I rely heavily on throwing/handling exceptions between the functions calls rather than 
            passing error messages and codes between the functions internally, and this gives us 
            better readability as we see the instructions flow (the happy path) in the functions 
            without any interruptions like having if, else to handle errors instead, i handle the 
            exceptions that gets thrown from the functions, and this in my opinion gives better 
            maintainability for scalable systems.

## Some enhancements and TODOs (I could have done these if i had more time):
        1- Develop custom exceptions to have it more organized, and to have a better control 
        on what to return to the client when we have some certain kinds of exceptions.

        2- Depend more on abstarctions and interfaces, for example we can use laravel service 
            providers/containers to inject abstractions instead of injecting concrete implementations, 
            and this gives us the flexibility to inject different implementations in different environmets 
            like having a dedicated mocking implementation for the testing environment.

        3- Having a docker compose file to run everything by a single command.
        
        4- Asking the user to enter a verification code other than 123, this verification code 
           could be dynamically generated randomly at the tranasction generation time and linked to it, 
           this way we could have added another layer of security to the verification process.


#### References:
    - Clean code - uncle bob
    - Twilio docs
    - Laravel docs
