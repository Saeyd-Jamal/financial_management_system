<x-front-layout  classC="shadow p-0 bg-white rounded">
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">

        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/stickyTable.css') }}">
        <link id="stickyTableDark" rel="stylesheet" href="{{ asset('css/stickyTableDark.css') }}" disabled>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatableIndex.css') }}">
        <style>
            thead{
                background-color: #a9d08e !important;
            }
            tfoot{
                background-color: #a9d08e !important;
            }
            th.sticky{
                background-color: #a9d08e !important;
            }
            table.sticky thead th{
                color: #000 !important;
            }
            table.sticky tfoot td{
                color: #000 !important;
            }

        </style>
    @endpush
    <x-slot:extra_nav>
        <li class="nav-item dropdown d-flex align-items-center justify-content-center mx-2">
            <a class="nav-link dropdown-toggle text-white pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <i class="fe fe-filter fe-16"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <button class="btn btn-nav" id="filterBtn">تصفية</button>
                <button class="btn btn-nav" id="filterBtnClear">إزالة التصفية</button>
            </div>
        </li>
        <li class="nav-item d-flex align-items-center justify-content-center">
            <button type="button" class="btn" id="refreshData"><span class="fe fe-refresh-ccw fe-16 text-white"></span></button>
        </li>
    </x-slot:extra_nav>
    <div class="row shadow rounded mb-2 mx-0">
        <div class="col-md-12 d-flex justify-content-between align-items-center p-1">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn nav-link active view-loan" id="pills-savings-tab" data-toggle="pill" data-field="savings_loan" data-total_field="total_savings_loan" data-target=".pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">قرض الإدخار</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn nav-link view-loan" id="pills-association-tab" data-toggle="pill" data-field="association_loan" data-total_field="total_association_loan" data-target=".pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">قرض الجمعية</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn nav-link view-loan" id="pills-shekel-tab" data-toggle="pill"data-field="shekel_loan" data-total_field="total_shekel_loan"  data-target=".pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">قرض اللجنة</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn nav-link" id="pills-exchanges-tab" data-toggle="pill" data-target=".pills-exchanges" type="button" role="tab" aria-controls="pills-exchanges" aria-selected="false">صرف القروض</button>
                </li>
            </ul>
            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $('.view-loan').on('click', function (e) {
                            $('.tab-pane').removeClass('show active');
                            $('#pills-loan').addClass('show active');
                            $('#field').val($(this).data('field'));
                            $('#total_field').val($(this).data('total_field'));
                        });
                        $('#pills-exchanges-tab').on('click', function (e) {
                            $('.tab-pane').removeClass('show active');
                            $('.pills-exchanges').addClass('show active');
                        });
                    });
                </script>
            @endpush
            <div class="d-flex align-items-center justify-content-end tab-content">
                <div class="tab-pane fade show active pills-loan" role="tabpanel" aria-labelledby="pills-table-tab">
                    <div class="form-group my-0 mx-2">
                        <select name="year" id="year" class="form-control">
                            @for ($yearNow = date('Y'); $yearNow >= 2024; $yearNow--)
                                <option value="{{ $yearNow }}">{{ $yearNow }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="tab-pane fade pills-exchanges" role="tabpanel" aria-labelledby="pills-exchanges-tab">
                    @can('create', 'App\\Models\Exchange')
                    <a href="{{ route('exchanges.create') }}" class="btn btn-success text-white">
                        <i class="fe fe-plus"></i> إضافة صرف جديد
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active pills-table" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                        <div class="card-body table-container p-0">
                            <table id="loans-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 130px);">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-white text-center">#</th>
                                        <th class="sticky" style="right: 0px; white-space: nowrap;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span>الاسم</span>
                                                <div class="filter-dropdown ml-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-filter" id="btn-filter-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-pocket text-white"></i>
                                                        </button>
                                                        <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="employee_name_filter">
                                                            <!-- إضافة checkboxes بدلاً من select -->
                                                            <div class="searchable-checkbox">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <input type="search" class="form-control search-checkbox" data-index="2" placeholder="ابحث...">
                                                                    <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="2" data-field="employee_name">
                                                                        <i class="fe fe-check"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="checkbox-list-box">
                                                                    <label style="display: block;">
                                                                        <input type="checkbox" value="all" class="all-checkbox" data-index="2"> الكل
                                                                    </label>
                                                                    <div class="checkbox-list checkbox-list-2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span>الجمعية</span>
                                                <div class="filter-dropdown ml-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-pocket text-white"></i>
                                                        </button>
                                                        <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="association_filter">
                                                            <!-- إضافة checkboxes بدلاً من select -->
                                                            <div class="searchable-checkbox">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                                    <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="association_field">
                                                                        <i class="fe fe-check"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="checkbox-list-box">
                                                                    <label style="display: block;">
                                                                        <input type="checkbox" value="all" class="all-checkbox" data-index="3"> الكل
                                                                    </label>
                                                                    <div class="checkbox-list checkbox-list-3">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th>الرصيد</th>
                                        <th>يناير</th>
                                        <th>فبراير</th>
                                        <th>مارس</th>
                                        <th>أبريل</th>
                                        <th>مايو</th>
                                        <th>يونيو</th>
                                        <th>يوليه</th>
                                        <th>أغسطس</th>
                                        <th>سبتمبر</th>
                                        <th>أكتوبر</th>
                                        <th>نوفمبر</th>
                                        <th>ديسمبر</th>
                                        <th>الإجمالي</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-white text-center" id="row_count">#</td>
                                        <td style="white-space: nowrap;" class="text-left">الإجمالي</td>
                                        <td></td>
                                        <td id="total_4"></td>
                                        <td id="total_5"></td>
                                        <td id="total_6"></td>
                                        <td id="total_7"></td>
                                        <td id="total_8"></td>
                                        <td id="total_9"></td>
                                        <td id="total_10"></td>
                                        <td id="total_11"></td>
                                        <td id="total_12"></td>
                                        <td id="total_13"></td>
                                        <td id="total_14"></td>
                                        <td id="total_15"></td>
                                        <td id="total_16"></td>
                                        <td id="total_17"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- الصرف --}}
                    <div class="tab-pane fade pills-exchanges" id="pills-exchanges" role="tabpanel" aria-labelledby="pills-exchanges-tab">
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تاريخ الصرف</th>
                                        <th>الموظف</th>
                                        <th>نوع القرض</th>
                                        <th>المبلغ المصروف</th>
                                        <th>السبب</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exchanges as $exchange)
                                    <tr class="exchange_select" data-id="{{$exchange->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$exchange->discount_date}}</td>
                                        <td style="white-space: nowrap;">{{$exchange->employee->name}}</td>
                                        <td>{{$exchange->exchange_type}}</td>
                                        @if ($exchange->exchange_type == 'association_loan')
                                            <td>{{$exchange->association_loan}}</td>
                                        @elseif ($exchange->exchange_type == 'savings_loan')
                                            <td>{{$exchange->savings_loan}}</td>
                                        @elseif ($exchange->exchange_type == 'shekel_loan')
                                            <td>{{$exchange->shekel_loan}}</td>
                                        @endif
                                        <td>{{$exchange->notes}}</td>
                                        <td>
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                {{-- <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('salaries.edit',$salary->id)}}">تعديل</a> --}}
                                                @can('print', 'App\\Models\Exchange')
                                                <form action="{{route('exchanges.printPdf',['id' => $exchange->id])}}" method="post" target="_blank">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="#">طباعة</button>
                                                </form>
                                                @endcan
                                                @can('delete', 'App\\Models\Exchange')
                                                <form action="{{route('exchanges.destroy',$exchange->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="#">حذف</button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Fullscreen modal -->
    <div class="modal fade modal-full" id="editLoan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
        </button>
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <form id="editForm">
                        @include('dashboard.loans.editModal')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- small modal -->

    <input type="hidden" name="field" id="field" value="savings_loan">
    <input type="hidden" name="total_field" id="total_field" value="total_savings_loan">

    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/datatable/dataTables.js')}}"></script>
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}/";
        </script>
        <script src="{{ asset('js/exchange.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                let year = "{{ $year }}";
                let currentMonth = "{{ $lastMonth }}";
                let nextLastMonth = "{{ $nextLastMonth }}";
                let lastMonthAccreditations = "{{ $lastMonthAccreditations }}";
                let formatNumber = (number,min = 0) => {
                    // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                    if (number === null || number === undefined || isNaN(number)) {
                        return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                    }
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
                };
                let formatData = (data,field) => {
                    if (data == null) {
                        return 0.00;
                    }
                    let jsonData = data.replace(/&quot;/g, '"');
                    let parsedData = JSON.parse(jsonData);
                    if (parsedData != null ) {
                        return formatNumber(parseFloat(parsedData[field]),2) || 0.00;
                    }else{
                        return 0.00;
                    }
                };
                let table = $('#loans-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,              // تعطيل الترقيم
                    searching: true,            // الإبقاء على البحث إذا كنت تريده
                    info: false,                // تعطيل النص السفلي الذي يوضح عدد السجلات
                    lengthChange: false,        // تعطيل قائمة تغيير عدد المدخلات
                    "language": {
                        "url": "{{ asset('files/Arabic.json')}}"
                    },
                    ajax: {
                        url: '{{ route("loans.index") }}',
                        type: 'GET',
                        data: function(d) {
                            d.year = $('#year').val();
                            d.field = $('#field').val();
                            d.total_field = $('#total_field').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('edit','App\\Models\Loans')
                                let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":loan"><i class="fe fe-edit"></i></button>`.replace(':loan', data);
                                return link ;
                            @else
                                return '';
                            @endcan
                        }},
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
                        { data: 'previous_balance', name: 'previous_balance', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month1', name: 'month1', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month2', name: 'month2', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month3', name: 'month3', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month4', name: 'month4', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month5', name: 'month5', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month6', name: 'month6', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month7', name: 'month7', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month8', name: 'month8', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month9', name: 'month9', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month10', name: 'month10', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month11', name: 'month11', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month12', name: 'month12', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'total', name: 'total', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\Loan')
                            return `
                                <form method="post" action="{{ route('loans.view_pdf', ':loans' )}}" target="_blank">
                                    @csrf
                                    <input type="hidden" name="field" value="${$('#field').val()}">
                                    <input type="hidden" name="total_field" value="${$('#total_field').val()}">
                                    <input type="hidden" name="previous_balance" value="${row.previous_balance}">
                                    <button
                                        type="submit"
                                        class="btn btn-icon p-1 text-info">
                                        <i class="fe fe-printer"></i>
                                    </button>
                                </form>
                                `.replace(':loans', data);
                            @else
                            return '';
                            @endcan
                        }},
                    ],
                    columnDefs: [
                        { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#loans-table tbody tr').each(function() {
                            $(this).find('td').eq(2).css('right', '0px');
                        });
                    },
                    footerCallback: function(row, data, start, end, display) {
                        let api = this.api();
                        // تحويل القيم النصية إلى أرقام
                        let intVal = function(i) {
                            return typeof i === 'string' ?
                                parseFloat(i.replace(/[\$,]/g, '')) :
                                typeof i === 'number' ? i : 0;
                        };
                        // 1. حساب عدد الأسطر في الصفحة الحالية
                        let rowCount = display.length;

                        for (let i = 4; i < 18; i++) {
                            var total = api
                                .column(i, { page: 'current' }) // العمود الرابع
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                            $('#total_' + i).html(formatNumber(total,2));
                        }
                        // 4. عرض النتائج في `tfoot`

                        $('#row_count').html(formatNumber(rowCount));
                        // // $('#allocations-table_filter').addClass('d-none');
                    }
                });
                function populateFilterOptions(columnIndex, container,name) {
                    const uniqueValues = [];
                    table.column(columnIndex, { search: 'applied' }).data().each(function (value) {
                        const stringValue = value ? String(value).trim() : ''; // تحويل القيمة إلى نص وإزالة الفراغات
                        if (stringValue && uniqueValues.indexOf(stringValue) === -1) {
                            uniqueValues.push(stringValue);
                        }
                    });
                    // ترتيب القيم أبجديًا
                    uniqueValues.sort();
                    // إضافة الخيارات إلى div
                    const checkboxList = $(container);
                    checkboxList.empty();
                    uniqueValues.forEach(value => {
                        checkboxList.append(`
                            <label style="display: block;">
                                <input type="checkbox" value="${value}" class="${name}-checkbox"> ${value}
                            </label>
                        `);
                    });
                }
                function isColumnFiltered(columnIndex) {
                    const filterValue = table.column(columnIndex).search();
                    return filterValue !== ""; // إذا لم يكن فارغًا، الفلترة مفعلة
                }
                // دالة لإعادة بناء الفلاتر بناءً على البيانات الحالية
                function rebuildFilters() {
                    isColumnFiltered(2) ? '' : populateFilterOptions(2, '.checkbox-list-2','employee_name');
                    isColumnFiltered(3) ? '' : populateFilterOptions(3, '.checkbox-list-3','association_field');
                    for (let i = 1; i <= 4; i++) {
                        if (isColumnFiltered(i)) {
                            $('#btn-filter-' + i).removeClass('btn-secondary');
                            $('#btn-filter-' + i + ' i').removeClass('fe-pocket');
                            $('#btn-filter-' + i + ' i').addClass('fe-filter');
                            $('#btn-filter-' + i).addClass('btn-success');
                        }else{
                            $('#btn-filter-' + i + ' i').removeClass('fe-filter');
                            $('#btn-filter-' + i).removeClass('btn-success');
                            $('#btn-filter-' + i).addClass('btn-secondary');
                            $('#btn-filter-' + i + ' i').addClass('fe-pocket');
                        }
                    }
                }
                table.on('draw', function() {
                    rebuildFilters();
                });
                // منع إغلاق dropdown عند النقر على input أو label
                $('th  .dropdown-menu .checkbox-list-box').on('click', function (e) {
                    e.stopPropagation(); // منع انتشار الحدث
                });
                // البحث داخل الـ checkboxes
                $('.search-checkbox').on('input', function() {
                    let searchValue = $(this).val().toLowerCase();
                    let tdIndex = $(this).data('index');
                    $('.checkbox-list-' + tdIndex + ' label').each(function() {
                        let labelText = $(this).text().toLowerCase();  // النص داخل الـ label
                        let checkbox = $(this).find('input');  // الـ checkbox داخل الـ label

                        if (labelText.indexOf(searchValue) !== -1) {
                            $(this).show();
                        } else {
                            $(this).hide();
                            if (checkbox.prop('checked')) {
                                checkbox.prop('checked', false);  // إذا كان الـ checkbox محددًا، قم بإلغاء تحديده
                            }
                        }
                    });
                });
                $('.all-checkbox').on('change', function() {
                    let index = $(this).data('index'); // الحصول على الـ index من الـ data-index

                    // التحقق من حالة الـ checkbox "الكل"
                    if ($(this).prop('checked')) {
                        // إذا كانت الـ checkbox "الكل" محددة، تحديد جميع الـ checkboxes الظاهرة فقط
                        $('.checkbox-list-' + index + ' input[type="checkbox"]:visible').prop('checked', true);
                    } else {
                        // إذا كانت الـ checkbox "الكل" غير محددة، إلغاء تحديد جميع الـ checkboxes الظاهرة فقط
                        $('.checkbox-list-' + index + ' input[type="checkbox"]:visible').prop('checked', false);
                    }
                });
                $('.filter-apply-btn-checkbox').on('click', function() {
                    let target = $(this).data('target'); // استرجاع الهدف (العمود)
                    let field = $(this).data('field'); // استرجاع الحقل (اسم المشروع أو أي حقل آخر)

                    // الحصول على القيم المحددة من الـ checkboxes
                    var filterValues = [];
                    // نستخدم الكلاس المناسب بناءً على الحقل (هنا مشروع)
                    $('.' + field + '-checkbox:checked').each(function() {
                        filterValues.push($(this).val()); // إضافة القيمة المحددة
                    });
                    // إذا كانت هناك قيم محددة، نستخدمها في الفلترة
                    if (filterValues.length > 0) {
                        // دمج القيم باستخدام OR (|) كما هو متوقع في البحث
                        var searchExpression = filterValues.join('|');
                        // تطبيق الفلترة على العمود باستخدام القيم المحددة
                        table.column(target).search(searchExpression, true, false).draw(); // Use regex search
                    } else {
                        // إذا لم تكن هناك قيم محددة، نعرض جميع البيانات
                        table.column(target).search('').draw();
                    }
                });
                // تطبيق الفلترة عند الضغط على زر "check"
                $('.filter-apply-btn').on('click', function() {
                    let target = $(this).data('target');
                    let field = $(this).data('field');
                    var filterValue = $("input[name="+ field + "]").val();
                    table.column(target).search(filterValue).draw();
                });
                // تطبيق التصفية عند النقر على زر "Apply"
                $('#filter-date-btn').on('click', function () {
                    const fromDate = $('#from_date').val();
                    const toDate = $('#to_date').val();
                    table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
                });
                // تطبيق فلترة السنة عند تغير حقل السنة
                $('.view-loan').on('click', function() {
                    let field = $(this).data('field');
                    let total_field = $(this).data('total_field');
                    table.ajax.reload();
                });
                // تطبيق فلترة السنة عند تغير حقل السنة
                $('#year').on('change', function() {
                    const year = $(this).val();
                    table.ajax.reload();
                });
                // إعادة تحميل الجدول عند النقر على زر "Refresh"
                $(document).on('click', '#refreshData', function() {
                    table.ajax.reload();
                });
                $(document).on('click', '#filterBtnClear', function() {
                    $('.filter-dropdown').slideUp();
                    $('#filterBtn').text('تصفية');
                    $('.filterDropdownMenu input').val('');
                    $('th input[type="checkbox"]').prop('checked', false);
                    table.columns().search('').draw(); // إعادة رسم الجدول بدون فلاتر
                });
                $(document).on('click', '.edit_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    editLoanForm(id);
                });
                let loan = {
                    id : '',
                    name : '',
                    totals : [],
                    totals_old : [],
                    totals_last : [],
                    loans : [],
                };
                let name_loan = {
                    'savings_loan' : 'قرض الإدخار',
                    'association_loan' : 'قرض الجمعية',
                    'shekel_loan' : 'قرض اللجنة',
                };
                function editLoanForm(id) {
                    $.ajax({
                        url: '{{ route("loans.getData") }}',
                        method: 'POST',
                        data: {
                            id: id,
                            year: $('#year').val(),
                            nextLastMonth: nextLastMonth,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            response = response.employee;
                            loan.id = response.id;
                            loan.name = response.name;
                            loan.totals = response.totals;
                            loan.totals_old = response.totals;
                            loan.totals_last = response.totals_last;
                            loan.loans = response.loans;
                            // $('input[field="association_loan"]:not([disabled])').each(function() {
                            //     if(lastMonthAccreditations == 12){
                            //         if ($(this).attr('month') == nextLastMonth) {
                            //             //
                            //         }else{
                            //             loan.totals.total_association_loan -= parseFloat($(this).val()) || 0;
                            //         }
                            //     }else{
                            //         loan.totals.total_association_loan -= parseFloat($(this).val()) || 0;
                            //     }
                            // });
                            // $('input[field="savings_loan"]:not([disabled])').each(function() {
                            //     if(lastMonthAccreditations == 12){
                            //         if ($(this).attr('month') == nextLastMonth) {
                            //             //
                            //         }else{
                            //             loan.totals.total_savings_loan -= parseFloat($(this).val()) || 0;
                            //         }
                            //     }else{
                            //         loan.totals.total_savings_loan -= parseFloat($(this).val()) || 0;
                            //     }
                            //     // loan.totals.total_savings_loan -= parseFloat($(this).val()) || 0;
                            // });
                            // $('input[field="shekel_loan"]:not([disabled])').each(function() {
                            //     if(lastMonthAccreditations == 12){
                            //         if ($(this).attr('month') == nextLastMonth) {
                            //             //
                            //         }else{
                            //             loan.totals.total_shekel_loan -= parseFloat($(this).val()) || 0;
                            //         }
                            //     }else{
                            //         loan.totals.total_shekel_loan -= parseFloat($(this).val()) || 0;
                            //     }
                            //     // loan.totals.total_shekel_loan -= parseFloat($(this).val()) || 0;
                            // });
                            $('#employee_name').text(loan.name);
                            $('#association_loan_total').val(parseFloat(loan.totals.total_association_loan).toFixed(2));
                            $('#savings_loan_total').val(parseFloat(loan.totals.total_savings_loan).toFixed(2));
                            $('#shekel_loan_total').val(parseFloat(loan.totals.total_shekel_loan).toFixed(2));
                        }
                    });
                    $.ajax({
                        url: '{{ route("loans.edit", ":id") }}'.replace(':id', id),
                        method: 'GET',
                        success: function (response) {
                            let data = response;
                            $('#loans_tbody').empty();
                            $.each(name_loan, function(key, value) {
                                $('#loans_tbody').append(`
                                    <tr id="${key}_row">
                                        <td class="text-left">${value}</td>
                                    </tr>
                                `);
                                let staticloan = data.find(loan => loan.month === "0000-00");
                                let staticVal = 0;
                                if(staticloan){
                                    staticVal = staticloan[key];
                                    if(staticVal == -1.00){
                                        staticVal = '';
                                    }
                                }else{
                                    staticVal = '';
                                }
                                $('#' + key + '_row').append(`
                                    <td>
                                        <x-form.input  month="0000-00" data-field="${key}" name="${key}-0000" value="${staticVal}" class="const" />
                                    </td>
                                `);
                                for (let i = 1; i <= 12; i++) {
                                    if(i<10){
                                        i = '0'+i;
                                    }
                                    let  monthToFind = year + "-" + i;
                                    let foundloan = data.find(loan => loan.month === monthToFind);
                                    let val = 0;
                                    if(foundloan){
                                        val = foundloan[key];
                                    }else{
                                        val = '0.00';
                                    }
                                    $('#' + key + '_row').append(`
                                        <td>
                                            <x-form.input value="${val}"  employee_id="${id}" field="${key}" month="${i}" name="${key}-${i}" />
                                        </td>
                                    `);
                                    if(currentMonth != '12'){
                                        if (i <= currentMonth) {
                                            $("#" + key + "-" + i).attr('disabled', true);  // تعطيل الحقل إذا كان الشهر الحالي أكبر من الشهر المحدد
                                        }
                                    }
                                }
                            });
                            $('#editLoan').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                }
                $(document).on('click', '#update', function () {
                    let formData = $('#editForm').serialize(); // جمع بيانات النموذج في سلسلة بيانات
                    let association_loan_total = parseFloat($('#association_loan_total').val()) || 0;
                    let savings_loan_total = parseFloat($('#savings_loan_total').val()) || 0;
                    let shekel_loan_total = parseFloat($('#shekel_loan_total').val()) || 0;
                    if(association_loan_total < 0 || savings_loan_total < 0 || shekel_loan_total < 0){
                        alert('لا يمكن أن يكون إجمالي القروض أقل من الصفر يرجى التدقيق لخصم القروض');
                        return;
                    }
                    $.ajax({
                        url: "{{ route('loans.update', ':id') }}".replace(':id', loan.id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            year: year
                        },
                        data: formData,  // البيانات التي تم جمعها من النموذج
                        success: function(response) {
                            $('#editLoan').modal('hide');
                            table.ajax.reload();
                            alert('تم التعديل بنجاح');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        }
                    });
                });
                $(document).on('input', '.const', function () {
                    let field = $(this).data('field');
                    let value = $(this).val();
                    // let total = 0;
                    // if(field == "savings_loan"){
                    //     total = loan.totals.total_savings_loan;
                    // }
                    // if(field == "association_loan"){
                    //     total = loan.totals.total_association_loan;
                    // }
                    // if(field == "shekel_loan"){
                    //     total = loan.totals.total_shekel_loan;
                    // }
                    for (let i = 1; i <= 12; i++) {
                        i = i < 10 ? '0' + i : i;
                        if(currentMonth != '12'){
                            if (i > currentMonth) {
                                let fieldId = '#' + field + '-' + i;
                                $(fieldId).val(value);
                            }
                        }else{
                            let fieldId = '#' + field + '-' + i;
                            $(fieldId).val(value);
                        }
                    }
                });
                $(document).on('input', 'input[field="association_loan"], #association_loan-0000', function () {
                    let total = 0 ;
                    $('input[field="association_loan"]:not([disabled])').each(function() {
                        if ($(this).attr('month') !== '0000-00') {
                            let data = loan.loans;
                            let loanMonth = data.find(loan => loan.month == ( year + '-' + $(this).attr('month')));
                            if(loanMonth){
                                let association_loan = (parseFloat(loanMonth.association_loan) || 0) - (parseFloat($(this).val()) || 0);
                                if((loanMonth.association_loan != $(this).val())){
                                    total += parseFloat(association_loan) || 0;
                                }else{
                                    // total += parseFloat($(this).val()) || 0;
                                }
                            }
                        }
                    });
                    let totalFinal = parseFloat(loan.totals_old.total_association_loan) + total;
                    $('#association_loan_total').val(totalFinal.toFixed(2));
                });
                $(document).on('input', 'input[field="savings_loan"], #savings_loan-0000', function () {
                    let total = 0 ;
                    $('input[field="savings_loan"]:not([disabled])').each(function() {
                        if ($(this).attr('month') !== '0000-00') {
                            let data = loan.loans;
                            let loanMonth = data.find(loan => loan.month == ( year + '-' + $(this).attr('month')));
                            if(loanMonth){
                                let savings_loan = (parseFloat(loanMonth.savings_loan) || 0) - (parseFloat($(this).val()) || 0);
                                if((loanMonth.savings_loan != $(this).val())){
                                    total += parseFloat(savings_loan) || 0;
                                }else{
                                    // total += parseFloat($(this).val()) || 0;
                                }
                            }
                        }
                    });
                    let totalFinal = (parseFloat(loan.totals_old.total_savings_loan) + total);
                    $('#savings_loan_total').val(totalFinal.toFixed(2));
                });
                $(document).on('input', 'input[field="shekel_loan"], #shekel_loan-0000', function () {
                    let total = 0;
                    $('input[field="shekel_loan"]:not([disabled])').each(function() {
                        if ($(this).attr('month') !== '0000-00') {
                            let data = loan.loans;
                            let loanMonth = data.find(loan => loan.month == ( year + '-' + $(this).attr('month')));
                            if(loanMonth){
                                let shekel_loan = (parseFloat(loanMonth.shekel_loan) || 0) - (parseFloat($(this).val()) || 0);
                                if((loanMonth.shekel_loan != $(this).val())){
                                    total += parseFloat(shekel_loan) || 0;
                                }else{
                                    // total += parseFloat($(this).val()) || 0;
                                }
                            }
                        }
                    });
                    let totalFinal = parseFloat(loan.totals_old.total_shekel_loan) + total;
                    $('#shekel_loan_total').val(totalFinal.toFixed(2));
                });
            });
        </script>
        <script>
            $(document).on('click', '#filterBtn', function() {
                let text = $(this).text();
                if (text != 'تصفية') {
                    $(this).text('تصفية');
                }else{
                    $(this).text('إخفاء التصفية');
                }
                $('.filter-dropdown').slideToggle();
            });
            $(document).ready(function() {
                if (curentTheme == "light") {
                    $('#stickyTableLight').prop('disabled', false); // تشغيل النمط Light
                    $('#stickyTableDark').prop('disabled', true);  // تعطيل النمط Dark
                } else {
                    $('#stickyTableLight').prop('disabled', true);  // تعطيل النمط Light
                    $('#stickyTableDark').prop('disabled', false); // تشغيل النمط Dark
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                let currentRow = 0;
                let currentCol = 0;

                // الحصول على الصفوف من tbody فقط
                const rows = $('#loans-table tbody tr');

                // إضافة الكلاس للخلايا عند تحميل الصفحة
                highlightCell(currentRow, currentCol);

                // التنقل باستخدام الأسهم
                $(document).on('keydown', function(e) {
                    // تحديث عدد الصفوف والأعمدة المرئية عند كل حركة
                    const totalRows = $('#loans-table tbody tr:visible').length;
                    const totalCols = $('#loans-table tbody tr:visible').eq(0).find('td').length;

                    // التحقق من وجود صفوف وأعمدة لتجنب NaN
                    if (totalRows === 0 || totalCols === 0) return;

                    // التنقل باستخدام الأسهم
                    if (e.key === 'ArrowLeft') {
                        if (currentCol < 32) {
                            currentCol = (currentCol + 1) % totalCols;
                        }
                    } else if (e.key === 'ArrowRight') {
                        if (currentCol > 0) {
                            currentCol = (currentCol - 1 + totalCols) % totalCols;
                        }
                    } else if (e.key === 'ArrowDown') {
                        currentRow = (currentRow + 1) % totalRows;
                    } else if (e.key === 'ArrowUp') {
                        // إذا كنت في الصف الأول، لا تفعل شيئاً
                        if (currentRow > 0) {
                            currentRow = (currentRow - 1 + totalRows) % totalRows;
                        }
                    } else {
                        return;
                    }
                    highlightCell(currentRow, currentCol);
                });

                // التحديد عند النقر المزدوج بالماوس
                $('#loans-table tbody').on('dblclick', 'td', function() {
                    const cell = $(this);
                    currentRow = cell.closest('tr').index();
                    currentCol = cell.index();
                    highlightCell(currentRow, currentCol);
                });

                // دالة لتحديث الخلية النشطة
                function highlightCell(row, col) {
                    // استهداف الصفوف المرئية فقط
                    const visibleRows = $('#loans-table tbody tr:visible');
                    // التحقق من وجود الصف
                    if (visibleRows.length > row) {
                        // تحديد الصف والخلية المطلوبة
                        const targetRow = visibleRows.eq(row);
                        const targetCell = targetRow.find('td').eq(col);
                        if (targetCell.length) {
                            // إزالة التنسيقات السابقة
                            $('#loans-table tbody td').removeClass('active');
                            // إضافة التنسيق للخلية المطلوبة
                            targetCell.addClass('active');
                            targetCell.focus();
                        }
                    }
                }


            });

        </script>
    @endpush
</x-front-layout>
