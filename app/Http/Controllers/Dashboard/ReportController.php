<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\EmployeesDataExport;
use App\Exports\ModelExport;
use App\Http\Controllers\Controller;
use App\Models\BanksEmployees;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use App\Models\Bank;

class ReportController extends Controller
{

    use AuthorizesRequests;
    protected $monthNameAr;

    public function __construct(){
        // مصفوفة لأسماء الأشهر باللغة العربية
        $this->monthNameAr = [
            '01' => 'يناير',
            '02' => 'فبراير',
            '03' => 'مارس',
            '04' => 'أبريل',
            '05' => 'مايو',
            '06' => 'يونيو',
            '07' => 'يوليو',
            '08' => 'أغسطس',
            '09' => 'سبتمبر',
            '10' => 'أكتوبر',
            '11' => 'نوفمبر',
            '12' => 'ديسمبر'
        ];
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
        $this->authorize('report.view');
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
        $banksId = BanksEmployees::select('bank_id')->distinct()->pluck('bank_id')->toArray();
        $banks = Bank::select('name')->distinct()->pluck('name')->toArray();
        $month = Carbon::now()->format('Y-m');

        return view('dashboard.report',compact("areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","payroll_statement",'month','banks'));
    }


    public function export(Request $request){
        $time = Carbon::now();
        $employees = $this->filterEmployees($request->all())->get();
        if($request->report_type == 'employees'){
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('سجلات الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'رقم الموظف',
                    'اسم الموظف',
                    'رقم الهوية',
                    'تاريخ الميلاد',
                    'العمر',
                    'الجنس',
                    'الحالة الزوجية',
                    'عدد الزوجات',
                    'عدد الأولاد',
                    'عدد أولاد الجامعة',
                    'المؤهل العلمي',
                    'التخصص',
                    'الجامعة',
                    'المنطقة',
                    'العنوان',
                    'الإيميل',
                    'رقم الهاتف',
                    'العلاوة',
                    'الدرجة',
                    'نسبة علاوة درجة',
                    'فئة الراتب',
                    'تاريخ العمل',
                    'تاريخ التثبيت',
                    'تاريخ التقاعد',
                    'حالة الدوام',
                    'نوع التعين',
                    'مجال العمل',
                    'مزدوج وظيفة',
                    'حالة الفعالية',
                    'سنوات الخدمة',
                    'طبيعة العمل',
                    'الجمعية',
                    'مكان العمل',
                    'القسم',
                    'التبعية',
                    'المنشأة',
                    'المؤسسة',
                    'بيان الراتب',
                ];
                $employees = $this->filterEmployees($request->all())
                                ->join('work_data', 'work_data.employee_id', '=', 'employees.id')
                                ->select(
                                    'employees.id',
                                    'employees.name',
                                    'employees.employee_id',
                                    'employees.date_of_birth',
                                    'employees.age',
                                    'employees.gender',
                                    'employees.matrimonial_status',
                                    'employees.number_wives',
                                    'employees.number_children',
                                    'employees.number_university_children',
                                    'employees.scientific_qualification',
                                    'employees.specialization',
                                    'employees.university',
                                    'employees.area',
                                    'employees.address',
                                    'employees.email',
                                    'employees.phone_number',
                                    'work_data.allowance',
                                    'work_data.grade',
                                    'work_data.grade_allowance_ratio',
                                    'work_data.salary_category',
                                    'work_data.working_date',
                                    'work_data.date_installation',
                                    'work_data.date_retirement',
                                    'work_data.working_status',
                                    'work_data.type_appointment',
                                    'work_data.field_action',
                                    'work_data.dual_function',
                                    'work_data.state_effectiveness',
                                    'work_data.years_service',
                                    'work_data.nature_work',
                                    'work_data.association',
                                    'work_data.workplace',
                                    'work_data.section',
                                    'work_data.dependence',
                                    'work_data.establishment',
                                    'work_data.foundation_E',
                                    'work_data.payroll_statement',
                                )
                                ->get();


                $filename = 'سجلات الموظفين' . $time .'.xlsx';
                return Excel::download(new ModelExport($employees,$headings), $filename);
            }
        }
        // الرواتب
        if($request->report_type == 'salaries'){
            $USD = Currency::where('code', 'USD')->first()->value;
            $month = $request->month ?? Carbon::now()->format('Y-m');

            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                ->where('month', $month)
                ->get();

            // دوال الموجوع اخر سطر في التقرير
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
                    "gross_salary" => $salary->gross_salary?? 0,
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

            if($request->export_type == 'view' || $request->export_type == 'export_excel'){
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
                $headings = [
                    'الاسم',
                    'الشهر',
                    'مكان العمل',
                    'الراتب الاساسي',
                    'علاوة الأولاد',
                    'علاوة طبيعة العمل',
                    'علاوة إدارية',
                    'علاوة مؤهل علمي',
                    'المواصلات',
                    'بدل إضافي +-',
                    'علاوة أغراض راتب',
                    'إضافة بأثر رجعي',
                    'علاوة جوال',
                    'نهاية الخدمة',
                    'إجمالي الراتب',
                    'تأمين صحي',
                    'ض.دخل',
                    'إدخار 5%',
                    'قرض الجمعية',
                    'قرض الإدخار',
                    'قرض شيكل',
                    'مستحقات متأخرة',
                    'إجمالي الخصومات',
                    'صافي الراتب'
                ];

                $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                        ->where('month', $month)
                        ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                        ->join('work_data as workData', 'employees.id', '=', 'workData.employee_id')
                        ->join('fixed_entries as fixedEntries', function ($join) use ($month) {
                            $join->on('employees.id', '=', 'fixedEntries.employee_id')
                                ->where('fixed_entries.month', $month);
                        })
                        ->select('employees.name', 'salaries.month','workData.workplace', 'salaries.secondary_salary', 'salaries.allowance_boys', 'salaries.nature_work_increase','fixedEntries.administrative_allowance', 'fixedEntries.	scientific_qualification_allowance', 'fixedEntries.transport', 'fixedEntries.extra_allowance', 'fixedEntries.salary_allowance', 'fixedEntries.ex_addition', 'fixedEntries.mobile_allowance', 'salaries.termination_service', 'salaries.gross_salary', 'fixedEntries.health_insurance', 'salaries.z_Income' , 'fixedEntries.savings_rate', 'fixedEntries.association_loan', 'fixedEntries.savings_loan', 'fixedEntries.shekel_loan', 'salaries.late_receivables', 'salaries.total_discounts', 'salaries.net_salary')
                        ->get();

                $filename = 'سجلات رواتب الموظفين' . $time .'.xlsx';
                return Excel::download(new ModelExport($salaries,$headings), $filename);
            }
        }

