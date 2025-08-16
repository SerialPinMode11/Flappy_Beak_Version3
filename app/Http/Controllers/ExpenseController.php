<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Exports\ExpensesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        // Fetch expenses with pagination
        $expenses = Expense::latest()->paginate(10);

        // Return view with expenses data
        return view('admin.expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        return view('admin.expense.create');
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        // Validate and save the new expense
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('admin.expense.index')->with('success', 'Expense added successfully!');
    }

    /**
     * Display the specified expense.
     */
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expense.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expense.edit', compact('expense'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate and update the expense
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        
        return redirect()->route('admin.expense.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.expense.index')->with('success', 'Expense deleted successfully!');
    }

    /**
     * Export expenses to Excel file.
     */
    public function exportToExcel(Request $request)
    {
        $filename = 'expenses_report_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new ExpensesExport($request), $filename);
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $category = $request->get('category');

        $filename = 'expenses_report_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new ExpensesExport($startDate, $endDate, $category),
            $filename
        );
    }
}

