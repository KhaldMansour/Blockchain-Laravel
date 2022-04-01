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
        // $this->blockRepository = $blockRepository;

        // $this->pairkeysRepository = $pairkeysRepository;

        // $this->middleware('auth:web');


        $this->transactionRepository = $transactionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addTransaction(Request $request)
    {
        // dd($request->all());
        // var_dump(auth()->user());

        // return redirect()->back()->with('message', auth()->user()->name);

        // $request = $request->validate([
        //     'amount' => 'required|numeric',
        //     'from' => 'required|string',
        //     'tos' => 'required',
        //     'private_key' =>'required|string'
        // ]);

        $keys =[ $request['private_key'] , $request['from']];

        // return strlen($request['private_key']);


        $public = PublicKey::fromString(trim( str_replace( "\\n" , "\n" , $keys[1]) ) , "\n" );
        $private = PrivateKey::fromString(trim( str_replace( "\\n" , "\n" , $keys[0]) ) , "\n");


        dd($private , $public);

        $this->transactionRepository->addTransactions($request);


        if (!$this->transactionRepository->isValid($request)){

            dd(json_decode($request->tos));

            // Session::flash('message', 'This is a message!'); 
            
            return redirect()->back()->with('message', 'error');
        }else{
            dd("here");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // var_dump(auth()->user());
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
