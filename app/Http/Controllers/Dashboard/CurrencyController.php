<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();

        return view('dashboard.currencies', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Currency::create($request->all());
        return redirect()->route('currencies.index')->with('success','تم إضافة عملة جديدة');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $currency->update($request->all());
        return redirect()->route('currencies.index')->with('success','تم تحديث البيانات');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')->with('success','تم حذف البيانات');
    }
}
