<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول رواتب الموظفين</title>
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
            border: 1px solid #1C6EA4;
            background-color: #EEEEEE;
            width: 100%;
            height: 200px;
            text-align: right;
            border-collapse: collapse;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #4C4C4C;
            padding: 4px 5px;
        }

        table.blueTable tbody td {
            font-size: 13px;
        }

        table.blueTable tbody tr {
            background: #ffffff;
        }

        table.blueTable thead {
            background: #757575;
            background: -moz-linear-gradient(top, #979797 0%, #828282 66%, #757575 100%);
            background: -webkit-linear-gradient(top, #979797 0%, #828282 66%, #757575 100%);
            background: linear-gradient(to bottom, #979797 0%, #828282 66%, #757575 100%);
            border-bottom: 2px solid #000000;
        }

        table.blueTable thead th {
            font-size: 15px;
            font-weight: bold;
            color: #000000;
            text-align: center;
            border-left: 1px solid #24282A;
        }

        table.blueTable thead th:first-child {
            border-left: none;
        }

        table.blueTable tfoot {
            font-size: 11px;
            font-weight: bold;
            color: #FFFFFF;
            background: #D0E4F5;
            background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 11px;
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
        <div style="padding: 5px 0">
            @if ($filter["association"] == "المدينة")
            <img src="{{ public_path('assets/images/headers/city_architecture.jpg') }}" style="max-width: 100%;" alt="">
            @elseif ($filter["association"] == "حطين")
            <img src="{{ public_path('assets/images/headers/hetten.png') }}" style="max-width: 100%;" alt="">
            @elseif ($filter["association"] == "الكويتي")
            <img src="{{ public_path('assets/images/headers/Kuwaiti.jpg') }}" style="max-width: 100%;" alt="">
            @elseif ($filter["association"] == "يتيم")
            <img src="{{ public_path('assets/images/headers/orphan.jpg') }}" style="max-width: 100%;" alt="">
            @elseif ($filter["association"] == "صلاح")
            <img src="{{ public_path('assets/images/headers/salah.png') }}" style="max-width: 100%;" alt="">
            @endif
        </div>
    </htmlpageheader>

    <div lang="ar">
        <table class="table blueTable" style="margin-top: 20px">
            @php

                $co = 10;
                $coHead = 10;
                $coTotal = 7;
                if($filter["bank"] != null){
                    $co = 9;
                    $coHead = 7;
                    $coTotal = 6;
                }
                if($filter["bank"] != null){
                }
            @endphp
            <thead>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="{{$coHead}}" style="border:0;">
                        <p>
                            <span>قسم المالية</span>
                            @if (isset($filter))
                                @foreach ($filedsEmpolyees as $name)
                                    @if ($filter["$name"] != null)
                                    / <span>{{ $filter["$name"] }}</span>
                                    @endif
                                @endforeach
                            @endif
                        </p>
                    </td>
                    @if ($filter["bank"] != null)
                    <td colspan="2">البنك : {{ $filter["bank"] }}</td>
                    @endif
                </tr>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="{{$co}}" align="center" style="color: #000;border:0;">
                        <p>بسم الله الرحمن الرحيم</p>
                        <h1>رواتب شهر {{ $monthName }}</h1>
                    </td>
                </tr>
                <tr class="table-bordered">
                    <th>#</th>
                    <th>مكان العمل</th>
                    @if ($filter["bank"] == null)
                        <th>البنك</th>
                    @endif
                    <th>رقم الهوية</th>
                    <th>السكن</th>
                    <th>الاسم</th>
                    <th>رقم الحساب</th>
                    <th>رقم الفرع</th>
                    <th>صافي الراتب</th>
                    <th style="width: 80px">التوقيع</th>
                </tr>
            </thead>
            <tbody class="table  table-bordered">
                @foreach ($salaries as $salary)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $salary->employee->workData->workplace }}</td>
                        @if ($filter["bank"] == null)
                        <td>{{ $salary->bank }}</td>
                        @endif
                        <td>{{ $salary->employee->employee_id }}</td>
                        <td>{{ $salary->employee->area }}</td>
                        <td>{{ $salary->employee->name }}</td>
                        <td>{{ $salary->account_number }}</td>
                        <td>{{ $salary->branch_number }}</td>
                        <td>{{ $salary->net_salary }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-bordered"  style="color: #000; background-color: #d2d2d2;">
                    <td>00</td>
                    <td colspan="{{$coTotal}}">الإجمالي الكلي</td>
                    <td>{{$salariesTotalArray['net_salary']}}</td>
                    <td></td>
                </tr>

            </tfoot>
        </table>
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
    </div>


</body>

</html>
