<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeesDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'البيانات الشخصية' => new EmployeesExport(),
            'بيانات العمل' => new WorkDataExport(),
        ];
    }
}
