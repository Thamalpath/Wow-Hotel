<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('id', 'desc')->get();
        $categories = Category::where('cat_code', 'EX')->get();
        
        return view('dashboard.transaction', compact('transactions', 'categories'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'bill_no' => 'required',
            'category' => 'required',
            'amount' => 'required|numeric',
            'handle_by' => 'required',
            'description' => 'required'
        ]);

        Transaction::create([
            'bill_no' => $validated['bill_no'],
            'ex_cat' => $validated['category'],
            'amount' => $validated['amount'],
            'handle_by' => $validated['handle_by'],
            'description' => $validated['description'],
            'status' => 'Expenses',
            'date' => now()
        ]);

        return redirect()->route('transactions.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Expense added successfully'
        ]);
    }

    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required'
        ]);

        Transaction::create([
            'bill_no' => '',
            'ex_cat' => '',
            'handle_by' => '',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'status' => 'Income',
            'date' => now()
        ]);

        return redirect()->route('transactions.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Income added successfully'
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Transaction deleted successfully!'
        ]);
    }
}
