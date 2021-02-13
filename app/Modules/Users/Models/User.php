<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{

protected $table = 'users';
protected $fillable = ['name','mobile','password','wallet_balance','verification_code'];
}