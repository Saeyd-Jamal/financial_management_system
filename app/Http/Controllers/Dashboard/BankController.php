<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BanksEmployees;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::paginate(10);
        return view('dashboard.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bank = new Bank();
        return view('dashboard.banks.create', compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Bank::create($request->all());
        return redirect()->route('banks.index')->with('success', 'تم إضافة بنك جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        return redirect()->route('banks.edit',$bank->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        $btn_label = "تعديل";
        return view('dashboard.banks.edit', compact('bank','btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $bank->update($request->all());
        return redirect()->route('banks.index')->with('success', 'تم تعديل بيانات البنك');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        $banksEmployees = BanksEmployees::where('bank_id', $bank->id)->get();
        foreach ($banksEmployees as $banksEmployee) {
            $banksEmployee->delete();
        }
        return redirect()->route('banks.index')->with('success', 'تم حذف البنك');
    }

}
