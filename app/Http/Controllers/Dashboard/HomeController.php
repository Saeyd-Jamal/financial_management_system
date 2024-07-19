<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    public function index(){
        $chartEmployeesOptions = [
            'chart_title' => 'عدد الموظفين حسب المناطق',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Employee',
            // 'conditions'            => [
            //     ['name' => 'Food', 'condition' => 'category_id = 1', 'color' => 'black', 'fill' => true],
            //     ['name' => 'Transport', 'condition' => 'category_id = 2', 'color' => 'blue', 'fill' => true],
            // ],

            'group_by_field' => 'area',
            // 'group_by_period' => 'day',

            // 'aggregate_function' => 'sum',
            // 'aggregate_field' => 'amount',
            // 'aggregate_transform' => function($value) {
            //     return round($value / 100, 2);
            // },

            // 'filter_field' => 'transaction_date',
            // 'filter_days' => 30, // show only transactions for last 30 days
            // 'filter_period' => 'week', // show only transactions for this week
            // 'continuous_time' => true, // show continuous timeline including dates without data
        ];
        $chartEmployees = new LaravelChart($chartEmployeesOptions);

        return view('dashboard.index', compact('chartEmployees'));
    }
}
