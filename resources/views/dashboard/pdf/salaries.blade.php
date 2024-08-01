<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول رواتب الموظفين</title>
    <style>
        table {
            border-collapse: collapse;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #6c757d;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: top;
            border-top: 1px solid #e9ecef;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #e9ecef;
        }

        .table tbody+tbody {
            border-top: 2px solid #e9ecef;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #e9ecef;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e9ecef;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody+tbody {
            border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #ffffff;
        }

        .table-hover tbody tr:hover {
            color: #6c757d;
            background-color: #dee2e6;
        }

        .table-primary,
        .table-primary>th,
        .table-primary>td {
            background-color: #bfd5ff;
        }

        .table-primary th,
        .table-primary td,
        .table-primary thead th,
        .table-primary tbody+tbody {
            border-color: #88b0ff;
        }

        .table-hover .table-primary:hover {
            background-color: #a6c4ff;
        }

        .table-hover .table-primary:hover>td,
        .table-hover .table-primary:hover>th {
            background-color: #a6c4ff;
        }

        .table-secondary,
        .table-secondary>th,
        .table-secondary>td {
            background-color: #d6d8db;
        }

        .table-secondary th,
        .table-secondary td,
        .table-secondary thead th,
        .table-secondary tbody+tbody {
            border-color: #b3b7bb;
        }

        .table-hover .table-secondary:hover {
            background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover>td,
        .table-hover .table-secondary:hover>th {
            background-color: #c8cbcf;
        }

        .table-success,
        .table-success>th,
        .table-success>td {
            background-color: #c8f2e4;
        }

        .table-success th,
        .table-success td,
        .table-success thead th,
        .table-success tbody+tbody {
            border-color: #99e8cd;
        }

        .table-hover .table-success:hover {
            background-color: #b3edda;
        }

        .table-hover .table-success:hover>td,
        .table-hover .table-success:hover>th {
            background-color: #b3edda;
        }

        .table-info,
        .table-info>th,
        .table-info>td {
            background-color: #bee5eb;
        }

        .table-info th,
        .table-info td,
        .table-info thead th,
        .table-info tbody+tbody {
            border-color: #86cfda;
        }

        .table-hover .table-info:hover {
            background-color: #abdde5;
        }

        .table-hover .table-info:hover>td,
        .table-hover .table-info:hover>th {
            background-color: #abdde5;
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            background-color: #fae5b8;
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody+tbody {
            border-color: #f6cf7c;
        }

        .table-hover .table-warning:hover {
            background-color: #f8dca0;
        }

        .table-hover .table-warning:hover>td,
        .table-hover .table-warning:hover>th {
            background-color: #f8dca0;
        }

        .table-danger,
        .table-danger>th,
        .table-danger>td {
            background-color: #f5c6cb;
        }

        .table-danger th,
        .table-danger td,
        .table-danger thead th,
        .table-danger tbody+tbody {
            border-color: #ed969e;
        }

        .table-hover .table-danger:hover {
            background-color: #f1b0b7;
        }

        .table-hover .table-danger:hover>td,
        .table-hover .table-danger:hover>th {
            background-color: #f1b0b7;
        }

        .table-light,
        .table-light>th,
        .table-light>td {
            background-color: #fdfdfe;
        }

        .table-light th,
        .table-light td,
        .table-light thead th,
        .table-light tbody+tbody {
            border-color: #fbfcfc;
        }

        .table-hover .table-light:hover {
            background-color: #ececf6;
        }

        .table-hover .table-light:hover>td,
        .table-hover .table-light:hover>th {
            background-color: #ececf6;
        }

        .table-dark,
        .table-dark>th,
        .table-dark>td {
            background-color: #c6c8ca;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th,
        .table-dark tbody+tbody {
            border-color: #95999c;
        }

        .table-hover .table-dark:hover {
            background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover>td,
        .table-hover .table-dark:hover>th {
            background-color: #b9bbbe;
        }

        .table-active,
        .table-active>th,
        .table-active>td {
            background-color: #dee2e6;
        }

        .table-hover .table-active:hover {
            background-color: #cfd5db;
        }

        .table-hover .table-active:hover>td,
        .table-hover .table-active:hover>th {
            background-color: #cfd5db;
        }

        .table .thead-dark th {
            color: #ffffff;
            background-color: #343a40;
            border-color: #454d55;
        }

        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #e9ecef;
        }

        .table-dark {
            color: #ffffff;
            background-color: #343a40;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #454d55;
        }

        .table-dark.table-bordered {
            border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.075);
        }

        @media (max-width: 575.98px) {
            .table-responsive-sm {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-sm>.table-bordered {
                border: 0;
            }
        }

        @media (max-width: 767.98px) {
            .table-responsive-md {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-md>.table-bordered {
                border: 0;
            }
        }

        @media (max-width: 991.98px) {
            .table-responsive-lg {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-lg>.table-bordered {
                border: 0;
            }
        }

        @media (max-width: 1199.98px) {
            .table-responsive-xl {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-xl>.table-bordered {
                border: 0;
            }
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive>.table-bordered {
            border: 0;
        }
    </style>
    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
            font-size: 10px;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
        .table th{
            color: #000;
            font-size: bold;
        }
        .table td{
            color: #252525;
        }
        .table tfoot tr{
            color: #000;
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
            <span>الرواتب الشهرية</span>
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
        <table class="table">
            <thead>
                <tr>
                    <td colspan="7">
                        @if ($filter["association"] == "المدينة")
                        {{-- <img src="{{ public_path('assets/images/logos/city_architecture.jpg') }}" style="max-width: 80px%;" alt=""> --}}
                        @elseif ($filter["association"] == "حطين")
                        <img src="{{ public_path('assets/images/logos/hetten.jpg') }}" style="max-width: 80px%;" alt="">
                        @elseif ($filter["association"] == "الكويتي")
                        <img src="{{ public_path('assets/images/logos/Kuwaiti.jpg') }}" style="max-width: 80px%;" alt="">
                        @elseif ($filter["association"] == "يتيم")
                        <img src="{{ public_path('assets/images/logos/orphan.png') }}" style="max-width: 80px%;" alt="">
                        @elseif ($filter["association"] == "صلاح")
                        <img src="{{ public_path('assets/images/logos/salah.png') }}" style="max-width: 80px%;" alt="">
                        @endif
                    </td>
                    <td colspan="8" align="center" style="color: #000;">
                        <p>بسم الله الرحمن الرحيم</p>
                        <h1>رواتب الموظفين لشهر : {{$month}}</h1>
                    </td>
                    <td colspan="9"></td>
                </tr>
                <tr class="table-bordered" style="color: #000; background-color: #e1e1e1;font-size:12px;">
                    <th>#</th>
                    <th style="width: 150px">الاسم</th>
                    <th>مكان العمل</th>
                    <th>الراتب الاساسي</th>
                    <th>علاوة الأولاد</th>
                    <th>علاوة طبيعة العمل</th>
                    <th>علاوة إدارية</th>
                    <th>علاوة مؤهل علمي</th>
                    <th>المواصلات</th>
                    <th>بدل إضافي +-</th>
                    <th>علاوة أغراض راتب</th>
                    <th>إضافة بأثر رجعي</th>
                    <th>علاوة جوال</th>
                    <th>نهاية الخدمة</th>
                    <th>إجمالي الراتب</th>
                    <th>تأمين صحي</th>
                    <th>ض.دخل</th>
                    <th>إدخار 5%</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار</th>
                    <th>قرض شيكل</th>
                    <th>مستحقات متأخرة</th>
                    <th>إجمالي الخصومات</th>
                    <th>صافي الراتب</th>
                </tr>
            </thead>
            <tbody class="table  table-bordered">
                @foreach($salaries as $salary)
                    @php
                        $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$salary->employee->name ?? ''}}</td>
                        <td>{{$salary->employee->workData->workplace ?? ''}}</td>
                        <td>{{$salary->secondary_salary ?? ''}}</td>
                        <td>{{$salary->allowance_boys ?? ''}}</td>
                        <td>{{$salary->nature_work_increase ?? ''}}</td>
                        <td>{{$fixedEntries->administrative_allowance ?? ''}}</td>
                        <td>{{$fixedEntries->scientific_qualification_allowance ?? ''}}</td>
                        <td>{{$fixedEntries->transport ?? ''}}</td>
                        <td>{{$fixedEntries->extra_allowance ?? ''}}</td>
                        <td>{{$fixedEntries->salary_allowance ?? ''}}</td>
                        <td>{{$fixedEntries->ex_addition ?? ''}}</td>
                        <td>{{$fixedEntries->mobile_allowance ?? ''}}</td>
                        <td>{{$salary->termination_service ?? ''}}</td>
                        {{-- <td>{{$salary->grade_Allowance + ($salary->total_discounts - $salary->late_receivables)}}</td> --}}
                        <td>{{ $salary->secondary_salary +($salary->allowance_boys ?? 0) + ($salary->nature_work_increase ?? 0) + ($fixedEntries->administrative_allowance ?? 0) + ($fixedEntries->scientific_qualification_allowance ?? 0) + ($fixedEntries->transport ?? 0) + ($fixedEntries->extra_allowance ?? 0) + ($fixedEntries->salary_allowance ?? 0) + ($fixedEntries->ex_addition ?? 0) + ($fixedEntries->mobile_allowance ?? 0) + ($salary->termination_service ?? 0) }}</td>
                        <td>{{$fixedEntries->health_insurance ?? ''}}</td>
                        <td>{{$salary->z_Income ?? ''}}</td>
                        <td>{{$fixedEntries->savings_rate ?? ''}}</td>
                        <td>{{$fixedEntries->association_loan ?? ''}}</td>
                        <td>{{$fixedEntries != null  ? $fixedEntries->savings_loan * $USD : ''}}</td>
                        <td>{{$fixedEntries->shekel_loan ?? ''}}</td>
                        <td>{{$salary->late_receivables ?? ''}}</td>
                        <td>{{$salary->total_discounts ?? ''}}</td>
                        <td style="color: #000;">{{$salary->net_salary ?? ''}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-bordered"  style="color: #000; background-color: #d2d2d2;">
                    <td>00</td>
                    <td>المجموع</td>
                    <td></td>
                    <td>{{$salariesTotalArray['secondary_salary']}}</td>
                    <td>{{$salariesTotalArray['allowance_boys']}}</td>
                    <td>{{$salariesTotalArray['nature_work_increase']}}</td>
                    <td>{{$salariesTotalArray['administrative_allowance']}}</td>
                    <td>{{$salariesTotalArray['scientific_qualification_allowance']}}</td>
                    <td>{{$salariesTotalArray['transport']}}</td>
                    <td>{{$salariesTotalArray['extra_allowance']}}</td>
                    <td>{{$salariesTotalArray['salary_allowance']}}</td>
                    <td>{{$salariesTotalArray['ex_addition']}}</td>
                    <td>{{$salariesTotalArray['mobile_allowance']}}</td>
                    <td>{{$salariesTotalArray['termination_service']}}</td>
                    <td>{{$salariesTotalArray['gross_salary']}}</td>
                    <td>{{$salariesTotalArray['health_insurance']}}</td>
                    <td>{{$salariesTotalArray['z_Income']}}</td>
                    <td>{{$salariesTotalArray['savings_rate']}}</td>
                    <td>{{$salariesTotalArray['association_loan']}}</td>
                    <td>{{$salariesTotalArray['savings_loan'] * $USD}}</td>
                    <td>{{$salariesTotalArray['shekel_loan']}}</td>
                    <td>{{$salariesTotalArray['late_receivables']}}</td>
                    <td>{{$salariesTotalArray['total_discounts']}}</td>
                    <td>{{$salariesTotalArray['net_salary']}}</td>
                </tr>
                <tr>
                    <td colspan="13">سعر الدولار : {{$USD}}</td>
                    <td colspan="2" style="text-align: left;">إجمالي : {{intval($salariesTotalArray['gross_salary'] / $USD)}} $</td>
                    <td colspan="7"></td>
                    <td colspan="2">إجمالي : {{intval($salariesTotalArray['net_salary']  / $USD)}} $</td>
                </tr>
            </tfoot>
        </table>
        <table width="100%" style="vertical-align: bottom; color: #000000; margin:30px 1em; font-size: 12px">
            <tr>
                <td width="33%">الختم</td>
                <td width="33%" align="center">التوقيع</td>
                <td width="33%" style="text-align: left; padding-left: 80px;">إعتماد</td>
            </tr>
        </table>
        <htmlpagefooter name="page-footer">
            <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    @auth
                        <td width="33%" style="text-align: left;">{{Auth::user()->name }}</td>
                    @else
                        <td width="33%" style="text-align: left;">اسم المستخدم</td>
                    @endauth
                </tr>
            </table>
        </htmlpagefooter>
    </div>


</body>

</html>
