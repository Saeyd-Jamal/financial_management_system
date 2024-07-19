<?php

namespace App\Jobs;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Helper\AddSalaryEmployee;
use App\Models\Constant;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\NatureWorkIncrease;
use App\Models\Salary;
use App\Models\SalaryScale;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSalary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $employees = Employee::with(['banks','workData','totals','fixedEntries','salary'])->all();
        // foreach ($employees as $employee) {
        //     AddSalaryEmployee::addSalary($employee);
        // }

        // Currency::create([
        //     'name'=> 'شيكل',
        //     'code' => 'ILS',
        //     'amount' => '1.00',
        // ]);
        // return 'd';
    }
}
