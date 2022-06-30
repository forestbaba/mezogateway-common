<?php

namespace Commonservices;

class WalletService
{
    private $endpoint;

    public function __construct(){
        $this->endpoint = env('WALLET_ENDPOINT');
    }

    public function headers(){
        return [
            "Authorization" =>  request()->headers->get("Authorization")
        ];
    }

    public function request(){
        return \Http::withHeaders($this->headers());
    }

    public function getWallet($user, $telephone){

        $response = $this->request()->post("{$this->endpoint}/get-wallet",[
            'telephone' => $telephone,
            'user' => $user
        ]);
        $json =  $response->json();

       return $response['data']['wallet'];
    }
    public function getWalletByUserId($userId){

        $response = $this->request()->post("{$this->endpoint}/get-wallet-by-id",[
            'user' => $userId
        ]);
        $json =  $response->json();
       return $response['data']['wallet'];
    }

    public function creditWallet($user, $telephone, $amount, $walletAction,$senderPhone,$transRef){

        $response = $this->request()->post("{$this->endpoint}/credit-wallet",[

            'receiver_id' =>$user,
            'receiver_telephone' => $telephone,
            'amount' => $amount,
            'walletAction'=>$walletAction,
            'senderPhone' => $senderPhone,
            'transRef' => $transRef,
        ]);

       return $response;
    }

}
