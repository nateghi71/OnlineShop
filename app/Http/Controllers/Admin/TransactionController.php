<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::paginate(10);
        return view('admin.transactions.index' , compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show' , compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back();
    }
}
