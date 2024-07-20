<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Imports\TotalsImport;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\Total;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TotalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totals = Total::with(['employee'])->paginate(15);
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
        $salary = Salary::where('employee_id',$request->employee_id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee);
        }
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
        $salary = Salary::where('employee_id',$request->employee_id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee);
        }
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

    // Execl
    public function import(Request $request)
    {
        // $this->authorize('import', Employee::class);
        $file = $request->file('fileUplode');
        if($file == null){
            return redirect()->back()->with('error', 'لم يتم رفع الملف بشكل صحيح');
        }

        // dd($request->all());
        Excel::import(new TotalsImport, $file);

        return redirect()->route('banks_employees.index')->with('success', 'تم رفع الملف');
    }
    public function export(Request $request)
    {
        // $this->authorize('export', Employee::class);
        // $time = Carbon::now();
        // $filename = 'سجلات الموظفين' . $time .'.xlsx';
        // return Excel::download(new EmployeesDataExport, $filename);
    }
}
