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
                    <button class="btn nav-link active" id="pills-table-tab" data-toggle="pill" data-target=".pills-table" type="button" role="tab" aria-controls="pills-home" aria-selected="true">العرض</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn nav-link" id="pills-exchanges-tab" data-toggle="pill" data-target=".pills-exchanges" type="button" role="tab" aria-controls="pills-exchanges" aria-selected="false">صرف مستحقات</button>
                </li>
            </ul>
            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $('#pills-table-tab').on('click', function (e) {
                            $('.pills-table').addClass('show active');
                            $('.pills-exchanges').removeClass('show active');
                        });
                        $('#pills-exchanges-tab').on('click', function (e) {
                            $('.pills-exchanges').addClass('show active');
                            $('.pills-table').removeClass('show active');
                        });
                    });
                </script>
            @endpush
            <div class="d-flex align-items-center justify-content-end tab-content">
                <div class="tab-pane fade show active pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                    <div class="form-group my-0 mx-2">
                        <select name="year" id="year" class="form-control">
                            @for ($year = date('Y'); $year >= 2024; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
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
                            <table id="receivables-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 130px);">
                                <thead>
                                    <tr>
                                        <th class="text-white text-center">#</th>
                                        <th class="sticky" style="right: 0px; white-space: nowrap;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span>الاسم</span>
                                                <div class="filter-dropdown ml-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-filter" id="btn-filter-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-pocket text-white"></i>
                                                        </button>
                                                        <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="employee_name_filter">
                                                            <!-- إضافة checkboxes بدلاً من select -->
                                                            <div class="searchable-checkbox">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <input type="search" class="form-control search-checkbox" data-index="1" placeholder="ابحث...">
                                                                    <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="1" data-field="employee_name">
                                                                        <i class="fe fe-check"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="checkbox-list-box">
                                                                    <label style="display: block;">
                                                                        <input type="checkbox" value="all" class="all-checkbox" data-index="1"> الكل
                                                                    </label>
                                                                    <div class="checkbox-list checkbox-list-1">
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
                                                        <button class="btn btn-secondary btn-filter" id="btn-filter-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-pocket text-white"></i>
                                                        </button>
                                                        <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="association_filter">
                                                            <!-- إضافة checkboxes بدلاً من select -->
                                                            <div class="searchable-checkbox">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <input type="search" class="form-control search-checkbox" data-index="2" placeholder="ابحث...">
                                                                    <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="2" data-field="association_field">
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-white text-center" id="row_count">#</td>
                                        <td style="white-space: nowrap;" class="text-left">الإجمالي</td>
                                        <td></td>
                                        <td id="total_3"></td>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade pills-exchanges" id="pills-exchanges" role="tabpanel" aria-labelledby="pills-exchanges-tab">
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تاريخ الصرف</th>
                                        <th>الموظف</th>
                                        <th>المبلغ المصروف</th>
                                        <th>المبلغ المضاف</th>
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
                                        <td>{{$exchange->receivables_discount}}</td>
                                        <td>{{$exchange->receivables_addition}}</td>
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
                                                <form action="{{route('exchanges.printPdf',$exchange->id)}}" method="post" target="_blank">
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
                let table = $('#receivables-table').DataTable({
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
                        url: '{{ route("receivables.index") }}',
                        type: 'GET',
                        data: function(d) {
                            d.year = $('#year').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
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
                        { data: 'total_receivables', name: 'total_receivables', orderable: false, render: function(data, type, row) {
                            let field = `<x-form.input name="total_receivables_${row.id}" style="width: 80px; padding: 0 5px;" type="number" value="${data}" step="0.01" min="0" />`;
                            return field;
                        }},
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('edit','App\\Models\ReceivablesLoans')
                            let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":receivable"><i class="fe fe-edit"></i></button>`.replace(':receivable', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\ReceivablesLoans')
                            return `
                                <form method="post" action="{{ route('receivables.view_pdf', ':receivables' )}}" target="_blank">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-icon p-1 text-info">
                                        <i class="fe fe-printer"></i>
                                    </button>
                                </form>
                                `.replace(':receivables', data);
                            @else
                            return '';
                            @endcan
                        }},
                    ],
                    columnDefs: [
                        { targets: 0, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#receivables-table tbody tr').each(function() {
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

                        for (let i = 3; i < 16; i++) {
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
                    isColumnFiltered(1) ? '' : populateFilterOptions(1, '.checkbox-list-1','employee_name');
                    isColumnFiltered(2) ? '' : populateFilterOptions(2, '.checkbox-list-2','association_field');
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
                    editReceivablesForm(id);
                });
                function editReceivablesForm(id) {
                    $.ajax({
                        url: "{{ route('receivables.update', ':id') }}".replace(':id', id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        data: {
                            total_receivables: $('input[name="total_receivables_' + id + '"]').val(),
                        },  // البيانات التي تم جمعها من النموذج
                        success: function(response) {
                            table.ajax.reload();
                            alert('تم التعديل بنجاح');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        }
                    });
                }
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
    @endpush
</x-front-layout>