        // حسابات الموظفين في البنوك
        if($request->report_type == 'accounts'){
            $accounts = BanksEmployees::whereIn('employee_id', $employees->pluck('id'))->get();
            // معاينة pdf
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.accounts',['accounts' =>  $accounts,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.accounts',['accounts' =>  $accounts,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('سجلات حسابات الموظفين في البنوك' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'اسم الموظف',
                    'اسم البنك',
                    'الفرع',
                    'رقم الفرع',
                    'رقم الحساب',
                    'أساسي؟',
                ];
                $accounts = BanksEmployees::whereIn('banks_employees.employee_id', $employees->pluck('id'))
                            ->join('employees', 'banks_employees.employee_id', '=', 'employees.id')
                            ->join('banks', 'banks_employees.bank_id', '=', 'banks.id')
                            ->select('employees.name as employee_name','banks.name as bank_name','banks.branch as branch_name','banks.branch_number as branch_number','banks_employees.account_number','banks_employees.default')
                            ->get();


                $filename = 'كشف حسابات الموظفين_' . $time .'.xlsx';
                return Excel::download(new ModelExport($accounts,$headings), $filename);
            }
        }

        // سجلات لمستحقات وقروض الموظفين
        if($request->report_type == 'employees_totals'){
            $totals = ReceivablesLoans::whereIn('employee_id', $employees->pluck('id'))->get();

            // معاينة pdf
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.totals',['totals' =>  $totals,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.totals',['totals' =>  $totals,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('سجلات لمستحقات وقروض الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'اسم الموظف',
                    'إجمالي المستحقات',
                    'إجمالي الإدخارات $',
                    'إجمالي قرض الجمعية',
                    'إجمالي قرض الإدخار$',
                    'إجمالي قرض اللجنة (الشيكل)',
                ];
                $totals = ReceivablesLoans::whereIn('totals.employee_id', $employees->pluck('id'))
                            ->join('employees', 'totals.employee_id', '=', 'employees.id')
                            ->select('employees.name as employee_name','totals.total_receivables','totals.total_savings','totals.total_association_loan','totals.total_shekel_loan','totals.total_savings_loan')
                            ->get();

                $filename = 'كشف المستحقات والقروض_' . $time .'.xlsx';
                return Excel::download(new ModelExport($totals,$headings), $filename);
            }
        }

