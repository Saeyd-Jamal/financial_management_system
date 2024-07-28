<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Models\BanksEmployees;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class SalaryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Salary::class);
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
        $btn_delete_salary = $salaries->isNotEmpty() ? "active" : null;
        return view('dashboard.salaries.index', compact('salaries','btn_download_salary','btn_delete_salary','USD'));
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
        $account_number = BanksEmployees::where('id', $salary->account_number)->first()->account_number;
        $salary->account_number = $account_number;
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
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('salaries.index')->with('danger', 'تم حذف الراتب لجميع الموظفين للشهر الحالي');
    }



    // PDF Export
    public function viewPDF()
    {

        $salaries = Salary::get();
        $month = Carbon::now()->format('Y-m');
        $USD = Currency::where('code', 'USD')->first() != null ? Currency::where('code', 'USD')->first()->value : 3.5;
        $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
            $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
            return [
                "secondary_salary" => $salary->secondary_salary ?? '0',
                'allowance_boys' => $salary->allowance_boys ?? '0',
                'nature_work_increase' => $salary->nature_work_increase ?? '0',
                'administrative_allowance' => $fixedEntries->administrative_allowance ?? '0',
                'scientific_qualification_allowance' => $fixedEntries->scientific_qualification_allowance ?? '0',
                'transport' => $fixedEntries->transport ?? '0',
                'extra_allowance' => $fixedEntries->extra_allowance ?? '0',
                'salary_allowance' => $fixedEntries->salary_allowance ?? '0',
                'ex_addition' => $fixedEntries->ex_addition ?? '0',
                'mobile_allowance' => $fixedEntries->mobile_allowance ?? '0',
                'termination_service' => $salary->termination_service ?? '0',
                'gross_salary' => ($salary->grade_Allowance + ($salary->total_discounts - $salary->late_receivables)) ?? '0',
                'health_insurance' => $fixedEntries->health_insurance ?? '0',
                'z_Income' => $salary->z_Income ?? '0',
                'savings_rate' => $fixedEntries->savings_rate ?? '0',
                'association_loan' => $fixedEntries->association_loan ?? '0',
                'savings_loan' => $fixedEntries->savings_loan ?? '0',
                'shekel_loan' => $fixedEntries->shekel_loan ?? '0',
                'late_receivables' => $salary->late_receivables ?? '0',
                'total_discounts' => $salary->total_discounts ?? '0',
                'net_salary' => $salary->net_salary ?? '0',
            ];
        });
        $salariesTotalArray = [
            'secondary_salary' => collect($salariesTotal->pluck('secondary_salary')->toArray())->sum(),
            'allowance_boys' => collect($salariesTotal->pluck('allowance_boys')->toArray())->sum(),
            'nature_work_increase' => collect($salariesTotal->pluck('nature_work_increase')->toArray())->sum(),
            'administrative_allowance' => collect($salariesTotal->pluck('administrative_allowance')->toArray())->sum(),
            'scientific_qualification_allowance' => collect($salariesTotal->pluck('scientific_qualification_allowance')->toArray())->sum(),
            'transport' => collect($salariesTotal->pluck('transport')->toArray())->sum(),
            'extra_allowance' => collect($salariesTotal->pluck('extra_allowance')->toArray())->sum(),
            'salary_allowance' => collect($salariesTotal->pluck('salary_allowance')->toArray())->sum(),
            'ex_addition' => collect($salariesTotal->pluck('ex_addition')->toArray())->sum(),
            'mobile_allowance' => collect($salariesTotal->pluck('mobile_allowance')->toArray())->sum(),
            'termination_service' => collect($salariesTotal->pluck('termination_service')->toArray())->sum(),
            'gross_salary' => collect($salariesTotal->pluck('gross_salary')->toArray())->sum(),
            'health_insurance' => collect($salariesTotal->pluck('health_insurance')->toArray())->sum(),
            'z_Income' => collect($salariesTotal->pluck('z_Income')->toArray())->sum(),
            'savings_rate' => collect($salariesTotal->pluck('savings_rate')->toArray())->sum(),
            'association_loan' => collect($salariesTotal->pluck('association_loan')->toArray())->sum(),
            'savings_loan' => collect($salariesTotal->pluck('savings_loan')->toArray())->sum(),
            'shekel_loan' => collect($salariesTotal->pluck('shekel_loan')->toArray())->sum(),
            'late_receivables' => collect($salariesTotal->pluck('late_receivables')->toArray())->sum(),
            'total_discounts' => collect($salariesTotal->pluck('total_discounts')->toArray())->sum(),
            'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
        ];

        $html = view('dashboard.pdf.salaries', compact('salaries','month','salariesTotalArray','USD'))->render();

        // إعدادات mPDF
        $mpdfConfig = [
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'Arial'
        ];

        $mpdf = new Mpdf($mpdfConfig);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }


}
