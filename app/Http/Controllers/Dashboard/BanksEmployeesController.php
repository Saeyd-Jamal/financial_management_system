<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BanksEmployees;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BanksEmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks_employees = BanksEmployees::with(['employee','bank'])->paginate(10);
        return view('dashboard.banks_employees.index', compact('banks_employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bank_employee = new BanksEmployees();
        $banks = Bank::get();
        $employees = Employee::get();
        return view('dashboard.banks_employees.create', compact('bank_employee','banks','employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' =>'required|exists:employees,id',
            'bank_id' =>'required|exists:banks,id',
            'account_number' =>'required|min:9|max:9',
        ]);
        BanksEmployees::create($request->all());
        return redirect()->route('banks_employees.index')->with('success', 'تم إضافة حساب بنك جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(BanksEmployees $banksEmployees)
    {
        return redirect()->route('banks_employees.edit',$banksEmployees->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bank_employee = BanksEmployees::with(['employee','bank'])->find($id);
        $banks = Bank::get();
        $employees = Employee::get();
        return view('dashboard.banks_employees.edit', compact('bank_employee','banks','employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BanksEmployees $banksEmployees)
    {
        $request->validate([
            'employee_id' =>'required|exists:employees,id',
            'bank_id' =>'required|exists:banks,id',
            'account_number' =>'required|min:9|max:9',
        ]);
        $banksEmployees->update($request->all());
        return redirect()->route('banks_employees.index')->with('success', 'تم تحديث حساب البنك');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banksEmployees = BanksEmployees::findOrFail($id);
        $banksEmployees->delete();

        return redirect()->route('banks_employees.index')->with('success', 'تم حذف حساب البنك');
    }

}
