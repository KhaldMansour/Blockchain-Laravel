<?php

namespace App\Http\Controllers\API;

use Hash;
use App\Models\Block;
use App\Models\BlockChain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BlockRepository;
use App\Repositories\PairKeysRepository;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;


class BlockChainController extends Controller
{

    public $blockRepository;

    public $pairkeysRepository;


    public function __construct(BlockRepository $blockRepository  )
    {
        $this->blockRepository = $blockRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $block_ids = BlockChain::pluck('block_id'); 
        // return 
        dd($block_ids);
        return $this->blockRepository->getLastBlock();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addBlock(Request $request)
    {
        // return $request['public_key'];

        $private = PrivateKey::fromString($request['private_key']);
        
        $public = PublicKey::fromString($request['public_key']);


        $signature = $private->encrypt($request['amount']);

        return $public->decrypt($signature); // returns true;

        return $signature;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function show(BlockChain $blockChain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function edit(BlockChain $blockChain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlockChain $blockChain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlockChain $blockChain)
    {
        //
    }
}
