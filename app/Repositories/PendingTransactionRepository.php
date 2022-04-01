<?php

namespace App\Repositories;

use App\Models\Block;
use App\Models\BlockChain;
use App\Models\PendingTransaction;

use Hash;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class PendingTransactionRepository
{
    public function addPendingTransactions($request)
    {
        $request = $request->validate([
            'amount' => 'required|numeric',
            'from' => 'required|string',
            'to' => 'required|array',
            'to.*' => 'required|string',
        ]);

        return $this->isValid($request);


        $amount = $request['amount'] / count($request['to']);

        $transaction =[
            'to' => '1',
            'from' => '2',
            'amount' => 10
        ];


        return $this->signTransaction($transaction);
        // return [$request['to'] , $amount];
    }

    public function signTransaction($transaction)
    {
        $transaction_hash = $this->calculateHash($transaction);

        $keys = (new KeyPair())->generate();
        // return $keys;

        // $private = PrivateKey::fromString($keys[0]);
        // $public = PublicKey::fromString($keys[1]);
        // $encryptedData = $private->encrypt($data); 

        $private = PrivateKey::fromString($keys[0]);
        $public = PublicKey::fromString($keys[1]);

        $encryptedData = $private->sign($transaction_hash);

        return $public->verify($transaction_hash , $encryptedData);
    }

    public function calculateHash($transaction)
    {
        $data = serialize($transaction['amount']) . $transaction['to'] . $transaction['from'];

        $hash = Hash::make($data);

        return $hash;
    }

    public function isValid($transaction)
    {
        if ($transaction['from'] != "hi")
        {
            return false;
        }
        return true;
    }

}