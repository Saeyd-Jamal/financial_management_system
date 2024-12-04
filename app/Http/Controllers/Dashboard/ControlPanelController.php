<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControlPanelController extends Controller
{
    public function index()
    {
        return view('dashboard.control-panel');
    }
    public function store(Request $request){
        $employees_id = $request->formData;

        return response()->json([
            'message' => 'success'
        ]);
    }
}
