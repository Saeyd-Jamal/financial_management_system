<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\ReceivablesLoans;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExchangeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', Exchange::class);
        $exchanges = Exchange::with(['employee'])->get();
        $employee_id = $request->query('employee_id');
        $totals = [];
        if($employee_id != null){
            $totals = ReceivablesLoans::where('employee_id',$employee_id)->first();
        }
        return view('dashboard.exchanges', compact('exchanges','employee_id','totals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Exchange::class);
        $request->merge([
            'username' => Auth::user()->name,
        ]);
        Exchange::create($request->all());
        ReceivablesLoans::findOrFail($request->employee_id)
        ->update([
            'total_receivables' => DB::raw('total_receivables - '. ($request->receivables_discount )),
            'total_savings' => DB::raw('total_savings - ' . $request->savings_discount),
        ]);
        return redirect()->route('exchanges.index')->with('success', 'تم اضافة صرف جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        $this->authorize('delete', Exchange::class);
        ReceivablesLoans::findOrFail($exchange->employee_id)
            ->update([
                'total_receivables' => DB::raw('total_receivables + '. ($exchange->receivables_discount )),
                'total_savings' => DB::raw('total_savings + ' . $exchange->savings_discount),
            ]);

        $exchange->delete();
        return redirect()->route('exchanges.index')->with('danger', 'تم حذف الصرف قديم');
    }

    public function getTotals(Request $request){
        $totals = ReceivablesLoans::where('employee_id',$request->employeeId)->first();
        return $totals;
    }
}
