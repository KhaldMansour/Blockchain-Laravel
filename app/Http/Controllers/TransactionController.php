<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\TransactionRepository;


use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;




class TransactionController extends Controller
{

    public $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->middleware('auth:web');

        $this->transactionRepository = $transactionRepository;
    }

    public function addTransaction(Request $request)
    {
        $this->transactionRepository->addTransactions($request);


        if (!$this->transactionRepository->isValid($request)){
            
            return redirect()->back()->with('message', 'error');

        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transactions.create');
    }
}
