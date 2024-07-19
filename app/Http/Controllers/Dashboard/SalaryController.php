<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\BanksEmployees;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Salary;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaries = Salary::paginate(10);
        $USD = Currency::where('code', 'USD')->first()->value;
        $btn_download_salary = null;
        $employess = Employee::all();
        foreach ($employess as $employee) {
            $salary = Salary::where('employee_id', $employee->id)->where('month', Carbon::now()->format('Y-m'))->first();
            if($salary == null){
                $btn_download_salary = "active";
            }
        }
        return view('dashboard.salaries.index', compact('salaries','btn_download_salary','USD'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $salary = new Salary();
        // $salary->employee = new Employee();
        // return view('dashboard.salaries.create',compact('salary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        $account_number = BanksEmployees::where('id', $salary->account_number)->first()->account_number;
        $salary->account_number = $account_number;
        return view('dashboard.salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        $salary->forceDelete();
        // $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'تم الحذف بنجاح');
    }

    // soft delete
    // public function trashed()
    // {
    //     $banks_employees = Salary::onlyTrashed()->paginate(10);

    //     return view('dashboard.banks_employees.trashed', compact('banks_employees'));
    // }
    // public function restore(Request $request)
    // {
    //     $banksEmployee = Salary::onlyTrashed()->findOrFail($request->id);
    //     $banksEmployee->restore();
    //     return redirect()->route('banks_employees.index')->with('success', 'تم إرجاع العنصر مرة أخرى');
    // }
    // public function forceDelete(Request $request)
    // {
    //     $banksEmployees = Salary::onlyTrashed()->findOrFail($request->banks_employees);
    //     $banksEmployees->forceDelete();
    //     // Salary::onlyTrashed()->where('deleted_at', '<', Carbon::now()->subDays(30))->forceDelete();
    //     return redirect()->route('banks_employees.trashed')->with('danger', 'تم الحذف بشكل نهائي');
    // }


    // Create All Salaries
    public function createAllSalaries(){
        DB::beginTransaction();
        try {
            $employees = Employee::get();
            foreach ($employees as $employee) {
                AddSalaryEmployee::addSalary($employee);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('salaries.index')->with('success', 'تم اضافة الراتب لجميع الموظفين للشهر الحالي');
    }
    // PDF Export
    public function viewPDF()
    {
        $salaries = Salary::get();
        $pdf = Pdf::loadView('dashboard.pdf.salaries', array('salaries' =>  $salaries));
        return $pdf->stream();
    }


}
