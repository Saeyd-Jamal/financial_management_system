<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف الحساب</title>
    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
    <style>
        table.blueTable {
            width: 100%;
            text-align: right;
            border-collapse: collapse;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 5px 9px;
            white-space: nowrap;
        }

        table.blueTable tbody td {
            font-size: 13px;
            color: #000000;
        }

        table.blueTable tr:nth-child(even) {
            background: #F5F5F5;
        }

        table.blueTable thead {
            background: #D3D3D3;
            background: -moz-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: -webkit-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: linear-gradient(to bottom, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            border-bottom: 2px solid #444444;
        }

        table.blueTable thead th {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        table.blueTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #EEEEEE;
            background: -moz-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: -webkit-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: linear-gradient(to bottom, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    @php
        $filedsEmpolyees = [
            'gender',
            'matrimonial_status',
            'scientific_qualification',
            'area',
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'payroll_statement'
        ];
    @endphp
    <htmlpageheader name="page-header">

    </htmlpageheader>

    <div>
        <div>
            <p>
                <span>قسم المالية</span> /
                <span>كشف حساب لموظف</span>
            </p>
        </div>
        <div align="center"  style="color: #000;border:0; width: 100%;">
            <div align="center" style="font-size: 25px; font-weight: bold">كشف حساب للموظف : {{ $employee->name }}</div>
            <span>من شهر {{ $month }} الي الشهر {{ $to_month }}</span>
        </div>
    </div>
    <div lang="ar">
        <h3>كشف الرواتب</h3>
        <table class="blueTable">
            <thead>
                <tr  style="background: #dddddd;">
                    <th>#</th>
                    <th>الشهر</th>
                    <th>الراتب الاساسي</th>
                    <th>إجمالي الراتب</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار</th>
                    <th>قرض شيكل</th>
                    <th>مستحقات متأخرة</th>
                    <th>إجمالي الخصومات</th>
                    <th>صافي الراتب</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaries as $salary)
                    @php
                        $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td style="white-space: nowrap;">{{$salary->month ?? ''}}</td>
                        <td>{{$salary->secondary_salary ?? ''}}</td>
                        <td>{{$salary->gross_salary }}</td>
                        <td>{{$fixedEntries->association_loan ?? ''}}</td>
                        <td>{{$fixedEntries != null  ? $fixedEntries->savings_loan * $USD : ''}}</td>
                        <td>{{$fixedEntries->shekel_loan ?? ''}}</td>
                        <td>{{$salary->late_receivables ?? ''}}</td>
                        <td>{{$salary->total_discounts ?? ''}}</td>
                        <td style="color: #000; background: #dddddd; font-weight: bold;">{{$salary->net_salary ?? ''}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div lang="ar">
        <h3>الأرصدة</h3>
        <table class="blueTable">
            <thead>
                <tr  style="background: #dddddd;">
                    <th>#</th>
                    <th>الشهر</th>
                    <th>البيان</th>
                    <th>المستحقات</th>
                    <th>الإدخارات</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = $employee->totals;
                    $late_receivables = $salaries->select('late_receivables')->sum('late_receivables');
                    $total_savings = $salary->employee->fixedEntries->sum('savings_loan');
                @endphp
                <tr>
                    <td>00</td>
                    <td></td>
                    <td>الرصيد السابق</td>
                    <td>{{ floatval($total->total_receivables) - floatval($late_receivables) }}</td>
                    <td>{{ floatval($total->total_savings) - floatval($total_savings) }}</td>
                </tr>
                @foreach($salaries as $salary)
                    @php
                        $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                        // ($savings_loan + (($savings_rate + $termination_service) / $USD )
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td style="white-space: nowrap;">{{$salary->month ?? ''}}</td>
                        <td>سند قيد</td>
                        <td>{{$salary->late_receivables ?? ''}}</td>
                        <td>{{ $fixedEntries->savings_loan + (($salary->savings_rate + $salary->termination_service) / $USD)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>00</td>
                    <td>---</td>
                    <td>الإجمالي</td>
                    <td>{{ $total->total_receivables_view }}</td>
                    <td>{{ $total->total_savings_view }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div lang="ar">
        <h3>كشف الرواتب</h3>
        <table class="blueTable">
            <thead>
                <tr  style="background: #dddddd;">
                    <th>#</th>
                    <th>الشهر</th>
                    <th>الراتب الاساسي</th>
                    <th>إجمالي الراتب</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار</th>
                    <th>قرض شيكل</th>
                    <th>مستحقات متأخرة</th>
                    <th>إجمالي الخصومات</th>
                    <th>صافي الراتب</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaries as $salary)
                    @php
                        $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td style="white-space: nowrap;">{{$salary->month ?? ''}}</td>
                        <td>{{$salary->secondary_salary ?? ''}}</td>
                        <td>{{$salary->gross_salary }}</td>
                        <td>{{$fixedEntries->association_loan ?? ''}}</td>
                        <td>{{$fixedEntries != null  ? $fixedEntries->savings_loan * $USD : ''}}</td>
                        <td>{{$fixedEntries->shekel_loan ?? ''}}</td>
                        <td>{{$salary->late_receivables ?? ''}}</td>
                        <td>{{$salary->total_discounts ?? ''}}</td>
                        <td style="color: #000; background: #dddddd; font-weight: bold;">{{$salary->net_salary ?? ''}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <htmlpagefooter name="page-footer">
        <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
            <tr>
                <td width="33%">{DATE j-m-Y}</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                @auth
                    <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
                @else
                    <td width="33%" style="text-align: left;">اسم المستخدم</td>
                @endauth
            </tr>
        </table>
    </htmlpagefooter>

</body>

</html>
