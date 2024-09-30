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
    public $filterArray = [
        'name' => '',
        'month' => '',
    ];


    public function __construct(){
        $this->USD = Currency::where('code','USD')->first()->value;
        $this->month = Carbon::now()->format('Y-m');
        $this->filterArray['month'] = $this->month;
    }

    public function filter(Request $request = null){
        if($request == null){
            $request = new Request();
        }
        if($this->filterArray['name'] != ''){
            $request->merge([
                'name' => $this->filterArray['name'],
            ]);
        }

        $controller = new EmployeeController();
        $employees = $controller->filterEmployee($request);

        $this->month = ($this->filterArray['month'] != '') ? $this->filterArray['month'] : Carbon::now()->format('Y-m');

        $this->salaries = Salary::whereIn('employee_id', $employees->pluck('id'))->where('salaries.month', $this->month)->get();
    }
    public function render()
    {
        return view('livewire.table-salaries');
    }
}