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
            'payroll_statement',
        ];
    @endphp
    <htmlpageheader name="page-header">
        <div style="padding: 5px 0">
            @if(isset($filter["association"]))
                @if ($filter['association'] == 'المدينة')
                    <img src="{{ public_path('assets/images/headers/city_architecture.jpg') }}" style="max-width: 100%;"
                        alt="">
                @elseif ($filter['association'] == 'حطين')
                    <img src="{{ public_path('assets/images/headers/hetten.png') }}" style="max-width: 100%;" alt="">
                @elseif ($filter['association'] == 'الكويتي')
                    <img src="{{ public_path('assets/images/headers/Kuwaiti.jpg') }}" style="max-width: 100%;"
                        alt="">
                @elseif ($filter['association'] == 'يتيم')
                    <img src="{{ public_path('assets/images/headers/orphan.jpg') }}" style="max-width: 100%;"
                        alt="">
                @elseif ($filter['association'] == 'صلاح')
                    <img src="{{ public_path('assets/images/headers/salah.png') }}" style="max-width: 100%;" alt="">
                @endif
            @endif
        </div>
    </htmlpageheader>

    <div lang="ar">
        <table class="table blueTable" style="margin-top: 20px">
            @php
                if ($filter['exchange_type'] == 'cash') {
                    $co = 7;
                    $coHead = 7;
                    $coTotal = 4;

                }
                if ($filter['exchange_type'] == 'bank') {
                    $co = 10;
                    $coHead = 10;
                    $coTotal = 7;
                    if ($filter['bank'] != null) {
                        $co = 9;
                        $coHead = 7;
                        $coTotal = 6;
                    }
                }
            @endphp
            <thead>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="{{ $coHead }}" style="border:0;">
                        <p>
                            <span>قسم المالية</span>
                            @if (isset($filter))
                                @foreach ($filedsEmpolyees as $name)
                                    @if (isset($filter["$name"]))
                                    /
                                        @foreach ($filter["$name"] as $value)
                                            <span> {{ $value }} + </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </p>
                    </td>
                    @if ($filter['bank'] != null && $filter['exchange_type'] == 'bank')
                        <td colspan="2" style="border:0;">البنك : {{ $filter['bank'] }}</td>
                    @endif
                </tr>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="{{ $co }}" align="center" style="color: #000;border:0;">
                        <h1>رواتب شهر {{ $monthName }} - {{ Carbon\Carbon::parse($month)->format('Y') }}</h1>
                    </td>
                </tr>
                <tr style="background: #dddddd;">
                    <th>#</th>
                    <th>مكان العمل</th>
                    @if ($filter['bank'] == null && $filter['exchange_type'] == 'bank')
                        <th>البنك</th>
                    @endif
                    <th>رقم الهوية</th>
                    <th>السكن</th>
                    <th>الاسم</th>
                    @if ($filter['exchange_type'] == 'bank')
                        <th>رقم الحساب</th>
                        <th>رقم الفرع</th>
                    @endif
                    <th>صافي الراتب</th>
                    <th style="width: 80px">التوقيع</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salaries as $salary)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $salary->employee->workData->workplace }}</td>
                        @if ($filter['bank'] == null && $filter['exchange_type'] == 'bank')
                            <td>{{ $salary->bank }}</td>
                        @endif
                        <td>{{ $salary->employee->employee_id }}</td>
                        <td>{{ $salary->employee->area }}</td>
                        <td>{{ $salary->employee->name }}</td>
                        @if ($filter['exchange_type'] == 'bank')
                            <td>{{ $salary->account_number }}</td>
                            <td>{{ $salary->branch_number }}</td>
                        @endif
                        <td>{{ $salary->net_salary }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>00</td>
                    <td colspan="{{ $coTotal }}">الإجمالي الكلي</td>
                    <td>{{ $salariesTotalArray['net_salary'] }}</td>
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
