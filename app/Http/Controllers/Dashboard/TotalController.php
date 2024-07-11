<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Total;
use Illuminate\Http\Request;

class TotalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totals = Total::get();
        $total = new Total();
        return view('dashboard.totals', compact('totals','total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id|unique:totals,employee_id',
        ]);
        Total::create($request->all());
        return redirect()->route('totals.index')->with('success', 'تم إضافة إجمايات جديدة');
    }


    /**
     * Display the specified resource.
     */
    public function show(Total $total)
    {
        return redirect()->route('totals.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Total $total)
    {
        return $total;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Total $total)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);
        $total->update($request->all());
        return redirect()->route('totals.index')->with('success', 'تم تعديل الإجماليات لموظف');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Total $total)
    {
        $total->delete();
        return redirect()->route('totals.index')->with('danger', 'تم حذف الإجماليات لموظف');
    }
}
