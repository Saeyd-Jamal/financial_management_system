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

        // تصنيف الموظفين حسب المناطق
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $employeesPerArea = collect($areas)->map(function ($areas) {
            return [
                "count" => Employee::where("area", "=", $areas)->count(),
                'name' => $areas
            ];
        });
        $employeesPerArea = $employeesPerArea->pluck('count')->toArray();
        $chartEmployeesArea = app()->chartjs
            ->name('employeesPerArea')
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

        // تصنيف الموظفين حسب المؤهل العلمي
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $employeesPerScientificQualification = collect($scientific_qualification)->map(function ($scientific_qualification) {
            return [
                "count" => Employee::where("scientific_qualification", "=", $scientific_qualification)->count(),
                'name' => $scientific_qualification
            ];
        });
        $employeesPerScientificQualification = $employeesPerScientificQualification->pluck('count')->toArray();
        $chartEmployeesScientificQualification = app()->chartjs
            ->name('employeesPerScientificQualification')
            ->type('pie')
            ->size(['width' => 400, 'height' => 300])
            ->labels($scientific_qualification)
            ->datasets([
                [
                    'backgroundColor' => ['#3498db', '#2ecc71', '#e74c3c'],
                    'hoverBackgroundColor' => ['#5dade2', '#58d68d', '#f1948a'],
                    'data' => $employeesPerScientificQualification
                ]
            ])
            ->options([]);

        $countEmployees = Employee::count();
        return view('dashboard.index', compact('chartEmployeesArea','chartEmployeesScientificQualification','countEmployees'));
    }
}

