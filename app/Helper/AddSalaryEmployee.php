<?php

namespace App\Helper;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Models\Bank;
use App\Models\Constant;
use App\Models\Currency;
use App\Models\NatureWorkIncrease;
use App\Models\Salary;
use App\Models\SalaryScale;
use Carbon\Carbon;

class AddSalaryEmployee{

    public function __construct()
    {
        //
    }

    public static function addSalary($employee)
    {
        // الشهر الحالي
        $thisMonth = Carbon::now()->format('m');
        // السنة الحالية
        $thisYear = Carbon::now()->format('Y');
        $USD = Currency::where('code','USD')->first('value')->value;
        // مزدوج الوظيفة
        $government_official = $employee->government_official;
        if($government_official == "غير موظف"){
            $government_official = null;
        }
        // مبلغ السلفة من حالة الدوام
        $working_status = $employee->workData->working_status;
        if($working_status == "مداوم"){
            $advance_payment = Constant::where('type_constant','advance_payment_permanent')->first('value')->value;
        }elseif($working_status == "غير مداوم"){
            $advance_payment = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value;
        }elseif($working_status == "رياض"){
            $advance_payment = Constant::where('type_constant','advance_payment_riyadh')->first('value')->value;
        }elseif($working_status == "نسبة"){
            $advance_payment = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
        }else{
            $advance_payment = 0;
        }

        //  البنك المتعامل معه
        foreach ($employee->banks as $bank) {
            $account_default = $bank->bank_employee->where('default',1)->first();
        }
        $bank = Bank::find($account_default->bank_id)->first()->name;
        $branch_number = Bank::find($account_default->bank_id)->first()->branch_number;
        $account_number = $account_default->account_number;


        // الحسابات
        $percentage_allowance = NatureWorkIncrease::where('nature_work',$employee->workData->nature_work)->where('scientific_qualification',$employee->scientific_qualification)->first()->percentage; //نسبة علاوة من طبيعة العمل
        $initial_salary = SalaryScale::where('id',$employee->workData->allowance)->first()->{$employee->workData->grade}; // الراتب الأولي

        $grade_Allowance = ($initial_salary * $percentage_allowance); // علاوة درجة
        $secondary_salary = $initial_salary + $grade_Allowance; // الراتب الثانوي

        // الإضافات الثابتة
        if($employee->type_appointment == 'مثبت' && $employee->matrimonial_status == "متزوج"){
            $allowance_boys = (($employee->number_children * 20) + 60);
        }elseif($employee->type_appointment == 'مثبت' && $employee->matrimonial_status == "متزوج - موظفة حكومة"){
            $allowance_boys = ($employee->number_children * 20);
        }else{
            $allowance_boys = 0;
        }
        $nature_work_increase =  ($percentage_allowance * $secondary_salary); // علاوة طبيعة العمل

        // المدخلات الثابتة
        foreach($employee->fixedEntries as $fixedEntries){
            if($fixedEntries->month == $thisYear.'-'.$thisMonth){
                $fixedEntries = $employee->fixedEntries;
            }
        }

        $administrative_allowance = $fixedEntries->administrative_allowance;
        $scientific_qualification_allowance = $fixedEntries->scientific_qualification_allowance;
        $transport = $fixedEntries->transport;
        $extra_allowance = $fixedEntries->extra_allowance;
        $salary_allowance = $fixedEntries->salary_allowance;
        $ex_addition = $fixedEntries->ex_addition;
        $mobile_allowance = $fixedEntries->mobile_allowance;

        $termination_service = $government_official == null ? (($secondary_salary+$nature_work_increase+$administrative_allowance)*0.1) : 0;

        $total_additions = ($allowance_boys + $nature_work_increase + $administrative_allowance + $scientific_qualification_allowance + $transport + $extra_allowance + $salary_allowance + $ex_addition + $mobile_allowance +$termination_service);

        // الخصومات
        $health_insurance = $fixedEntries->health_insurance;
        $f_Oredo = $fixedEntries->f_Oredo;
        $association_loan = $fixedEntries->association_loan;
        $tuition_fees = $fixedEntries->tuition_fees;
        $voluntary_contributions = $fixedEntries->voluntary_contributions;
        $savings_loan = $fixedEntries->savings_loan;
        $shekel_loan = $fixedEntries->shekel_loan;
        $paradise_discount = $fixedEntries->paradise_discount;
        $other_discounts = $fixedEntries->other_discounts;
        $proportion_voluntary = $fixedEntries->proportion_voluntary;
        $savings_5 = $fixedEntries->savings_5;


        // إضافات للمبلغ الضريبية
        $amount_tax = $working_status == "مداوم" ? ($secondary_salary + $nature_work_increase - $termination_service - $health_insurance - $savings_5 - $voluntary_contributions) : 0; // المبلغ الضريبي

        $exemptions = ($government_official == "غير موظف") ? (3000 + ($employee->matrimonial_status == "متزوج"? 500 : 0) + ($employee->matrimonial_status == "متزوج - موظفة وكالة"? $employee->number_children *500 : 0) +  ($employee->matrimonial_status == "متزوج - موظفة حكومة"? $employee->number_children *500 : 0) + ($employee->number_university_children * 12)) / 12 : 0; // الاعفاءات

        $tax = (($amount_tax / $USD)-$exemptions < 0)? 0 : (($amount_tax / $USD)-$exemptions); // الضريبة

        $resident_exemption = ($government_official == "غير موظف") ? 0 : 3000; // إعفاء مقيم

        $annual_taxable_amount = $tax * 12 ; // مبلغ الضريبة الخاضع السنوي

        // ضريبة الدخل
        if($annual_taxable_amount<=10000){
            $z_Income = $annual_taxable_amount*0.08;
        }elseif($annual_taxable_amount<=16000){
            $z_Income = 800+(($annual_taxable_amount-10000)*0.12);
        }elseif($annual_taxable_amount>16000){
            $z_Income = 800+720+(($annual_taxable_amount-16000)*0.16);
        }else{
            $z_Income = 0;
        }
        $z_Income = ($z_Income / 12) * $USD;

        $total_discounts = ($termination_service + $health_insurance + $f_Oredo + $association_loan + $tuition_fees + $voluntary_contributions + $savings_loan + $shekel_loan + $paradise_discount + $other_discounts + $proportion_voluntary + $savings_5 + $z_Income);

        // إجمالي الراتب
        $gross_salary = ($secondary_salary + $total_additions) - $total_discounts;


        $late_receivables = ($gross_salary >= $advance_payment) ? $gross_salary - $advance_payment : 0; // مستحقات متأخرة

        $net_salary = ($gross_salary - ($total_discounts + $late_receivables));

        $amount_letters = Numbers::TafqeetMoney($net_salary,'ILS'); // المبلغ بالنص


        Salary::updateOrCreate([
            'employee_id' => $employee->id,
            'month' => ($thisYear.'-'.$thisMonth),
        ],[
            //new
            'percentage_allowance' => $percentage_allowance,
            'initial_salary' => $initial_salary,
            'grade_Allowance' => $grade_Allowance,
            'secondary_salary' => $secondary_salary,
            'allowance_boys' => $allowance_boys,
            'nature_work_increase' => $nature_work_increase,
            'termination_service' =>$termination_service,
            'z_Income' => $z_Income,
            'gross_salary' => $gross_salary,
            'late_receivables' => $late_receivables,
            'total_discounts' => $total_discounts + $late_receivables,
            'net_salary' => $net_salary,
            'amount_letters' => $amount_letters,
            'bank' => $bank,
            'branch_number' => $branch_number,
            'account_number' => $account_number,
            'resident_exemption' => $resident_exemption,
            'annual_taxable_amount' => $annual_taxable_amount,
            'tax' => $tax,
            'exemptions' => $exemptions,
            'amount_tax' => $amount_tax,
        ]);
    }
}
