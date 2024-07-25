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
        $constants = Constant::get();
        return view('dashboard.constants',compact('constants','advance_payment_rate', 'advance_payment_permanent', 'advance_payment_non_permanent', 'advance_payment_riyadh'));
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