        // التعديلات للموظفين
        if($request->report_type == 'employees_fixed'){
            $month = $request->month ?? Carbon::now()->format('Y-m');

            $fixed_entries = FixedEntries::whereIn('employee_id', $employees->pluck('id'))
                ->where('month', $month)
                ->get();

            // معاينة pdf
            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.pdf.fixed_entries',['fixed_entries' =>  $fixed_entries,'filter' => $request->all(),'month' => $month],[],[
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }

            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $pdf = PDF::loadView('dashboard.pdf.fixed_entries',['fixed_entries' =>  $fixed_entries,'filter' => $request->all(),'month' => $month],[],[
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('سجلات التعديلات_' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'اسم الموظف',
                    'الشهر',
                    'علاوة إدارية',
                    'علاوة مؤهل علمي',
                    'مواصلات',
                    'بدل إضافي',
                    'علاوة اغراض راتب',
                    'إضافة بأثر رجعي',
                    'علاوة جوال',
                    'تأمين صحي',
                    'فاتورة وطنية',
                    'قرض الجمعية',
                    'رسوم دراسية',
                    'تبرعات',
                    'قرض إدخار',
                    'قرض شيكل',
                    'خصم اللجنة',
                    'خصومات أخرى',
                    'تبرعات الحركة',
                    'إدخار 5%',
                ];

                $fixed_entries = FixedEntries::whereIn('fixed_entries.employee_id', $employees->pluck('id'))
                            ->where('fixed_entries.month', $month)
                            ->join('employees', 'fixed_entries.employee_id', '=', 'employees.id')
                            ->select('employees.name as employee_name','fixed_entries.month','fixed_entries.administrative_allowance','fixed_entries.scientific_qualification_allowance','fixed_entries.transport','fixed_entries.extra_allowance','fixed_entries.salary_allowance','fixed_entries.ex_addition','fixed_entries.mobile_allowance','fixed_entries.health_insurance','fixed_entries.f_Oredo','fixed_entries.association_loan','fixed_entries.tuition_fees','fixed_entries.voluntary_contributions','fixed_entries.savings_loan','fixed_entries.shekel_loan','fixed_entries.paradise_discount','fixed_entries.other_discounts','fixed_entries.proportion_voluntary','fixed_entries.savings_rate')
                            ->get();
                $filename = 'كشف التعديلات_' . $time .'.xlsx';
                return Excel::download(new ModelExport($fixed_entries,$headings), $filename);
            }
        }

        // كشف البنك
        if($request->report_type == 'bank'){
            $USD = Currency::where('code', 'USD')->first()->value;
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $monthName = $this->monthNameAr[Carbon::parse($month)->format('m')];
            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                    ->where('month', $month);
                    if($request->bank != null){
                        $salaries = $salaries->where('bank', $request->bank);
                    }
            $salaries = $salaries->get();

            // دوال الموجوع اخر سطر في التقرير
            $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
                $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                return [
                    'net_salary' => $salary->net_salary ?? '0',
                ];
            });
            $salariesTotalArray = [
                'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
            ];

            // معاينة pdf
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.bank',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $month,'monthName' => $monthName,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.bank',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $month,'monthName' => $monthName,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('كشف الصرف_' . $time .'.pdf');
            }

            if($request->export_type == 'export_excel'){
                if ($request->exchange_type == 'cash') {
                    $headings = [
                        'مكان العمل',
                        'رقم الهوية',
                        'السكن',
                        'الاسم',
                        'صافي الراتب',
                        'التوقيع'
                    ];

                    $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                                ->where('salaries.month', $month)
                                ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                ->join('work_data', 'salaries.employee_id', '=', 'work_data.employee_id')
                                ->select('work_data.workplace as employee_workplace','employees.employee_id as employee_id','employees.area as employee_area','employees.name as employee_name','salaries.net_salary')
                                ->get();
                }
                if ($request->exchange_type == 'bank') {
                    $headings = [
                        'مكان العمل',
                        'البنك',
                        'رقم الهوية',
                        'السكن',
                        'الاسم',
                        'رقم الحساب',
                        'رقم الفرع',
                        'صافي الراتب',
                        'التوقيع'
                    ];

                    $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                                ->where('salaries.month', $month)
                                ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                ->join('work_data', 'salaries.employee_id', '=', 'work_data.employee_id')
                                ->select('work_data.workplace as employee_workplace','salaries.bank','employees.employee_id as employee_id','employees.area as employee_area','employees.name as employee_name','salaries.account_number','salaries.branch_number','salaries.net_salary')
                                ->get();
                }


                $filename = 'كشف الصرف_' . $time .'.xlsx';
                return Excel::download(new ModelExport($salaries,$headings), $filename);
            }
        }
    }

}
