<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection,WithHeadings
{

    public function headings(): array
    {
        return [
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
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Employee::select([
            'id',
            'name',
            'employee_id',
            'date_of_birth',
            'age',
            'gender',
            'matrimonial_status',
            'number_wives',
            'number_children',
            'number_university_children',
            'scientific_qualification',
            'specialization',
            'university',
            'area',
            'address',
            'email',
            'phone_number',
        ])->get();
    }
}
