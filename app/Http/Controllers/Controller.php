<?php

namespace App\Http\Controllers;

use App\Models\Constant;

abstract class Controller
{
    protected $advance_payment_rate;
    protected $advance_payment_permanent;
    protected $advance_payment_non_permanent;
    protected $advance_payment_riyadh;
    protected $areas;
    protected $working_status;
    protected $nature_work;
    protected $type_appointment;
    protected $government_official;
    protected $field_action;
    protected $matrimonial_status;
    protected $scientific_qualification;
    protected $state_effectiveness;
    protected $association;
    protected $workplace;
    protected $section;
    protected $dependence;
    protected $branch;
    protected $establishment;
    protected $foundation_E;

    public function __construct(){
        $this->advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value');
        if($this->advance_payment_rate){$this->advance_payment_rate = $this->advance_payment_rate->value;}

        $this->advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value');
        if($this->advance_payment_permanent){$this->advance_payment_permanent = $this->advance_payment_permanent->value;}

        $this->advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value');
        if($this->advance_payment_non_permanent){$this->advance_payment_non_permanent = $this->advance_payment_non_permanent->value;}

        $this->advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value');
        if($this->advance_payment_riyadh){$this->advance_payment_riyadh = $this->advance_payment_riyadh->value;}

        $this->areas = Constant::where('type_constant','areas')->get();
        $this->working_status = Constant::where('type_constant','working_status')->get();
        $this->nature_work = Constant::where('type_constant','nature_work')->get();
        $this->type_appointment = Constant::where('type_constant','type_appointment')->get();
        $this->government_official = Constant::where('type_constant','government_official')->get();
        $this->field_action = Constant::where('type_constant','field_action')->get();
        $this->matrimonial_status = Constant::where('type_constant','matrimonial_status')->get();
        $this->scientific_qualification = Constant::where('type_constant','scientific_qualification')->get();
        $this->state_effectiveness = Constant::where('type_constant','state_effectiveness')->get();
        $this->association = Constant::where('type_constant','association')->get();
        $this->workplace = Constant::where('type_constant','workplace')->get();
        $this->section = Constant::where('type_constant','section')->get();
        $this->dependence = Constant::where('type_constant','dependence')->get();
        $this->branch = Constant::where('type_constant','branch')->get();
        $this->establishment = Constant::where('type_constant','establishment')->get();
        $this->foundation_E = Constant::where('type_constant','foundation_E')->get();
    }

}
