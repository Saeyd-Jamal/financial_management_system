<?php

namespace App\Exports;

use App\Models\WorkData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkDataExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'رقم الموظف',
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
    }
    /**
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WorkData::select([
            'employee_id',
            'allowance',
            'grade',
            'grade_allowance_ratio',
            'salary_category',
            'working_date',
            'date_installation',
            'date_retirement',
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'years_service',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'foundation_E',
            'payroll_statement',
        ])->orderBy('employee_id')->get();
    }
}
