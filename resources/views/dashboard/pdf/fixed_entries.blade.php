<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول التعديلات الثابتة للموظفين</title>
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
        <p>
            <span>قسم الرواتب والموظفين</span> /
            <span>جدول التعديلات الثابتة للموظفين</span>
            @if (isset($filter))
                @foreach ($filedsEmpolyees as $name)
                    @if ($filter["$name"] != null)
                    / <span>{{ $filter["$name"] }}</span>
                    @endif
                @endforeach
            @endif
        </p>
    </htmlpageheader>

    <div lang="ar">
        <table class="table blueTable" style="margin-top: 20px">
            <thead>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="4" style="border:0;">
                        <img src="{{ public_path('assets/images/logo.png') }}" style="max-width: 80px;" alt="">
                    </td>
                    <td colspan="12" align="center" style="color: #000;border:0;">
                        <p>بسم الله الرحمن الرحيم</p>
                        <h1>جدول التعديلات الثابتة للموظفين لشهر : {{$month}}</h1>
                    </td>
                    <td colspan="4" style="border:0;"></td>
                </tr>
                <tr class="table-bordered">
                    <th>#</th>
                    <th style="width: 150px">الاسم</th>
                    <th>علاوة إدارية</th>
                    <th>علاوة مؤهل علمي</th>
                    <th>مواصلات</th>
                    <th>بدل إضافي</th>
                    <th>علاوة اغراض راتب</th>
                    <th>إضافة بأثر رجعي</th>
                    <th>علاوة جوال</th>
                    <th>تأمين صحي</th>
                    <th>ف.أوريدو</th>
                    <th>قرض جمعية </th>
                    <th>قرض الإدخار</th>
                    <th>قرض اللجنة</th>
                    <th>رسوم دراسية</th>
                    <th>تبرعات</th>
                    <th>خصم اللجنة</th>
                    <th>خصومات الإخرى</th>
                    <th>تبرعات للحركة</th>
                    <th>إدخار 5%</th>
                </tr>
            </thead>
            <tbody class="table  table-bordered">
                @foreach ($fixed_entries as $fixed_entrie)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$fixed_entrie->employee->name}}</td>
                        <td>{{$fixed_entrie->administrative_allowance}}</td>
                        <td>{{$fixed_entrie->scientific_qualification_allowance}}</td>
                        <td>{{$fixed_entrie->transport}}</td>
                        <td>{{$fixed_entrie->extra_allowance}}</td>
                        <td>{{$fixed_entrie->salary_allowance}}</td>
                        <td>{{$fixed_entrie->ex_addition}}</td>
                        <td>{{$fixed_entrie->mobile_allowance}}</td>
                        <td>{{$fixed_entrie->health_insurance}}</td>
                        <td>{{$fixed_entrie->f_Oredo}}</td>
                        <td>{{$fixed_entrie->association_loan}}</td>
                        <td>{{$fixed_entrie->savings_loan}}</td>
                        <td>{{$fixed_entrie->shekel_loan}}</td>
                        <td>{{$fixed_entrie->tuition_fees}}</td>
                        <td>{{$fixed_entrie->voluntary_contributions}}</td>
                        <td>{{$fixed_entrie->paradise_discount}}</td>
                        <td>{{$fixed_entrie->other_discounts}}</td>
                        <td>{{$fixed_entrie->proportion_voluntary}}</td>
                        <td>{{$fixed_entrie->savings_rate}}</td>
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
