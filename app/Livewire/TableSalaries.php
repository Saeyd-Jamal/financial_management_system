<?php

namespace App\Livewire;

use App\Models\Currency;
use App\Models\Salary;
use Carbon\Carbon;
use Livewire\Component;

class TableSalaries extends Component
{
    public $salaries;
    public $month;
    public $USD;

    public function __construct(){
        $this->USD = Currency::where('code','USD')->first()->value;
    }
    public function filterMonth($month){
        $this->month = $month;
        $this->filter();
    }
    public function filter($name = null, $value = null){

        $this->salaries = Salary::where('salaries.month', $this->month)
                                    ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                    ->join('work_data as workData', 'employees.id', '=', 'workData.employee_id');
        if($name != null && $value != null){
            $this->salaries = $this->salaries->where($name,"LIKE","%{$value}%");
        }
        $this->salaries = $this->salaries->get();

    }
    public function render()
    {
        return view('livewire.table-salaries');
    }
}
