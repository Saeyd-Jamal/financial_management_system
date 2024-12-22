<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\FixedEntryRequest;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\Salary;
use App\Models\ReceivablesLoans;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FixedEntriesController extends Controller
{
    use AuthorizesRequests;
    public $monthNow;
    public function __construct(){
        $this->monthNow = Carbon::now()->format('Y-m');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', FixedEntries::class);

        if($request->ajax()) {
            // جلب بيانات المستخدمين من الجدول
            $employees = Employee::query();

            $year = $request->year;
            $month_last = Accreditation::orderBy('id', 'desc')->first()->month;
            $month_start  = Carbon::create($year, 1, 1)->format('Y-m');
            $month_end = Carbon::create($year, 12, 31)->format('Y-m');

            foreach ($employees as $employee) {
                $employee->fixedEntries = FixedEntries::whereIn('employee_id', $employee->id)
                    ->whereBetween('month', [$month_start, $month_end])->get();
            }

            return DataTables::of($employees)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('fixedEntriesView', function ($employee)  use ($month_last) {
                        // فلترة البيانات حسب الشهر
                        $filteredEntries = $employee->fixedEntries->where('month', $month_last)->first();
                        if ($filteredEntries != null) {
                            $filteredEntries = $filteredEntries->toJson();
                        }else{
                            $filteredEntries = null;
                        }
                        return $filteredEntries;
                    })
                    ->addColumn('edit', function ($employee) {
                        return $employee->id;
                    })
                    ->addColumn('workplace', function ($employee) {
                        return $employee->workData->workplace;
                    })
                    ->addColumn('association', function ($employee) {
                        return $employee->workData->association;
                    })
                    ->make(true);
        }

        $employee_names = Employee::select('name')->distinct()->pluck('name')->toArray();
        $associations = WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplaces = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $year = Carbon::now()->format('Y');
        $lastMonth = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');
        $lastMonth = Carbon::parse($lastMonth)->format('m');
        return view('dashboard.fixed_entries.index', compact('employee_names', 'associations', 'workplaces', 'year', 'lastMonth'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(FixedEntryRequest $request)
    {
        $this->authorize('create', FixedEntries::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FixedEntryRequest $request)
    {
        $this->authorize('create', FixedEntries::class);

        $salary = Salary::where('employee_id',$request->employee_id)->where('month',$this->monthNow)->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee,$this->monthNow);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, FixedEntries $fixedEntries)
    {

        // return redirect()->route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FixedEntryRequest $request, $id)
    {
        $this->authorize('edit', FixedEntries::class);
        if($request->ajax()) {
            $fixedEntries = FixedEntries::where('employee_id', $id)->first();
            $year = Carbon::parse($fixedEntries->month)->format('Y');
            $month_start  = Carbon::create($year, 1, 1)->format('Y-m');
            $month_end = Carbon::create($year, 12, 31)->format('Y-m');

            $filteredEntries = FixedEntries::where('employee_id', $id)
                                ->whereBetween('month', [$month_start, $month_end])->get();
            return response()->json($filteredEntries);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FixedEntryRequest $request, $id)
    {
        $this->authorize('edit', FixedEntries::class);
        $year = $request->header('year');
        $month_last = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');
        for ($i=1; $i <= 12; $i++) {
            $monthlast = Carbon::parse($month_last)->format('m');
            $i = $i < 10 ? '0'.$i : $i;
            if($i <= $monthlast){
                continue;
            }
            $month = $year.'-'.$i;

            $fixedEntries = FixedEntries::updateOrCreate([
                'employee_id' => $id,
                'month' => $month
            ],[
                'administrative_allowance' => $request['administrative_allowance-'.$i] ?? 0,
                'scientific_qualification_allowance' => $request['scientific_qualification_allowance-'.$i] ?? 0,
                'transport' =>  $request['transport-'.$i] ?? 0,
                'extra_allowance' =>  $request['extra_allowance-'.$i] ?? 0,
                'salary_allowance' =>  $request['salary_allowance-'.$i] ?? 0,
                'ex_addition' => $request['ex_addition-'.$i] ?? 0,
                'mobile_allowance' => $request['mobile_allowance-'.$i] ?? 0,
                'health_insurance' => $request['health_insurance-'.$i] ?? 0,
                'f_Oredo' =>  $request['f_Oredo-'.$i] ?? 0,
                'association_loan' => $request['association_loan-'.$i] ?? 0,
                'tuition_fees' => $request['tuition_fees-'.$i] ?? 0,
                'voluntary_contributions' => $request['voluntary_contributions-'.$i] ?? 0,
                'savings_loan' => $request['savings_loan-'.$i] ?? 0,
                'shekel_loan' =>  $request['shekel_loan-'.$i] ?? 0,
                'paradise_discount' => $request['paradise_discount-'.$i] ?? 0,
                'other_discounts' => $request['other_discounts-'.$i] ?? 0,
                'proportion_voluntary' => $request['proportion_voluntary-'.$i] ?? 0,
                'savings_rate' => $request['savings_rate-'.$i] ?? 0,
            ]);
        }
        $employee = Employee::findOrFail($id);
        $salary = Salary::where('employee_id',$id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee,$this->monthNow);
        }
        if($request->ajax()) {
            return response()->json(['success' => 'تم تحديث الثوابت بنجاح']);
        }
        return redirect()->route('fixed_entries.index')->with('success','تم تحديث الثوابت بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FixedEntryRequest $request ,$id)
    {
        $this->authorize('delete', FixedEntries::class);
        // $fixedEntries = FixedEntries::findOrFail($id);
        // $fixedEntries->delete();
        // return redirect()->route('fixed_entries.index')->with('danger','تم حذف الثوابت للموضف بنجاح');
    }

    public function getData(Request $request){
        $id = $request->id;
        $employee = Employee::with(['workData','totals'])->findOrFail($id);
        return $employee;
    }
}
