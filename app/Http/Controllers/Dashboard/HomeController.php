<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    public function index(){
        $employees = Employee::get();
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $employeesPerArea = collect($areas)->map(function ($areas) {
            return [
                "count" => Employee::where("area", "=", $areas)->count(),
                'name' => $areas
            ];
        });
        $employeesPerArea = $employeesPerArea->pluck('count')->toArray();
        $chart = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($areas)
            ->datasets([
                [
                    "label" => "عدد الموظفين حسب المناطق",
                    'backgroundColor' => ['#1abc9c', '#16a085', '#2ecc71', '#27ae60', '#3498db', '#2980b9', '#9b59b6', '#8e44ad', '#e74c3c'],
                    'data' => $employeesPerArea
                ],
            ])
            ->options([
                "scales" => [
                    "y" => [
                        "beginAtZero" => true
                        ]
                    ]
        ]);
        return view('dashboard.index', compact('chart'));
    }
}
