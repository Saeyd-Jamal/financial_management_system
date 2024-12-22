<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Exchange;
use App\Models\ReceivablesLoans;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Yajra\DataTables\Facades\DataTables;

class ExchangeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', Exchange::class);

        if($request->ajax()) {
            $exchanges = Exchange::with('employee')->get();
            return DataTables::of($exchanges)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('edit', function ($exchange) {
                        return $exchange->id;
                    })
                    ->addColumn('name', function ($exchange) {
                        return $exchange->employee->name;
                    })
                    ->addColumn('association', function ($exchange) {
                        return $exchange->employee->workData->association;
                    })
                    ->addColumn('print', function ($exchange) {
                        return $exchange->id;
                    })
                    ->addColumn('delete', function ($exchange) {
                        return $exchange->id;
                    })
                    ->make(true);
        }
        $employee_id = $request->query('employee_id');
        $totals = [];
        if($employee_id != null){
            $totals = ReceivablesLoans::where('employee_id',$employee_id)->first();
        }
        $employee_names = Employee::all('id','name');
        return view('dashboard.exchanges.index', compact('employee_id','totals','employee_names'));
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
        DB::beginTransaction();
        try{
            Exchange::create($request->all());
            ReceivablesLoans::where('employee_id',$request->employee_id)
                ->update([
                    'total_receivables' => DB::raw('total_receivables - (' . ($request->receivables_discount) . ')'),
                    'total_savings' => DB::raw('total_savings - (' . $request->savings_discount . ') - (' . $request->savings_loan . ')'),
                    'total_association_loan' => DB::raw('total_association_loan + (' . $request->association_loan . ')'),
                    'total_savings_loan' => DB::raw('total_savings_loan + (' . $request->savings_loan . ')'),
                    'total_shekel_loan' => DB::raw('total_shekel_loan + (' . $request->shekel_loan . ')')
                ]);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            if($request->ajax()) {
                return response()->json(['error' => $exception->getMessage()], 500);
            }
            return redirect()->back()->with('danger', $exception->getMessage());
        }

        if($request->ajax()) {
            return response()->json(['success' => 'تم تحديث الثوابت بنجاح']);
        }
        return redirect()->back()->with('success', 'تم اضافة صرف جديد');
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
    public function edit(Request $request, Exchange $exchange)
    {
        if($request->ajax()) {
            $exchange = Exchange::with('employee')->findOrFail($exchange->id);
            $employee = Employee::with('totals')->findOrFail($exchange->employee_id);
            $exchange['name'] = $employee->name;
            $exchange['totals'] = $employee->totals;
            return response()->json($exchange);
        }
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
        ReceivablesLoans::where('employee_id',$exchange->employee_id)
            ->update([
                'total_receivables' => DB::raw('total_receivables + '. ($exchange->receivables_discount )),
                'total_savings' => DB::raw('total_savings + ' . $exchange->savings_discount . ' - ' . $exchange->savings_loan),
                'total_association_loan' => DB::raw('total_association_loan - ' . $exchange->association_loan),
                'total_savings_loan' => DB::raw('total_savings_loan - ' . $exchange->savings_loan),
                'total_shekel_loan' => DB::raw('total_shekel_loan - ' . $exchange->shekel_loan),
            ]);
        $exchange->delete();
        return redirect()->route('exchanges.index')->with('danger', 'تم حذف الصرف قديم');
    }

    public function getTotals(Request $request){
        $totals = ReceivablesLoans::where('employee_id',$request->employeeId)->first();
        $totals['name'] = Employee::findOrFail($request->employeeId)->name;
        return $totals;
    }

    public function printPdf(Request $request, $id)
    {
        $exchange = Exchange::findOrFail($id);
        $margin_top = 3;
        $pdf = PDF::loadView('dashboard.pdf.exchange',['exchange' => $exchange],[],[
            'margin_left' => 3,
            'margin_right' => 3,
            'margin_top' => $margin_top,
            'margin_bottom' => 10,
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 12,
            'default_font' => 'Arial',
        ]);
        return $pdf->stream();
    }

}
