<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the transaction.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            //paginate transactions sorted by last update date
            $clients = Transaction::with('client')
                                  ->orderByDesc('updated_at')
                                  ->paginate($request->input('perPage', 10));
            //return custom collection
            return TransactionResource::collection($clients);
        }
        
        return view('entities.transactions.index');
    }
    
    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        return view('entities.transactions.create');
    }
    
    /**
     * Store a newly created transaction in storage.
     *
     * @param \App\Http\Requests\StoreTransactionRequest $request
     *
     * @return \App\Transaction|\Illuminate\Database\Eloquent\Model
     */
    public function store(StoreTransactionRequest $request)
    {
        return Transaction::forceCreate($request->validated());
    }
    
    /**
     * Display the specified transaction.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Transaction        $transaction
     *
     * @return \App\Transaction|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Transaction $transaction)
    {
        if ($request->wantsJson()) {
            return TransactionResource::make($transaction->load('client'));
        }
        
        return view('entities.transactions.show', compact('transaction'));
    }
    
    /**
     * Show the form for editing the specified transaction.
     *
     * @param  \App\Transaction $transaction
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load('client');
        return view('entities.transactions.edit', compact('transaction'));
    }
    
    /**
     * Update the specified transaction in storage.
     *
     * @param \App\Http\Requests\StoreTransactionRequest $request
     * @param  \App\Transaction                          $transaction
     *
     * @return \App\Http\Resources\TransactionResource
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction): TransactionResource
    {
        //update transaction
        $transaction->update($request->validated());
        //return formatted response
        return TransactionResource::make($transaction->load('client')
                                                     ->refresh());
    }
    
    /**
     * Remove the specified transaction from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Transaction        $transaction
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->delete();
        
        return $this->returnSuccess($request);
        
    }
}
