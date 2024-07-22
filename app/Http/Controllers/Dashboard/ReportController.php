<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\EmployeesDataExport;
use App\Exports\ModelExport;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ReportController extends Controller
{

    public function __construct(){

    }

    public function filterEmployees($data){
        $employees = Employee::query();
        if($data["scientific_qualification"] != null){
            $employees = Employee::where("scientific_qualification",'=',$data["scientific_qualification"]);
        }
        if($data["area"] != null){
            $employees = $employees->where("area",'=',$data["area"]);
        }
        if($data["gender"] != null){
            $employees = $employees->where("gender",'=',$data["gender"]);
        }
        if($data["matrimonial_status"] != null){
            $employees = $employees->where("matrimonial_status",'=',$data["matrimonial_status"]);
        }
        if($data["working_status"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('working_status','=',$data["working_status"]);
            });
        }
        if($data["type_appointment"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('type_appointment','=',$data["type_appointment"]);
            });
        }
        if($data["field_action"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('field_action','=',$data["field_action"]);
            });
        }
        if($data["dual_function"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('dual_function','=',$data["dual_function"]);
            });
        }
        if($data["state_effectiveness"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('state_effectiveness','=',$data["state_effectiveness"]);
            });
        }
        if($data["nature_work"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('nature_work','=',$data["nature_work"]);
            });
        }
        if($data["association"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('association','=',$data["association"]);
            });
        }
        if($data["workplace"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('workplace','=',$data["workplace"]);
            });
        }
        if($data["section"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('section','=',$data["section"]);
            });
        }
        if($data["dependence"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('dependence','=',$data["dependence"]);
            });
        }
        if($data["establishment"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('establishment','=',$data["establishment"]);
            });
        }
        if($data["payroll_statement"] != null){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->where('payroll_statement','=',$data["payroll_statement"]);
            });
        }


        return $employees;
    }

    public function index(){
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
        return view('dashboard.report',compact("areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","payroll_statement"));
    }
    public function export(Request $request){
        $time = Carbon::now();
        $employees = $this->filterEmployees($request->all())->get();

        if($request->report_type == 'employees'){
            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees,'filter' => $request->all()]);
                return $pdf->stream();
            }
            if($request->export_type == 'export_pdf'){
                $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees,'filter' => $request->all()]);
                return $pdf->download('سجلات الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $filename = 'سجلات الموظفين' . $time .'.xlsx';
                return Excel::download(new EmployeesDataExport, $filename);
            }
        }
        if($request->report_type == 'salaries'){
            $USD = Currency::where('code', 'USD')->first()->value;
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $salaries = $employees->map(function ($employee) use ($month) {
                return $employee->salaries->where('month',$month)->first();
            });
            dd($salaries->first());

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
                    'gross_salary' => $salary->gross_salary + $salary->total_discounts ?? '0',
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

            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.pdf.salaries',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $request->month,'USD' => $USD,'filter' => $request->all()],[],
                [
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }
            if($request->export_type == 'export_pdf'){
                $pdf = PDF::loadView('dashboard.pdf.salaries',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $request->month,'USD' => $USD,'filter' => $request->all()],[],
                [
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('سجلات رواتب الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $filename = 'سجلات رواتب الموظفين' . $time .'.xlsx';
                $salaries = $salaries->with('employee')->select('*','employees.name as employee_id')->get();
                $headings = [];
                return Excel::download(new ModelExport($salaries,$headings), $filename);
            }
        }
        if($request->report_type == 'accounts'){

        }
        if($request->report_type == 'employees_totals'){

        }
        if($request->report_type == 'employees_fixed'){

        }
    }

}
