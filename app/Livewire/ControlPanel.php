<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\WorkData;
use Livewire\Component;
use Mpdf\Tag\Em;

class ControlPanel extends Component
{

    public $employees;

    // Filters
    public $filter = [
        "area" => '',
        "matrimonial_status" => '',
        "scientific_qualification" => '',
        "gender" => '',
        "working_status" => '',
        "field_action" => '',
        "dual_function" => '',
        "state_effectiveness" => '',
        "nature_work" => '',
        "workplace" => '',
        "section" => '',
        "type_appointment" => '',
        "dependence" => '',
        "establishment" => '',
        "payroll_statement" => '',
        "association" => '',
    ];

    // Data
    public $areas;
    public $working_status;
    public $nature_work;
    public $type_appointment;
    public $field_action;
    public $matrimonial_status;
    public $scientific_qualification;
    public $state_effectiveness;
    public $association;
    public $workplace;
    public $section;
    public $dependence;
    public $establishment;
    public $payroll_statement;




    public function __construct()
    {
        $this->areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $this->working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $this->nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $this->type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $this->field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $this->matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $this->scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $this->state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $this->association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $this->workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $this->section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $this->dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $this->establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $this->payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();
    }
    public function mount()
    {
        $this->employees = Employee::get();
    }
    public function filterEmployees(){
        $employees = Employee::query();

        $data = $this->filter;

        $filedsEmpolyees = [
            'gender',
            'matrimonial_status',
            'scientific_qualification',
            'area',
        ];

        $filedsWork = [
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'payroll_statement'
        ];

        foreach ($filedsEmpolyees as $key) {
            if ($this->filter[$key] != '') {
                $employees->where($key, $this->filter[$key]);
            }
        }
        foreach ($filedsWork as $key) {
            if ($this->filter[$key] != '') {
                $employees = $employees->whereHas('workData', function($query) use ($key) {
                    $query->where($key,$this->filter[$key]);
                });
            }
        }

        $this->employees = $employees->get();
    }
    public function render()
    {
        return view('livewire.control-panel');
    }
}
