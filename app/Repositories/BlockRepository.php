<?php

namespace App\Repositories;

use Hash;
use App\Models\Block;
use App\Models\BlockChain;
use Illuminate\Support\Facades\DB;

class BlockRepository
{

    public function createGenesisBlock()
    {
        if (BlockChain::count() == 0 )
        {
            $block = Block::create([
                'transactions' => '',
            ]);
    
            $hash = $this->calculateHash($block);
    
            $block->hash = $hash;
    
            $block->save();
            
            BlockChain::create([            
            'block_id' => $block->id,
            ]);
        }
    }

    public function calculateHash($block)
    {
        $data = serialize($block->transactions) . $block->created_at . $block->updated_at;

        $hash = Hash::make($data);

        return $hash;
    }

    public function getLastBlock()
    {
        return Block::find(BlockChain::latest('id')->first()->block_id);
    }

    public function isValidChain()
    {
        $blocks = BlockChain::all();

        for ($i = 1; $i < count($blocks); $i++) {

            $currentBlock = Block::find($blocks[$i]['block_id']);

            $prevBlock = Block::find($blocks[$i -1]['block_id']);

            if ( !$this->isValidBlock($currentBlock))
            {
                return false;
            }

            if ( $currentBlock->prev_hash != $prevBlock->hash)
            {
                return false;
            }
        }
        return true;
    }

    public function isValidBlock($block)
    {
        $data = serialize($block->transactions) . $block->created_at . $block->updated_at;

        $check = Hash::check($data , $this->calculateHash($block));

        return $check;
    }
}