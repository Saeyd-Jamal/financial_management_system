<?php

namespace App\Livewire;

use App\Http\Controllers\Dashboard\EmployeeController;
use App\Models\Currency;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function filter(Request $request = null,$name = null, $value = null,){
        $request->merge([
            $name => $value
        ]);
        $controller = new EmployeeController();
        $employees = $controller->filterEmployee($request);

        $this->salaries = Salary::whereIn('employee_id', $employees->pluck('id'))->where('salaries.month', $this->month)->get();
    }
    public function render()
    {
        return view('livewire.table-salaries');
    }
}
