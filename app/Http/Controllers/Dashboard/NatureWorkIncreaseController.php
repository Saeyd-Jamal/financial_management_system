<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NatureWorkIncrease;
use Illuminate\Http\Request;

class NatureWorkIncreaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nature_work_increases = NatureWorkIncrease::get();
        $nature_work = $this->nature_work;
        $scientific_qualification = $this->scientific_qualification;
        return view('dashboard.nature_work_increases', compact('nature_work_increases','nature_work','scientific_qualification'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nature_work' => 'required',
            'scientific_qualification' => 'required',
            'percentage' => 'required',
        ]);
        NatureWorkIncrease::create($request->all());
        return redirect()->route('nature_work_increases.index')->with('success', 'تم إضافة نسبة جديدة');
    }

    /**
     * Display the specified resource.
     */
    public function show(NatureWorkIncrease $natureWorkIncrease)
    {
        return redirect()->route('nature_work_increases.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NatureWorkIncrease $natureWorkIncrease)
    {
        $natureWorkIncrease->natures_work = $this->nature_work;
        $natureWorkIncrease->scientifics_qualification = $this->scientific_qualification;
        return $natureWorkIncrease;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NatureWorkIncrease $natureWorkIncrease)
    {
        $request->validate([
            'nature_work' =>'required',
            'scientific_qualification' =>'required',
            'percentage' =>'required',
        ]);
        $natureWorkIncrease->update($request->all());
        return redirect()->route('nature_work_increases.index')->with('success', 'تم تحديث نسبة');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NatureWorkIncrease $natureWorkIncrease)
    {
        $natureWorkIncrease->delete();
        return redirect()->route('nature_work_increases.index')->with('success', 'تم حذف نسبة');
    }
}
