<?php

namespace App\Http\Controllers\Dashboard;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Exports\EmployeesDataExport;
use App\Exports\EmployeesExport;
use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequset;
use App\Imports\EmployeesImport;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\SalaryScale;
use App\Models\User;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class EmployeeController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(Employee::class, 'employee');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Employee::class);
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();

        $employees = Employee::paginate(10);

        return view('dashboard.employees.index', compact('employees',"areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","payroll_statement"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Employee::class);
        $advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
        $advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value')->value;
        $advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value;
        $advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value')->value;
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $foundation_E = WorkData::select('foundation_E')->distinct()->pluck('foundation_E')->toArray();
        $payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();

        $employee = new Employee();
        $workData = new WorkData();

        return view('dashboard.employees.create', compact('employee','workData',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","foundation_E","payroll_statement"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequset $request)
    {
        $this->authorize('create', Employee::class);
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
    public function show(Request $request, Employee $employee)
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
    public function edit(EmployeeRequset $request,Employee $employee)
    {
        $this->authorize('edit', Employee::class);
        $advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
        $advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value')->value;
        $advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value;
        $advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value')->value;
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $foundation_E = WorkData::select('foundation_E')->distinct()->pluck('foundation_E')->toArray();
        $payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();

        $btn_label = "تعديل";
        $workData = WorkData::where('employee_id', $employee->id)->first();
        if ($workData == null) {
            $workData = new WorkData();
        }

        return view('dashboard.employees.edit', compact('employee','workData','btn_label',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","foundation_E","payroll_statement"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequset $request, Employee $employee)
    {
        $this->authorize('edit', Employee::class);
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
        $salary = Salary::where('employee_id',$employee->id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee);
        }
        // AddSalaryEmployee::addSalary($employee);
        return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف المختار');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeRequset $request,Employee $employee)
    {
        $this->authorize('delete', Employee::class);
        $employee->delete();
        return redirect()->route('employees.index')->with('danger', 'تم حذف بيانات الموظف المحدد');
    }


    // getEmployeeId for tables related to employees
    public function getEmployee(Request $request)
    {
        $employee_search_id = $request->get('employeeId');
        $employee_search_name = $request->get('employeeName');
        $employees = new Employee();
        if($employee_search_id != ""){
            $employees = $employees->where('employee_id','LIKE',"{$employee_search_id}%");
        }
        if($employee_search_name != ""){
            $employees = $employees->where('name','LIKE',"%{$employee_search_name}%");
        }


        return $employees->get();
    }

    // filterEmployee function
    public function filterEmployee(Request $request)
    {
        $filedsEmpolyees = [
            'name',
            'employee_id',
            'gender',
            'matrimonial_status',
            'scientific_qualification',
            'area',
        ];
        $filedsWork = [
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'payroll_statement'
        ];

        $employees = new Employee();
        foreach($filedsEmpolyees as $filed){
            $valInput = $request->post($filed);
            if($valInput != null || $valInput != ""){
                $employees = Employee::where($filed,'LIKE',"{$valInput}%");
            }
        }
        foreach($filedsWork as $filed){
            $valInput = $request->post($filed);
            if($valInput != null || $valInput != ""){
                $employees = $employees->whereHas('workData', function($query) use ($filed, $valInput) {
                    $query->where($filed,'LIKE',"{$valInput}%");
                });
            }
        }
        return $employees->get();
    }

    // Execl
    public function import(Request $request)
    {
        $this->authorize('import', Employee::class);
        $file = $request->file('fileUplode');
        if($file == null){
            return redirect()->back()->with('error', 'لم يتم رفع الملف بشكل صحيح');
        }

        Excel::import(new EmployeesImport, $file);

        return redirect()->route('employees.index')->with('success', 'تم رفع الملف');
    }
    public function export(Request $request)
    {
        $this->authorize('export', Employee::class);
        $time = Carbon::now();
        $filename = 'سجلات الموظفين' . $time .'.xlsx';
        return Excel::download(new EmployeesDataExport, $filename);
    }


    // PDF Export
    public function viewPDF(Request $request)
    {
        if($request->has('filter')){
            parse_str( $request->data, $data);
            $filedsEmpolyees = [
                'name',
                'employee_id',
                'gender',
                'matrimonial_status',
                'scientific_qualification',
                'area',
            ];
            $filedsWork = [
                'working_status',
                'type_appointment',
                'field_action',
                'dual_function',
                'state_effectiveness',
                'nature_work',
                'association',
                'workplace',
                'section',
                'dependence',
                'establishment',
                'payroll_statement'
            ];
            $employees = new Employee();
            foreach($filedsEmpolyees as $filed){
                $valInput = $data[$filed];
                if($valInput != ""){
                    $employees = Employee::where($filed,'LIKE',"%{$valInput}%");
                }
            }
            foreach($filedsWork as $filed){
                $valInput = $data[$filed];
                if($valInput != ""){
                    $employees = $employees->whereHas('workData', function($query) use ($filed, $valInput) {
                        $query->where($filed,'LIKE',"%{$valInput}%");
                    });
                }
            }
            session()->put('employees', $employees->get());
            return "filter Done";
        }
        $this->authorize('export', Employee::class);
        $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  session('employees')]);
        session()->remove('employees');
        return $pdf->stream();
    }
}
