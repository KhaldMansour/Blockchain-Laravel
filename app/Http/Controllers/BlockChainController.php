<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\Block;
use App\Models\BlockChain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BlockRepository;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;


class BlockChainController extends Controller
{

    public $blockRepository;

    public function __construct(BlockRepository $blockRepository )
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
        
        $blocks = Block::whereIn('id', $block_ids)->get();
        
        return view('home' , ['blocks' => $blocks]);
    }
}
