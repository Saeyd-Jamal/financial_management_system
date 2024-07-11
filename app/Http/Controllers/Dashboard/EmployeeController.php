<?php

namespace App\Http\Controllers\Dashboard;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequset;
use App\Imports\EmployeesImport;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\SalaryScale;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('employees.view');
        $employees = Employee::orderBy('name')->paginate(10);
        return view('dashboard.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $advance_payment_rate = $this->advance_payment_rate;
        $advance_payment_permanent = $this->advance_payment_permanent;
        $advance_payment_non_permanent = $this->advance_payment_non_permanent;
        $advance_payment_riyadh = $this->advance_payment_riyadh;
        $areas = $this->areas;
        $working_status = $this->working_status;
        $nature_work = $this->nature_work;
        $type_appointment = $this->type_appointment;
        $government_official = $this->government_official;
        $field_action = $this->field_action;
        $matrimonial_status = $this->matrimonial_status;
        $scientific_qualification = $this->scientific_qualification;
        $state_effectiveness = $this->state_effectiveness;
        $association = $this->association;
        $workplace = $this->workplace;
        $section = $this->section;
        $dependence = $this->dependence;
        $branch = $this->branch;
        $establishment = $this->establishment;
        $foundation_E = $this->foundation_E;
        $employee = new Employee();
        $workData = new WorkData();
        return view('dashboard.employees.create', compact('employee','workData',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","government_official","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","branch","establishment","foundation_E"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequset $request)
    {
        $employee = Employee::create($request->all());
        $request->merge([
            'employee_id' => $employee->id
        ]);
        WorkData::create($request->all());
        return redirect()->route('employees.index')->with('success', 'تم اضافة الموظف الجديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeRequset $request, Employee $employee)
    {
        if ($request->showModel == true) {
            $employee = Employee::with(['workData'])->find($employee->id);
            return $employee;
        }
        return redirect()->route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $advance_payment_rate = $this->advance_payment_rate;
        $advance_payment_permanent = $this->advance_payment_permanent;
        $advance_payment_non_permanent = $this->advance_payment_non_permanent;
        $advance_payment_riyadh = $this->advance_payment_riyadh;
        $areas = $this->areas;
        $working_status = $this->working_status;
        $nature_work = $this->nature_work;
        $type_appointment = $this->type_appointment;
        $government_official = $this->government_official;
        $field_action = $this->field_action;
        $matrimonial_status = $this->matrimonial_status;
        $scientific_qualification = $this->scientific_qualification;
        $state_effectiveness = $this->state_effectiveness;
        $association = $this->association;
        $workplace = $this->workplace;
        $section = $this->section;
        $dependence = $this->dependence;
        $branch = $this->branch;
        $establishment = $this->establishment;
        $foundation_E = $this->foundation_E;
        $btn_label = "تعديل";
        $workData = WorkData::where('employee_id', $employee->id)->first();
        if ($workData == null) {
            $workData = new WorkData();
        }
        return view('dashboard.employees.edit', compact('employee','workData','btn_label',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","government_official","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","branch","establishment","foundation_E"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequset $request, Employee $employee)
    {
        $request->validate([
            'employee_id' => [
                'required',
                'string',
                "unique:employees,employee_id,$request->employee_id,employee_id"
            ]
        ],[
            'unique' => ' هذا الحقل (:attribute) مكرر يرجى التحقق'
        ]);

        $employee->update($request->all());
        $workData = WorkData::where('employee_id', $employee->id)->first();
        $request->merge([
            'employee_id' => $employee->id
        ]);
        WorkData::updateOrCreate([
            'employee_id' => $employee->id
        ], $request->all());


        return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف المختار');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('danger', 'تم حذف بيانات الموظف المحدد');
    }


    // getEmployeeId for tables related to employees
    public function getEmployee(Request $request)
    {
        $employee_search_id = $request->post('employeeId');
        $employee_search_name = $request->post('employeeName');
        $employees = new Employee();
        if($employee_search_id != ""){
            $employees = $employees->where('employee_id','LIKE',"{$employee_search_id}%");
        }
        if($employee_search_name != ""){
            $employees = $employees->where('name','LIKE',"%{$employee_search_name}%");
        }
        return $employees->get();
    }

    // Execl Import
    public function import(Request $request)
    {
        $file = $request->file('fileUplode');
        if($file == null){
            return redirect()->back()->with('error', 'لم يتم رفع الملف بشكل صحيح');
        }
        Excel::import(new EmployeesImport, $file);

        return redirect()->route('employees.index')->with('success', 'تم رفع الملف');
    }
    // PDF Export
    public function viewPDF()
    {
        $employees = Employee::paginate(100);
        $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees]);
        return $pdf->stream();
    }
}
