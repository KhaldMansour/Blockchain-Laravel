<?php

namespace App\Http\Controllers\API;

use Hash;
use App\Models\Block;
use App\Models\BlockChain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BlockRepository;
use App\Repositories\PairKeysRepository;
use App\Repositories\PendingTransactionRepository;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;


class BlockChainController extends Controller
{

    public $blockRepository;

    public $pairkeysRepository;

    public $pendingTransactionRepository;

    public function __construct(BlockRepository $blockRepository , PairKeysRepository $pairkeysRepository , PendingTransactionRepository $pendingTransactionRepository )
    {
        $this->blockRepository = $blockRepository;

        $this->pairkeysRepository = $pairkeysRepository;

        $this->pendingTransactionRepository = $pendingTransactionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        // $data = "test";
        // $keys = (new KeyPair())->generate();
        // return $keys;

        $private = PrivateKey::fromString($request['private_key']);
        
        $public = PublicKey::fromString($request['public_key']);

        $signature = $private->encrypt($request['amount']);

        return $public->decrypt($signature); // returns true;


        // $decryptedData = $public->decrypt($encryptedData);
        return $request['private_key'];

        $hi = $request->from; 

        return($request->user);

        return $this->pendingTransactionRepository->addPendingTransactions( $request);

        $this->blockRepository->createGenesisBlock();

        $request = $request->validate([
            'amount' => 'required|numeric',
            'to' => 'required|array',
            'to.*' => 'required|string',
        ]);

        // $data = $request->all();

        return $request;

        $prev_block = $this->blockRepository->getLastBlock();

        $new_block = new Block($data);
        
        $hash = $this->blockRepository->calculatHash($new_block);
        
        $new_block->hash = $hash;
        
        $new_block->prev_hash = $prev_block->hash;
        
        $new_block->save();
        
        BlockChain::create([
            'block_id' => $new_block->id
        ]);

        return Block::all();
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
