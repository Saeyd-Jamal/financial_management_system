<?php

namespace App\Http\Controllers\Dashboard;
;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SpecificSalary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecificSalaryController extends Controller
{
    protected $thisMonth;

    public function __construct(){
        $this->thisMonth = '2024-07' ; //Carbon::now()->format('Y-m')
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::paginate();
        return view('dashboard.specific_salaries.index', compact('employees'));
    }

    // النسبة
    public function ratio(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'نسبة');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.ratio', compact('employees','month'));
    }
    public function ratioCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب الخاص للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.ratio')->with('success', 'تم إعداد الراتب للموظفين النسبة');
    }

    // خاص
    public function private(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'خاص');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.private', compact('employees','month'));
    }
    public function privateCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب الخاص للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.private')->with('success', 'تم إعداد الراتب للموظفين الخاص');
    }

    // رياض
    public function riyadh(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'رياض');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.riyadh', compact('employees','month'));
    }
    public function riyadhCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب المحدد للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.riyadh')->with('success', 'تم إعداد الراتب لموظفين الرياض');
    }

    // فصلي
    public function fasle(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'فصلي');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.fasle', compact('employees','month'));
    }
    public function fasleCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب المحدد للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.fasle')->with('success', 'تم إعداد الراتب لموظفين الفصلي');
    }

    // مؤقت
    public function interim(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'مؤقت');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.interim', compact('employees','month'));
    }
    public function interimCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب المحدد للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.interim')->with('success', 'تم إعداد الراتب لموظفين المؤقتين');
    }

    // اليومي

    public function daily(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'يومي');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.daily', compact('employees','month'));
    }
    public function dailyCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب المحدد للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'number_of_days' => $request->number_of_days[$employee_id],
                    'today_price' => $request->today_price[$employee_id],
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.daily')->with('success', 'تم إعداد الراتب للموظفين اليوميين');
    }
}
