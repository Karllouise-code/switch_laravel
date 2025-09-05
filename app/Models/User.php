<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Log;
use Hash;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tblUsers';
    protected $primaryKey = 'fldUsersID';

    protected $hidden = [
        'fldUsersPassword'
    ];

    public function findForPassport($username) {
        $user = $this
            ->where('fldUsersEmail', $username)
            ->first();
        return $user;
    }

    public function validateForPassportPasswordGrant($password) {
        return Hash::check($password, $this->fldUsersPassword);
    }

    public function onRegister($data) {
        $response_obj = new \stdClass();
        try {
            $user = new self;

            $user->fldUsersName = $data['name'];
            $user->fldUsersEmail = $data['email'];
            $user->fldUsersPassword = Hash::make($data['password']);
    
            $user->save();

            $response_obj->error = false;
            $response_obj->message = "User created successfully";
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $response_obj->error = true;
            $response_obj->message = $th->getMessage();
        }

        return $response_obj;
    }

    public function onLogin($data) {
        $response_obj = new \stdClass();
        try {
            // check if user exists
            $user = self::where('fldUsersEmail', $data['email'])->first();

            if ($user) {
                if(Hash::check($data['password'], $user->fldUsersPassword)) {
                    $oauth_helper = new OAuthHelper();
                    $response = $oauth_helper->GenerateUserToken($data['email'], $data['password']);
                    $response = json_decode($response);
                    
                    $response_obj->access_token = $response->access_token;


                    $response_obj->error = false;
                    $response_obj->message = "User logged in successfully";
                } else {
                    $response_obj->error = true;
                    $response_obj->message = "Invalid email or password";
                }
            } else {
                $response_obj->error = true;
                $response_obj->message = "Invalid email or password";
            }

            /* if ($user->validateForPassportPasswordGrant($data['password'])) {
                $response_obj->error = false;
                $response_obj->message = "User logged in successfully";
            } else {
                $response_obj->error = true;
                $response_obj->message = "Invalid email or password";
            } */
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $response_obj->error = true;
            $response_obj->message = $th->getMessage();
        }

        return $response_obj;
    }

    public function displayUser() {
        return Auth::user();
    }

}