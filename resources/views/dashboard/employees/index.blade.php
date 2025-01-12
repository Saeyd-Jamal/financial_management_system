<x-front-layout>
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/buttons.dataTables.css')}}">


        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/stickyTable.css') }}">
        <link id="stickyTableDark" rel="stylesheet" href="{{ asset('css/stickyTableDark.css') }}" disabled>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatableIndex.css') }}">
    @endpush
    <x-slot:extra_nav>
        <li class="nav-item">
            <button type="button" class="btn btn-icon btn-success text-white" id="excel-export" title="تصدير excel">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16">
                    <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                </svg>
            </button>
        </li>
        @can('create', 'App\\Models\Employee')
        <li class="nav-item mx-2">
            <a href="{{ route('employees.create') }}" class="btn btn-icon text-success m-0">
                <i class="fe fe-plus fe-16"></i>
            </a>
        </li>
        @endcan
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
        <li class="nav-item d-flex align-items-center justify-content-center mx-2">
            <button type="button" class="btn" id="refreshData"><span class="fe fe-refresh-ccw fe-16 text-white"></span></button>
        </li>
    </x-slot:extra_nav>
    @php
        $fields = [
            'type_appointment' => 'نوع التعيين',
            'field_action' => 'مجال العمل',
            'allowance' => 'العلاوة',
            'grade' => 'الدرجة',
            'grade_allowance_ratio' => 'نسبة علاوة درجة',
            'dual_function' => 'مزدوج الوظيفة',
            'years_service' => 'سنوات الخدمة',
            'nature_work' => 'طبيعة العمل',
            'state_effectiveness' => 'حالة الفعالية',
            'association' => 'الجمعية',
            'workplace' => 'مكان العمل',
            'section' => 'القسم',
            'dependence' => 'التبعية',
            'working_date' => 'تاريخ العمل',
            'date_installation' => 'تاريخ التثبيت',
            'date_retirement' => 'تاريخ التقاعد',
            'payroll_statement' => 'بيان الراتب',
            'establishment' => 'المنشأة',
            'foundation_E' => 'المؤسسة E',
            'salary_category' => 'فئة الراتب',
            'contract_type' => 'نوع العقد',
        ];
    @endphp

    <div class="row">
        <div class="col-md-12" style="padding: 0 2px;">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="employees-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 100px);">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-white text-center">#</th>
                                <th class="sticky" style="right: 0px;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الاسم</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="name_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="2" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="2" data-field="name">
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
                                        <span>الهوية</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="id_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="employee_id">
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
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>تاريخ الميلاد</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-4" type="button" id="date_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="date_filter">
                                                    <div>
                                                        <input type="date" id="from_date" name="from_date_of_birth" class="form-control mr-2" style="width: 200px"/>
                                                        <input type="date" id="to_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" name="to_date_of_birth" class="form-control mr-2 mt-2" style="width: 200px"/>
                                                    </div>
                                                    <div>
                                                        <button id="filter-date-btn" class='btn btn-success text-white filter-apply-btn-data' data-target="4" data-field="date_of_birth">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>العمر</th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الحالة الزوجية</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-6" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="matrimonial_status_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="6" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="6" data-field="matrimonial_status">
                                                                <i class="fe fe-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="6"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-6">
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
                                        <span>المؤهل العلمي</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-7" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="scientific_qualification_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="7" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="7" data-field="scientific_qualification">
                                                                <i class="fe fe-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="7"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-7">
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
                                        <span>المنطقة</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-8" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="area_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="8" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="8" data-field="area_field">
                                                                <i class="fe fe-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="8"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-8">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                {{-- 9 --}}
                                <th>الهاتف</th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>حالة الدوام</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-10" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="working_status_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="10" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="10" data-field="working_status">
                                                                <i class="fe fe-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="10"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                @foreach ($fields as $index => $label)
                                    <th>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>{{ $label }}</span>
                                            <div class="filter-dropdown ml-4">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-filter" id="btn-filter-{{ $loop->index + 11 }}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fe fe-pocket text-white"></i>
                                                    </button>
                                                    <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="{{ $index }}_filter">
                                                        <div class="searchable-checkbox">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <input type="search" class="form-control search-checkbox" data-index="{{ $loop->index + 11 }}" placeholder="ابحث...">
                                                                <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="{{ $loop->index + 11 }}" data-field="{{ $index }}">
                                                                    <i class="fe fe-check"></i>
                                                                </button>
                                                            </div>
                                                            <div class="checkbox-list-box">
                                                                <label style="display: block;">
                                                                    <input type="checkbox" value="all" class="all-checkbox" data-index="{{ $loop->index + 11 }}"> الكل
                                                                </label>
                                                                <div class="checkbox-list checkbox-list-{{ $loop->index + 11 }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                @endforeach
                                {{-- <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الاسم</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="name_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="name">
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
                                </th> --}}
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            {{-- <tr>
                                <td></td>
                                <td class="text-white text-center" id="count_employees"></td>
                                <td class='sticky text-left' colSpan="3">المجموع</td>
                            </tr> --}}
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/datatable/dataTables.js')}}"></script>
        <script src="{{asset('js/datatable/dataTables.buttons.js')}}"></script>
        <script src="{{asset('js/datatable/buttons.dataTables.js')}}"></script>
        <script src="{{asset('js/datatable/jszip.min.js')}}"></script>
        <script src="{{asset('js/datatable/pdfmake.min.js')}}"></script>
        <script src="{{asset('js/datatable/vfs_fonts.js')}}"></script>
        <script src="{{asset('js/datatable/buttons.html5.min.js')}}"></script>
        <script src="{{asset('js/datatable/buttons.print.min.js')}}"></script>
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                let formatNumber = (number,min = 0) => {
                    // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                    if (number === null || number === undefined || isNaN(number)) {
                        return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                    }
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
                };
                const table = $('#employees-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,              // تعطيل الترقيم
                    searching: true,            // الإبقاء على البحث إذا كنت تريده
                    info: false,                // تعطيل النص السفلي الذي يوضح عدد السجلات
                    lengthChange: false,        // تعطيل قائمة تغيير عدد المدخلات
                    layout: {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    text: 'تصدير Excel',
                                    title: 'بيانات ips', // تخصيص العنوان عند التصدير
                                    className: 'd-none', // إخفاء الزر الأصلي
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21], // تحديد الأعمدة التي سيتم تصديرها (يمكن تعديلها حسب الحاجة)
                                        modifier: {
                                            search: 'applied', // تصدير البيانات المفلترة فقط
                                            order: 'applied',  // تصدير البيانات مع الترتيب الحالي
                                            page: 'all'        // تصدير جميع الصفحات المفلترة
                                        }
                                    }
                                },
                            ]
                        }
                    },
                    "language": {
                        "url": "{{ asset('files/Arabic.json')}}"
                    },
                    ajax: {
                        url: '{{ route("employees.index") }}',
                        data: function (d) {
                            // إضافة تواريخ التصفية إلى الطلب المرسل
                            d.from_date = $('#from_date').val();
                            d.to_date = $('#to_date').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('edit','App\\Models\Employee')
                            let link = `<a href="{{ route('employees.edit', ':employee') }}" class="btn btn-sm p-1 btn-icon text-primary"><i class="fe fe-edit"></i></a>`.replace(':employee', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, class: 'text-center'}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'employee_id', name: 'employee_id', orderable: false},
                        { data: 'date_of_birth', name: 'date_of_birth', orderable: false},
                        { data: 'age', name: 'age', orderable: false},
                        { data: 'matrimonial_status', name: 'matrimonial_status', orderable: false},
                        { data: 'scientific_qualification', name: 'scientific_qualification', orderable: false},
                        { data: 'area', name: 'area', orderable: false},
                        { data: 'phone_number', name: 'phone_number', orderable: false},
                        { data: 'working_status', name: 'working_status', orderable: false},
                        { data: 'type_appointment', name: 'type_appointment', orderable: false},
                        { data: 'field_action', name: 'field_action', orderable: false},
                        { data: 'allowance', name: 'allowance', orderable: false},
                        { data: 'grade', name: 'grade', orderable: false},
                        { data: 'grade_allowance_ratio', name: 'grade_allowance_ratio', orderable: false, render: function(data, type, row) {
                            return formatNumber(data) + '%';
                        }},
                        { data: 'dual_function', name: 'dual_function', orderable: false},
                        { data: 'years_service', name: 'years_service', orderable: false},
                        { data: 'nature_work', name: 'nature_work', orderable: false},
                        { data: 'state_effectiveness', name: 'state_effectiveness', orderable: false},
                        { data: 'association', name: 'association', orderable: false},
                        { data: 'workplace', name: 'workplace', orderable: false},
                        { data: 'section', name: 'section', orderable: false},
                        { data: 'dependence', name: 'dependence', orderable: false},
                        { data: 'working_date', name: 'working_date', orderable: false},
                        { data: 'date_installation', name: 'date_installation', orderable: false},
                        { data: 'date_retirement', name: 'date_retirement', orderable: false},
                        { data: 'payroll_statement', name: 'payroll_statement', orderable: false},
                        { data: 'establishment', name: 'establishment', orderable: false},
                        { data: 'foundation_E', name: 'foundation_E', orderable: false},
                        { data: 'salary_category', name: 'salary_category', orderable: false},
                        { data: 'contract_type', name: 'contract_type', orderable: false},
                        { data: 'delete', name: 'delete', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('delete','App\\Models\Employee')
                            return `
                                <button
                                    class="btn btn-icon p-1 text-danger delete_row"
                                    data-id="${data}">
                                    <i class="fe fe-trash"></i>
                                </button>`;
                            @else
                            return '';
                            @endcan
                        }}
                    ],
                    columnDefs: [
                        { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#employees-table tbody tr').each(function() {
                            $(this).find('td').eq(2).css('right', '0px');
                        });
                    },
                    // footerCallback: function(row, data, start, end, display) {
                    //     var api = this.api();
                    //     // تحويل القيم النصية إلى أرقام
                    //     var intVal = function(i) {
                    //         return typeof i === 'string' ?
                    //             parseFloat(i.replace(/[\$,]/g, '')) :
                    //             typeof i === 'number' ? i : 0;
                    //     };
                    //     // 1. حساب عدد الأسطر في الصفحة الحالية
                    //     // count_employees 1
                    //     var rowCount = display.length;
                    //     // total_quantity 8
                    //     var total_quantity_sum = api
                    //         .column(8, { page: 'current' }) // العمود الرابع
                    //         .data()
                    //         .reduce(function(a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // total_employee 11
                    //     var total_employee_sum = api
                    //         .column(11, { page: 'current' }) // العمود الرابع
                    //         .data()
                    //         .reduce(function(a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // total_amount 14
                    //     var total_amount_sum = api
                    //         .column(14, { page: 'current' }) // العمود الرابع
                    //         .data()
                    //         .reduce(function(a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // total_number_beneficiaries 15
                    //     var total_number_beneficiaries_sum = api
                    //         .column(15, { page: 'current' }) // العمود الرابع
                    //         .data()
                    //         .reduce(function(a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // total_amount_received 19
                    //     var total_amount_received_sum = api
                    //         .column(19, { page: 'current' }) // العمود الخامس
                    //         .data()
                    //         .reduce(function(a, b) {
                    //             return intVal(a) + intVal(b);
                    //         }, 0);

                    //     // المتبقي
                    //     let remaining = total_amount_sum - total_amount_received_sum;
                    //     let remaining_percent = (total_amount_received_sum / total_amount_sum) * 100;

                    //     // 4. عرض النتائج في `tfoot`

                    //     $('#count_employees').html(formatNumber(rowCount));
                    //     $('#total_quantity').html(formatNumber(total_quantity_sum));
                    //     $('#total_employee').html(formatNumber(total_employee_sum,2));
                    //     $('.total_amount').html(formatNumber(total_amount_sum,2));
                    //     $('#total_number_beneficiaries').html(formatNumber(total_number_beneficiaries_sum));
                    //     $('.total_amount_received').html(formatNumber(total_amount_received_sum,2));

                    //     $('.remaining').html(formatNumber(remaining,2));
                    //     $('.remaining_percent').html(formatNumber(remaining_percent,2));


                    //     // $('#employees-table_filter').addClass('d-none');
                    // }
                });
                // نسخ وظيفة الزر إلى الزر المخصص
                $('#excel-export').on('click', function () {
                    table.button('.buttons-excel').trigger(); // استدعاء وظيفة الزر الأصلي
                });
                $('#print-btn').on('click', function () {
                    table.button('.buttons-print').trigger(); // استدعاء وظيفة الطباعة الأصلية
                });
                $('#employees-table_filter').addClass('d-none');
                // جلب الداتا في checkbox
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
                    isColumnFiltered(2) ? '' : populateFilterOptions(2, '.checkbox-list-2','name');
                    isColumnFiltered(3) ? '' : populateFilterOptions(3, '.checkbox-list-3','employee_id');
                    isColumnFiltered(6) ? '' : populateFilterOptions(6, '.checkbox-list-6','matrimonial_status');
                    isColumnFiltered(7) ? '' : populateFilterOptions(7, '.checkbox-list-7','scientific_qualification');
                    isColumnFiltered(8) ? '' : populateFilterOptions(8, '.checkbox-list-8','area_field');
                    isColumnFiltered(10) ? '' : populateFilterOptions(10, '.checkbox-list-10','working_status');
                    isColumnFiltered(11) ? '' : populateFilterOptions(11, '.checkbox-list-11','type_appointment');
                    isColumnFiltered(12) ? '' : populateFilterOptions(12, '.checkbox-list-12','field_action');
                    isColumnFiltered(13) ? '' : populateFilterOptions(13, '.checkbox-list-13','allowance');
                    isColumnFiltered(14) ? '' : populateFilterOptions(14, '.checkbox-list-14','grade');
                    isColumnFiltered(15) ? '' : populateFilterOptions(15, '.checkbox-list-15','grade_allowance_ratio');
                    isColumnFiltered(16) ? '' : populateFilterOptions(16, '.checkbox-list-16','dual_function');
                    isColumnFiltered(17) ? '' : populateFilterOptions(17, '.checkbox-list-17','years_service');
                    isColumnFiltered(18) ? '' : populateFilterOptions(18, '.checkbox-list-18','nature_work');
                    isColumnFiltered(19) ? '' : populateFilterOptions(19, '.checkbox-list-19','state_effectiveness');
                    isColumnFiltered(20) ? '' : populateFilterOptions(20, '.checkbox-list-20','association');
                    isColumnFiltered(21) ? '' : populateFilterOptions(21, '.checkbox-list-21','workplace');
                    isColumnFiltered(22) ? '' : populateFilterOptions(22, '.checkbox-list-22','section');
                    isColumnFiltered(23) ? '' : populateFilterOptions(23, '.checkbox-list-23','dependence');
                    // isColumnFiltered(24) ? '' : populateFilterOptions(24, '.checkbox-list-24','working_date');
                    // isColumnFiltered(25) ? '' : populateFilterOptions(25, '.checkbox-list-25','date_installation');
                    // isColumnFiltered(26) ? '' : populateFilterOptions(26, '.checkbox-list-26','date_retirement');
                    isColumnFiltered(27) ? '' : populateFilterOptions(27, '.checkbox-list-27','payroll_statement');
                    isColumnFiltered(28) ? '' : populateFilterOptions(28, '.checkbox-list-28','establishment');
                    isColumnFiltered(29) ? '' : populateFilterOptions(29, '.checkbox-list-29','foundation_E');
                    isColumnFiltered(30) ? '' : populateFilterOptions(30, '.checkbox-list-30','salary_category');
                    isColumnFiltered(31) ? '' : populateFilterOptions(31, '.checkbox-list-31','contract_type');

                    for (let i = 1; i <= 31; i++) {
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
                // // تطبيق الفلترة عند الضغط على زر "check"
                $('.filter-apply-btn').on('click', function() {
                    let target = $(this).data('target');
                    let field = $(this).data('field');
                    var filterValue = $("input[name="+ field + "]").val();
                    table.column(target).search(filterValue).draw();
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
                // تطبيق التصفية عند النقر على زر "Apply"
                $('#filter-date-btn').on('click', function () {
                    const fromDate = $('#from_date').val();
                    const toDate = $('#to_date').val();
                    table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
                });
                // تفويض حدث الحذف على الأزرار الديناميكية
                $(document).on('click', '.delete_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    if (confirm('هل أنت متأكد من حذف العنصر؟')) {
                        deleteRow(id); // استدعاء وظيفة الحذف
                    }
                });
                // وظيفة الحذف
                function deleteRow(id) {
                    $.ajax({
                        url: '{{ route("employees.destroy", ":id") }}'.replace(':id', id),
                        method: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            alert('تم حذف العنصر بنجاح');
                            table.ajax.reload(); // إعادة تحميل الجدول بعد الحذف
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطاء في عملية الحذف.');
                        },
                    });
                }
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
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '#filterBtn', function() {
                    let text = $(this).text();
                    if (text != 'تصفية') {
                        $(this).text('تصفية');
                    }else{
                        $(this).text('إخفاء التصفية');
                    }
                    $('.filter-dropdown').slideToggle();
                });
                if (curentTheme == "light") {
                    $('#stickyTableLight').prop('disabled', false); // تشغيل النمط Light
                    $('#stickyTableDark').prop('disabled', true);  // تعطيل النمط Dark
                } else {
                    $('#stickyTableLight').prop('disabled', true);  // تعطيل النمط Light
                    $('#stickyTableDark').prop('disabled', false); // تشغيل النمط Dark
                }
                $(document).on('click', '#import_excel_btn', function() {
                    $('#editEmployee').modal('hide');
                    $('#import_excel').modal('show');
                })
            });
        </script>
        <script>
            $(document).ready(function() {
                let currentRow = 0;
                let currentCol = 0;

                // الحصول على الصفوف من tbody فقط
                const rows = $('#employees-table tbody tr');

                // إضافة الكلاس للخلايا عند تحميل الصفحة
                highlightCell(currentRow, currentCol);

                // التنقل باستخدام الأسهم
                $(document).on('keydown', function(e) {
                    // تحديث عدد الصفوف والأعمدة المرئية عند كل حركة
                    const totalRows = $('#employees-table tbody tr:visible').length;
                    const totalCols = $('#employees-table tbody tr:visible').eq(0).find('td').length;

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
                $('#employees-table tbody').on('dblclick', 'td', function() {
                    const cell = $(this);
                    currentRow = cell.closest('tr').index();
                    currentCol = cell.index();
                    highlightCell(currentRow, currentCol);
                });

                // دالة لتحديث الخلية النشطة
                function highlightCell(row, col) {
                    // استهداف الصفوف المرئية فقط
                    const visibleRows = $('#employees-table tbody tr:visible');
                    // التحقق من وجود الصف
                    if (visibleRows.length > row) {
                        // تحديد الصف والخلية المطلوبة
                        const targetRow = visibleRows.eq(row);
                        const targetCell = targetRow.find('td').eq(col);
                        if (targetCell.length) {
                            // إزالة التنسيقات السابقة
                            $('#employees-table tbody td').removeClass('active');
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
