<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\Salary;
use App\Models\Total;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FixedEntriesController extends Controller
{
    protected $thisYear;
    protected $thisMonth;

    public function updateEntries($request,$fieldName,$fieldNameMonth) {
        if($request->{$fieldNameMonth} != ""){
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                if($month >= $this->thisMonth){
                    FixedEntries::updateOrCreate([
                        'employee_id' => $request->employee_id,
                        'month' => $this->thisYear.'-'.$month,
                    ],[
                        "$fieldName" => $request->{$fieldNameMonth},
                    ]);
                    if($request["$month"] != 0){
                        FixedEntries::updateOrCreate([
                            'employee_id' => $request->employee_id,
                            'month' => $this->thisYear.'-'.$month,
                        ],[
                            "$fieldName" => $request["$month"],
                        ]);
                    }
                }
            }
        }
        if($request->{$fieldNameMonth} == ""  || $request->{$fieldNameMonth} == 0  || $request->{$fieldNameMonth} == null){
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                if($request[$month] >= $this->thisMonth){
                    FixedEntries::updateOrCreate([
                        'employee_id' => $request->employee_id,
                        'month' => $this->thisYear.'-'.$month,
                    ],[
                        "$fieldName" => $request["$month"],
                    ]);
                }
            }
        }
    }
    public function __construct(){
        $this->thisYear = Carbon::now()->format('Y');
        $this->thisMonth = Carbon::now()->format('m');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->monthChange == true){
            $fixed_entries = FixedEntries::with(['employee'])->where('month',$request->month)->paginate(10);
            return $fixed_entries;
        }
        $monthNow = Carbon::now()->format('Y-m');
        $fixed_entries = FixedEntries::with(['employee'])->where('month',$monthNow)->paginate(10);
        return view('dashboard.fixed_entries.index', compact('fixed_entries','monthNow'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fixed_entrie = new FixedEntries();
        $fixed_entrie->employee = new Employee();
        $month = $this->thisMonth;
        $year = $this->thisYear;
        $total_association_loan_old = "";
        $total_shekel_loan_old = "";
        $total_savings_loan_old = "";


        return view('dashboard.fixed_entries.create', compact('fixed_entrie','month','year','total_association_loan_old','total_shekel_loan_old','total_savings_loan_old'));
    }

    /**
     * Store a newly created resource in storage.
     */
        // $request->validate([
    //     'employee_id' => [
    //         'required',
    //         Rule::unique('fixed_entries')->where(function ($query) {
    //             return $query->where('month', $this->month );
    //         }),],
    //     'month' =>"required|date_format:Y-m",
    // ]);
    public function store(Request $request)
    {
        $fields = [
            'administrative_allowance',
            'scientific_qualification_allowance',
            'transport',
            'extra_allowance',
            'salary_allowance',
            'ex_addition',
            'mobile_allowance',
            'health_insurance',
            'f_Oredo',
            'tuition_fees',
            'voluntary_contributions',
            'savings_loan',
            'shekel_loan',
            'paradise_discount',
            'other_discounts',
            'proportion_voluntary',
            'savings_rate',
        ];
        foreach ($fields as $field) {
            if($request->{$field."_create"} == true) {
                $this->updateEntries($request, $field, $field.'_months');
            }
        }
        $fieldsLoan = [
            'association_loan',
            'savings_loan',
            'shekel_loan',
        ];
        foreach ($fieldsLoan as $field) {
            if($request->{$field."_create"} == true) {
                $this->updateEntries($request, $field, $field.'_months');
                Total::updateOrCreate([
                    'employee_id' => $request->employee_id,
                ],[
                    'total_'.$field => $request->post('total_'.$field),
                ]);
            }
        }

        $salary = Salary::where('employee_id',$request->employee_id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee);
        }
    }
    // public Function

    /**
     * Display the specified resource.
     */
    public function show(Request $request, FixedEntries $fixedEntries)
    {
        if ($request->showModel == true) {
            if($request->month){
                $monthNow = $request->month;
                $fixed_entrie = FixedEntries::with('employee')->where('month',$monthNow)->find($request->fixed_entrie);
                return  $fixed_entrie;
            }
            if($request->monthT){
                $fixed_entrie = FixedEntries::with('employee')->find($request->fixed_entrie);
                $fixed_entrie = FixedEntries::with('employee')->where('employee_id',$fixed_entrie->employee_id)->where('month',$request->monthT)->first();
                return  $fixed_entrie;
            }
            return "fixed entrie";
        }
        return redirect()->route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fixed_entrie = FixedEntries::with(['employee'])->where('employee_id',$id)->get();
        $fixed_entrie['employee'] = FixedEntries::with(['employee'])->where('employee_id',$id)->first()->employee;
        $total_association_loan_old = (Total::where('employee_id',$id)->first() == null) ? 0 : Total::where('employee_id',$id)->first()['total_association_loan'];
        $total_shekel_loan_old = (Total::where('employee_id',$id)->first() == null) ? 0 : Total::where('employee_id',$id)->first()['total_shekel_loan'];
        $total_savings_loan_old = (Total::where('employee_id',$id)->first() == null) ? 0 : Total::where('employee_id',$id)->first()['total_savings_loan'];
        $btn_label = "تعديل";
        $month = $this->thisMonth;
        $year = $this->thisYear;
        return view('dashboard.fixed_entries.edit', compact('fixed_entrie','btn_label','month','year','total_association_loan_old','total_shekel_loan_old','total_savings_loan_old'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $salary = Salary::where('employee_id',$id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee);
        }
        return redirect()->route('fixed_entries.index')->with('success','تم تحديث الثوابت بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fixedEntries = FixedEntries::findOrFail($id);
        $fixedEntries->delete();
        return redirect()->route('fixed_entries.index')->with('danger','تم حذف الثوابت للموضف بنجاح');
    }


    // others Functions
    public function getFixedEntriesData(Request $request){
        $totals = Total::where('employee_id',$request->employee_id)->first();
        if($totals == null){
            return  0.00;
        }
        return [
            'total_association_loan' => $totals->total_association_loan,
            'total_shekel_loan' => $totals->total_shekel_loan,
            'total_savings_loan' => $totals->total_savings_loan
        ];
    }
    public function getFixedEntriesFialds($fixed_entrie,$year,$month,$filedName){
        $reslut = $fixed_entrie->where('month',($year . '-' . $month))->first();
        if($reslut == null){
            return $reslut = 0.00;
        }
        return $reslut[$filedName];
    }
}
