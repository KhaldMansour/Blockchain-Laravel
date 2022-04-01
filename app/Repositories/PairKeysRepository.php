<?php

namespace App\Repositories;

use Hash;
use Elliptic\EC;
use App\Models\Block;
use App\Models\BlockChain;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;


use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;



class PairKeysRepository
{
    public function genKeys()
    {
        // $ec = new EC('secp256k1');

        // // Generate keys
        // $key = $ec->genKeyPair();

        // $adapter = EccFactory::getAdapter();
        // $generator = EccFactory::getNistCurves()->generator384();
        // $private = $generator->createPrivateKey();
        // return [$adapter , $generator , $private];

        [$privateKey, $publicKey] = (new KeyPair())->generate();

        return ['private' => $privateKey, 'public' => $publicKey];

    }
}