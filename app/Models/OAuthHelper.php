<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contacts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\Passport;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;

use Hash;
use Log;
use Session;
use Request;
use Crypt;
use GuzzleHttp\Client;

use App\User;

class OAuthHelper extends Authenticatable
{
  use HasApiTokens, Notifiable;

  private $user_client_secret = '1SXtZb6f9F4gyRWNw2qbzDDdrlz0ug5OTv7utIFi';
  private $user_client_id = '6';

    public function GenerateUserToken($email, $password)
    {
      $client = new Client;

      $form_params = [
        'grant_type' => 'password',
        'client_id' => $this->user_client_id,
        'client_secret' => $this->user_client_secret,
        'username' => $email,
        'password' => $password,
        'scope' => '',
      ];

      $response = $client->post(url('/oauth/token'), [
        'form_params' => $form_params,
      ])->getBody()->getContents();

      return $response;
    }


    public function RefreshUserToken($refresh_token)
    {
      $client = new Client;

      $response = $client->post(url('oauth/token'), [
        'form_params' => [
          'grant_type' => 'refresh_token',
          'refresh_token' => $refresh_token,
          'client_id' => $this->user_client_id,
          'client_secret' => $this->user_client_secret,
          'scope' => '',
        ]
      ])->getBody()->getContents();


      return $response;
    }




}