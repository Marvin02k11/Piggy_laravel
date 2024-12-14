<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('s', ''); 
        $transactions = Transaction::where('user_id', Auth::id()) 
    ->when($searchTerm, function ($query, $searchTerm) {
        return $query->where('description', 'LIKE', "%{$searchTerm}%");
    })
    ->paginate(10)
    ->appends(['s' => $searchTerm]); 

        return view('transactions.index', compact('transactions', 'searchTerm'));
    }
    public function edit(Transaction $transaction)
    {
    return view('transactions.edit', compact('transaction'));
    }

    // public function index()
    // {
    //     $transactions = Transaction::where('user_id', Auth::id())->paginate(10);
    //     return view('transactions.index', compact('transactions'));
    // }
    public function addTransactionByCode()
    {
        
        $transactionData = [
            'description' => 'Manual Entry by Code',
            'amount' => 500.75,
            'date' => now(),
            'user_id' => Auth::id(), 
            'receipt' => null, 
        ];
        Transaction::create($transactionData);
    
        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully by code!');
    }
    
    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('receipt')) {
            $validated['receipt'] = $request->file('receipt')->store('receipts');
        }

        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');
    }
public function update(Request $request, Transaction $transaction)
{
    $validated = $request->validate([
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($request->hasFile('receipt')) {
        if ($transaction->receipt) {
            Storage::delete($transaction->receipt);
        }
        $validated['receipt'] = $request->file('receipt')->store('receipts');
    }

    $transaction->update($validated);

    return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully!');
}
public function destroy(Transaction $transaction)
{
    
    if ($transaction->receipt) {
        Storage::delete($transaction->receipt);
    }
    $transaction->delete();

    return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully!');
}

}
