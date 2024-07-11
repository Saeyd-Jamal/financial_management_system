<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\Total;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        return view('dashboard.fixed_entries.create', compact('fixed_entrie','month','year','total_association_loan_old'));
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
        if($request->{"administrative_allowance"."_create"} == true){
            $this->updateEntries($request,"administrative_allowance","administrative_allowance".'_months');
            return $request->all();
        }
        if($request->{"scientific_qualification_allowance"."_create"} == true){
            $this->updateEntries($request,"scientific_qualification_allowance","scientific_qualification_allowance".'_months');
        }
        if($request->{"transport"."_create"} == true){
            $this->updateEntries($request,"transport","transport".'_months');
        }
        if($request->{"extra_allowance"."_create"} == true){
            $this->updateEntries($request,"extra_allowance","extra_allowance".'_months');
        }
        if($request->{"salary_allowance"."_create"} == true){
            $this->updateEntries($request,"salary_allowance","salary_allowance".'_months');
        }
        if($request->{"ex_addition"."_create"} == true){
            $this->updateEntries($request,"ex_addition","ex_addition".'_months');
        }
        if($request->{"mobile_allowance"."_create"} == true){
            $this->updateEntries($request,"mobile_allowance","mobile_allowance".'_months');
        }
        if($request->{"health_insurance"."_create"} == true){
            $this->updateEntries($request,"health_insurance","health_insurance".'_months');
        }
        if($request->{"f_Oredo"."_create"} == true){
            $this->updateEntries($request,"f_Oredo","f_Oredo".'_months');
        }
        if($request->{"association_loan"."_create"} == true){
            $this->updateEntries($request,"association_loan","association_loan".'_months');
            $totals = Total::where('employee_id',$request->employee_id)->first();
            $totals->update([
                'total_association_loan' => $request->post('total_association_loan'),
            ]);
        }
        if($request->{"tuition_fees"."_create"} == true){
            $this->updateEntries($request,"tuition_fees","tuition_fees".'_months');
        }
        if($request->{"voluntary_contributions"."_create"} == true){
            $this->updateEntries($request,"voluntary_contributions","voluntary_contributions".'_months');
        }
        if($request->{"savings_loan"."_create"} == true){
            $this->updateEntries($request,"savings_loan","savings_loan".'_months');
        }
        if($request->{"shekel_loan"."_create"} == true){
            $this->updateEntries($request,"shekel_loan","shekel_loan".'_months');
        }
        if($request->{"paradise_discount"."_create"} == true){
            $this->updateEntries($request,"paradise_discount","paradise_discount".'_months');
        }
        if($request->{"other_discounts"."_create"} == true){
            $this->updateEntries($request,"other_discounts","other_discounts".'_months');
        }
        if($request->{"proportion_voluntary"."_create"} == true){
            $this->updateEntries($request,"proportion_voluntary","proportion_voluntary".'_months');
        }
        if($request->{"savings_5"."_create"} == true){
            $this->updateEntries($request,"savings_5","savings_5".'_months');
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
        $total_association_loan_old = Total::where('employee_id',$id)->first()['total_association_loan'];
        $btn_label = "تعديل";
        $month = $this->thisMonth;
        $year = $this->thisYear;
        return view('dashboard.fixed_entries.edit', compact('fixed_entrie','btn_label','month','year','total_association_loan_old'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fixedEntries = FixedEntries::with(['employee'])->findOrFail($id);

        $all = $request->all();
        foreach ($all as $key => $value) {
            if($value == null){
                $all[$key] = 0.00;
            }
        }
        $fixedEntries->update($all);
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
    public function associationLoan(Request $request){
        if($request->association_loan == ""){
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                if($request[$month] != null){
                    FixedEntries::updateOrCreate([
                        'employee_id' => $request->employee_id,
                        'month' => $this->thisYear.'-'.$month,
                    ],[
                        'association_loan' => $request["$month"],
                    ]);
                }
            }
            Total::updateOrCreate([
                'employee_id' => $request->employee_id,
            ],[
                'total_association_loan' => $request->post('total_association_loan'),
            ]);
        }
    }
    public function getFixedEntriesData(Request $request){
        $totals = Total::where('employee_id',$request->employee_id)->first();
        if($totals == null){
            return  0.00;
        }
        return $totals->total_association_loan;
    }
    public function getFixedEntriesFialds($fixed_entrie,$year,$month,$filedName){
        $reslut = $fixed_entrie->where('month',($year . '-' . $month))->first();
        if($reslut == null){
            return $reslut = 0.00;
        }
        return $reslut[$filedName];
    }
}
