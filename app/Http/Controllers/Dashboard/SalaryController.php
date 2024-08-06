<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Models\BanksEmployees;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\LogRecord;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class SalaryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Salary::class);
        $month  = "2024-07"; //Carbon::now()->format('Y-m')
        $salaries = Salary::paginate(10);
        $USD = Currency::where('code', 'USD')->first()->value;
        $btn_download_salary = null;
        $employess = Employee::all();
        foreach ($employess as $employee) {
            $salary = Salary::where('employee_id', $employee->id)->where('month', $month)->first();
            if($salary == null){
                $btn_download_salary = "active";
            }
        }
        $btn_delete_salary = $salaries->isNotEmpty() ? "active" : null;
        return view('dashboard.salaries.index', compact('salaries','btn_download_salary','btn_delete_salary','USD','month'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SalaryRequest $request)
    {
        // $salary = new Salary();
        // $salary->employee = new Employee();
        // return view('dashboard.salaries.create',compact('salary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        return view('dashboard.salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalaryRequest $request, Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryRequest $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalaryRequest $request, Salary $salary)
    {
        $USD = Currency::where('code', 'USD')->first()->value;
        $fixedEntries = $salary->employee->fixedEntries->where('month', $salary->month)->first();
        ReceivablesLoans::updateOrCreate([
            'employee_id' => $salary->employee_id,
        ],[
            'total_savings_loan' => DB::raw('total_savings_loan + '.($fixedEntries->savings_loan)),
            'total_shekel_loan' => DB::raw('total_shekel_loan + '.($fixedEntries->shekel_loan)),
            'total_association_loan' => DB::raw('total_association_loan + '.($fixedEntries->association_loan)),
            'total_receivables' => DB::raw('total_receivables - '.($salary->late_receivables)),
            'total_savings' => DB::raw('total_savings - '.($fixedEntries->savings_loan + (($fixedEntries->savings_rate + $salary->termination_service) / $USD ))),
        ]);
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
        $this->authorize('createAll', Salary::class);
        DB::beginTransaction();
        try {
            $employees = Employee::get();
            $logRecords = [];
            foreach ($employees as $employee) {
                try{
                    LogRecord::where('type', 'errorSalary')->where('related_id', "employee_$employee->id")->delete();
                    AddSalaryEmployee::addSalary($employee,'2024-07');
                }catch(Exception $e){
                    LogRecord::create([
                        'type' => 'errorSalary',
                        'related_id' => "employee_$employee->id",
                        'description' => 'خطأ في معالجة راتب الموظف : ' . $employee->name . '. الخطأ: ' . $e->getMessage(),
                    ]);
                }
            }
            $logRecords = LogRecord::where('type', 'errorSalary')->get()->pluck('description')->toArray();
            // الحصول على بداية ونهاية الشهر السابق
            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

            // العثور على جميع السجلات التي تم إنشاؤها في الشهر السابق
            DB::table('log_records')
                        ->where('type', 'errorSalary')
                        ->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                        ->delete();

            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('salaries.index')->with('success', 'تم اضافة الراتب لجميع الموظفين للشهر الحالي')
                ->with('danger', $logRecords);
    }
    // Create All Salaries
    public function deleteAllSalaries(){
        $this->authorize('deleteAll', Salary::class);
        DB::beginTransaction();
        try {
            $salaries = Salary::get();
            foreach ($salaries as $salary) {
                $USD = Currency::where('code', 'USD')->first()->value;
                $fixedEntries = $salary->employee->fixedEntries->where('month', $salary->month)->first();
                ReceivablesLoans::updateOrCreate([
                    'employee_id' => $salary->employee_id,
                ],[
                    'total_savings_loan' => DB::raw('total_savings_loan + '.($fixedEntries->savings_loan ?? 0)),
                    'total_shekel_loan' => DB::raw('total_shekel_loan + '.($fixedEntries->shekel_loan ?? 0)),
                    'total_association_loan' => DB::raw('total_association_loan + '.($fixedEntries->association_loan ?? 0)),
                    'total_receivables' => DB::raw('total_receivables - '.($salary->late_receivables )),
                    'total_savings' => DB::raw('total_savings - '.($fixedEntries->savings_loan ?? 0 + (($fixedEntries->savings_rate ?? 0 + $salary->termination_service ?? 0) / $USD ))),
                ]);
                $salary->forceDelete();
                LogRecord::where('type', 'errorSalary')->where('related_id', "employee_$salary->employee_id")->delete();
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('home')->with('danger', 'تم حذف الراتب لجميع الموظفين للشهر الحالي');
    }
}
