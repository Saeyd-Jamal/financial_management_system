<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول المستحقات والقروض للموظفين</title>
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

        table.blueTable tr:nth-child(even) {
            background: #D0E4F5;
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
            <thead>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="7" style="border:0;">
                        <p>
                            <span>قسم الرواتب والموظفين</span> /
                            <span>جدول المستحقات والقروض للموظفين</span>
                            @if (isset($filter))
                                @foreach ($filedsEmpolyees as $name)
                                    @if ($filter["$name"] != null)
                                    / <span>{{ $filter["$name"] }}</span>
                                    @endif
                                @endforeach
                            @endif
                        </p>
                    </td>
                </tr>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="7" align="center" style="color: #000;border:0;">
                        <p>بسم الله الرحمن الرحيم</p>
                        <h1>جدول المستحقات والقروض للموظفين</h1>
                    </td>
                </tr>
                <tr class="table-bordered">
                    <th>#</th>
                    <th>الاسم</th>
                    <th>إجمالي المستحقات</th>
                    <th>إجمالي الإدخارات $</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار $</th>
                    <th>قرض اللجنة</th>
                </tr>
            </thead>
            <tbody class="table  table-bordered">
                @foreach ($totals as $total)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $total->employee->name }}</td>
                        <td>{{ $total->total_receivables }}</td>
                        <td>{{ $total->total_savings }}</td>
                        <td>{{ $total->total_association_loan }}</td>
                        <td>{{ $total->total_savings_loan }}</td>
                        <td>{{ $total->total_shekel_loan }}</td>
                    </tr>
                @endforeach
            </tbody>
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
