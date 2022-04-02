<?php

namespace App\Repositories;

use App\Models\Block;
use App\Models\BlockChain;
use App\Models\Transaction;
use App\Repositories\BlockRepository;

use Hash;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class TransactionRepository
{

    public $blockRepository;

    public function __construct(BlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }


    public function addTransactions($request)
    {
        $addresses = json_decode($request->tos);

        $amount = $request['amount'] / count($addresses);

        $keys =[ 
            trim( str_replace( "\\n" , "\n" , $request['private_key'])  , "\n")
            , 
             trim( str_replace( "\\n" , "\n" , $request['from']) , "\n") 
            ];

        $block = Block::create();

        foreach ($addresses as $address)
        {
            $transaction = new Transaction([
                'to' => $request['to'],
                'from' => $request['from'],
                'amount' => $amount
            ]);

            $signature = $this->signTransaction($transaction , $keys);

            $transaction->signature = $signature;

            $block->transactions()->save($transaction);

            $this->blockRepository->addBlock($block);
        }
    }

    public function signTransaction($transaction , $keys)
    {
        $transaction_hash = $this->calculateHash($transaction);
        
        $public = PublicKey::fromString(trim( str_replace( "\\n" , "\n" , $keys[1])  , "\n") );

        $private = PrivateKey::fromString(trim( str_replace( "\\n" , "\n" , $keys[0]) ) , "\n");

        $signature = $private->sign($transaction_hash);

        return $signature;
    }

    public function calculateHash($transaction)
    {
        $data = serialize($transaction['amount']) . $transaction['to'] . $transaction['from'];

        $hash = Hash::make($data);

        return $hash;
    }

    public function isValid($request)
    {
        $keyss =[ 
             str_replace( "\\n" , "\n" , $request['private_key'])  
            , 
              str_replace( "\\n" , "\n" , $request['from']) 
        ];

        $keys = [
            str_replace( "\r" , "" , $keyss[0])  
            , 
            str_replace( "\r" , "" , $keyss[1])  
        ];

        //check for user's public key
        if ($keys[1] !=  trim ( auth()->user()->public_key , "\n") )
        {
            dd($keys[1] , auth()->user()->public_key );
            return false;
        }

        //check for user's private key
        if ($keys[0] != trim ( auth()->user()->private_key , "\n"))
        {
            return false;
        }
        
        //heck for user's balance
        if ($request['amount'] > auth()->user()->balance)
        {
            return false;
        }

        return true;
    }

}