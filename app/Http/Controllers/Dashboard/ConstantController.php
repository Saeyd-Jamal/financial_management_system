<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Constant;
use Illuminate\Http\Request;

class ConstantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value');
        if($advance_payment_rate){$advance_payment_rate = $advance_payment_rate->value;}

        $advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value');
        if($advance_payment_permanent){$advance_payment_permanent = $advance_payment_permanent->value;}

        $advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value');
        if($advance_payment_non_permanent){$advance_payment_non_permanent = $advance_payment_non_permanent->value;}

        $advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value');
        if($advance_payment_riyadh){$advance_payment_riyadh = $advance_payment_riyadh->value;}

        $areas = Constant::where('type_constant','areas')->get();
        $working_status = Constant::where('type_constant','working_status')->get();
        $nature_work = Constant::where('type_constant','nature_work')->get();
        $type_appointment = Constant::where('type_constant','type_appointment')->get();
        $government_official = Constant::where('type_constant','government_official')->get();
        $field_action = Constant::where('type_constant','field_action')->get();
        $matrimonial_status = Constant::where('type_constant','matrimonial_status')->get();
        $scientific_qualification = Constant::where('type_constant','scientific_qualification')->get();
        $state_effectiveness = Constant::where('type_constant','state_effectiveness')->get();
        $association = Constant::where('type_constant','association')->get();
        $workplace = Constant::where('type_constant','workplace')->get();
        $section = Constant::where('type_constant','section')->get();
        $dependence = Constant::where('type_constant','dependence')->get();
        $branch = Constant::where('type_constant','branch')->get();
        $establishment = Constant::where('type_constant','establishment')->get();
        $foundation_E = Constant::where('type_constant','foundation_E')->get();
        $constants = Constant::get();
        return view('dashboard.constants',compact('constants','advance_payment_rate', 'advance_payment_permanent', 'advance_payment_non_permanent', 'advance_payment_riyadh', 'areas', 'working_status', 'nature_work', 'type_appointment', 'government_official', 'field_action', 'matrimonial_status', 'scientific_qualification', 'state_effectiveness', 'association', 'workplace', 'section', 'dependence', 'branch', 'establishment', 'foundation_E'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->advance_payment_rate){
            $advance_payment_rate = Constant::where('type_constant','=','advance_payment_rate')->first();
            if($advance_payment_rate){
                $advance_payment_rate->update([
                    'value' => $request->advance_payment_rate,
                ]);
            }else{
                Constant::create([
                    'type_constant' => 'advance_payment_rate',
                    'value' => $request->advance_payment_rate,
                ]);
            }
        }
        if($request->advance_payment_permanent){
            $advance_payment_permanent = Constant::where('type_constant','=','advance_payment_permanent')->first();
            if($advance_payment_permanent){
                $advance_payment_permanent->update([
                    'value' => $request->advance_payment_permanent,
                ]);
            }else{
                Constant::create([
                    'type_constant' => 'advance_payment_permanent',
                    'value' => $request->advance_payment_permanent,
                ]);
            }
        }
        if($request->advance_payment_non_permanent){
            $advance_payment_non_permanent = Constant::where('type_constant','=','advance_payment_non_permanent')->first();
            if($advance_payment_non_permanent){
                $advance_payment_non_permanent->update([
                    'value' => $request->advance_payment_non_permanent,
                ]);
            }else{
                Constant::create([
                    'type_constant' => 'advance_payment_non_permanent',
                    'value' => $request->advance_payment_non_permanent,
                ]);
            }
        }
        if($request->advance_payment_riyadh){
            $advance_payment_riyadh = Constant::where('type_constant','=','advance_payment_riyadh')->first();
            if($advance_payment_riyadh){
                $advance_payment_riyadh->update([
                    'value' => $request->advance_payment_riyadh,
                ]);
                return redirect()->route('constants.index')->with('success','تم تعديل القيمة');
            }else{
                Constant::create([
                    'type_constant' => 'advance_payment_riyadh',
                    'value' => $request->advance_payment_riyadh,
                ]);
            }
            return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');

        }
        if($request->areas){
            $old_area = Constant::where('type_constant','=','areas')->where('value','=',$request->areas)->first();
            if($old_area){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'areas',
                    'value' => $request->areas,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->working_status){
            $old_working_status = Constant::where('type_constant','=','working_status')->where('value','=',$request->working_status)->first();
            if($old_working_status){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'working_status',
                    'value' => $request->working_status,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->nature_work){
            $old_nature_work = Constant::where('type_constant','=','nature_work')->where('value','=',$request->nature_work)->first();
            if($old_nature_work){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'nature_work',
                    'value' => $request->nature_work,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->type_appointment){
            $old_type_appointment = Constant::where('type_constant','=','type_appointment')->where('value','=',$request->type_appointment)->first();
            if($old_type_appointment){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'type_appointment',
                    'value' => $request->type_appointment,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->government_official){
            $old_government_official = Constant::where('type_constant','=','government_official')->where('value','=',$request->government_official)->first();
            if($old_government_official){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'government_official',
                    'value' => $request->government_official,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->field_action){
            $old_field_action = Constant::where('type_constant','=','field_action')->where('value','=',$request->field_action)->first();
            if($old_field_action){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'field_action',
                    'value' => $request->field_action,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->matrimonial_status){
            $old_matrimonial_status = Constant::where('type_constant','=','matrimonial_status')->where('value','=',$request->matrimonial_status)->first();
            if($old_matrimonial_status){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'matrimonial_status',
                    'value' => $request->matrimonial_status,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->scientific_qualification){
            $old_scientific_qualification = Constant::where('type_constant','=','scientific_qualification')->where('value','=',$request->scientific_qualification)->first();
            if($old_scientific_qualification){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'scientific_qualification',
                    'value' => $request->scientific_qualification,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->state_effectiveness){
            $old_state_effectiveness = Constant::where('type_constant','=','state_effectiveness')->where('value','=',$request->state_effectiveness)->first();
            if($old_state_effectiveness){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'state_effectiveness',
                    'value' => $request->state_effectiveness,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->association){
            $old_association = Constant::where('type_constant','=','association')->where('value','=',$request->association)->first();
            if($old_association){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'association',
                    'value' => $request->association,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->workplace){
            $old_workplace = Constant::where('type_constant','=','workplace')->where('value','=',$request->workplace)->first();
            if($old_workplace){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'workplace',
                    'value' => $request->workplace,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->section){
            $old_section = Constant::where('type_constant','=','section')->where('value','=',$request->section)->first();
            if($old_section){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'section',
                    'value' => $request->section,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->dependence){
            $old_dependence = Constant::where('type_constant','=','dependence')->where('value','=',$request->dependence)->first();
            if($old_dependence){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'dependence',
                    'value' => $request->dependence,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->branch){
            $old_branch = Constant::where('type_constant','=','branch')->where('value','=',$request->branch)->first();
            if($old_branch){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'branch',
                    'value' => $request->branch,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->establishment){
            $old_establishment = Constant::where('type_constant','=','establishment')->where('value','=',$request->establishment)->first();
            if($old_establishment){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'establishment',
                    'value' => $request->establishment,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
        if($request->foundation_E){
            $old_foundation_E = Constant::where('type_constant','=','foundation_E')->where('value','=',$request->foundation_E)->first();
            if($old_foundation_E){
                return redirect()->route('constants.index')->with('danger','القيمة موجودة مسبقا');
            }else{
                Constant::create([
                    'type_constant' => 'foundation_E',
                    'value' => $request->foundation_E,
                ]);
                return redirect()->route('constants.index')->with('success','تم إضافة القيمة بنجاح');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if($request->areas){
            $old_area = Constant::findOrFail($request->areas);
            $old_area->delete();
        }
        if($request->working_status){
            $old_working_status = Constant::findOrFail($request->working_status);
            $old_working_status->delete();

        }
        if($request->nature_work){
            $old_nature_work = Constant::findOrFail($request->nature_work);
            $old_nature_work->delete();
        }
        if($request->type_appointment){
            $old_type_appointment = Constant::findOrFail($request->type_appointment);
            $old_type_appointment->delete();
        }
        if($request->government_official){
            $old_government_official = Constant::findOrFail($request->government_official);
            $old_government_official->delete();
        }
        if($request->field_action){
            $old_field_action = Constant::findOrFail($request->field_action);
            $old_field_action->delete();
        }
        if($request->matrimonial_status){
            $old_matrimonial_status = Constant::findOrFail($request->matrimonial_status);
            $old_matrimonial_status->delete();
        }
        if($request->scientific_qualification){
            $old_scientific_qualification = Constant::findOrFail($request->scientific_qualification);
            $old_scientific_qualification->delete();
        }
        if($request->state_effectiveness){
            $old_state_effectiveness = Constant::findOrFail($request->state_effectiveness);
            $old_state_effectiveness->delete();
        }
        if($request->association){
            $old_association = Constant::findOrFail($request->association);
            $old_association->delete();
        }
        if($request->workplace){
            $old_workplace = Constant::findOrFail($request->workplace);
            $old_workplace->delete();
        }
        if($request->section){
            $old_section = Constant::findOrFail($request->section);
            $old_section->delete();
        }
        if($request->dependence){
            $old_dependence = Constant::findOrFail($request->dependence);
            $old_dependence->delete();
        }
        if($request->branch){
            $old_branch = Constant::findOrFail($request->branch);
            $old_branch->delete();
        }
        if($request->establishment){
            $old_establishment = Constant::findOrFail($request->establishment);
            $old_establishment->delete();
        }
        if($request->foundation_E){
            $old_foundation_E = Constant::findOrFail($request->foundation_E);
            $old_foundation_E->delete();
        }
        return redirect()->route('constants.index')->with('danger','تم حذف القيمة المختارة');
    }
}
