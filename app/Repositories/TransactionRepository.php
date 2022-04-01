<?php

namespace App\Repositories;

use App\Models\Block;
use App\Models\BlockChain;
use App\Models\Transaction;
use App\Models\PendingTransaction;

use Hash;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class TransactionRepository
{
    public function addTransactions($request)
    {
        $addresses = json_decode($request->tos);

        $amount = $request['amount'] / count($addresses);

        $keys =[ $request['private_key'] , $request['from']];

        $block = Block::create();

        // var_dump($block);

        foreach ($addresses as $address)
        {
            $transaction = new Transaction([
                'to' => $request['to'],
                'from' => $request['from'],
                'amount' => $amount
            ]);

            $signature = $this->signTransaction($transaction , $keys);

            var_dump($signature);

            $transaction->signature = $signature;

            $block->transactions()->save($transaction);
        }
    }

    public function signTransaction($transaction , $keys)
    {
        $transaction_hash = $this->calculateHash($transaction);
        
        // var_dump($private);

        $private = PrivateKey::fromString($keys[0]);

        $public = PublicKey::fromString($keys[1]);


        // dd($private)

        $signature = $private->sign($transaction_hash);

        // var_dump($encryptedData);

        // $transaction->signature = $encryptedData;

        return $signature;

        // return $public->verify($transaction_hash , $encryptedData);
    }

    public function calculateHash($transaction)
    {
        $data = serialize($transaction['amount']) . $transaction['to'] . $transaction['from'];

        $hash = Hash::make($data);

        return $hash;
    }

    public function isValid($request)
    {
        if ($request['from'] != auth()->user()->public_key)
        {
            return false;
        }

        if ($request['private_key'] != auth()->user()->private_key)
        {
            return false;
        }
        
        if ($request['amount'] > auth()->user()->balance)
        {
            return false;
        }

        return true;
    }

}