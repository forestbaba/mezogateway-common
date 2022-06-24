<?php

namespace CommonServices;

// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Http;


class UserService
{
    private $endpoint;

    public function __construct(){
        $this->endpoint = env('USERS_ENDPOINT');
    }

    public function headers(){
        return [
            "Authorization" =>  request()->headers->get("Authorization")
        ];
    }

    public function request(){
        return \Http::withHeaders($this->headers());
    }

    public function getUser(){

        $response = $this->request()->get("{$this->endpoint}/auth/profile");
        $json =  $response->json();
        // info($json['data']['pin']);

        $user = new User();
        $user->id = $json['data']['id'];
        $user->email =$json['data']['email'];
        $user->firstname =$json['data']['first_name'];
        $user->lastname =$json['data']['last_name'];
        $user->username =$json['data']['username'];
        $user->telephone =$json['data']['phone'];
        $user->user_type =$json['data']['type'];
        $user->pin =$json['data']['pin'];

       return $user;
    }
    public function getTransactionPin(){

        $response = $this->request()->get("{$this->endpoint}/auth/get-pin");
        $json =  $response->json();
        $user = new User();
        $user->transaction_pin = $json['data']['pin'];
        return $user;
    }
    public function getUserByPhone($phone){
            $response = $this->request()->post("{$this->endpoint}/auth/get-user-by-phone",[
                'phone' => $phone
            ]);
            $user = new User();
            $user->id = $response['data']['user']['id'];
            $user->email =$response['data']['user']['email'];
            $user->firstname =$response['data']['user']['firstname'];
            $user->lastname =$response['data']['user']['lastname'];
            $user->username =$response['data']['user']['username'];
            $user->telephone =$response['data']['user']['telephone'];
            $user->user_type =$response['data']['user']['user_type'];
            return $user;
    }

    public function checkAuth(){
        return \Http::withHeaders($this->headers())->get("{$this->endpoint}/auth/userz")->successful();
    }
}
