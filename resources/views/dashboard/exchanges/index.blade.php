<x-front-layout  classC="shadow p-0 mb-5 bg-white rounded">
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">

        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/stickyTable.css') }}">
        <link id="stickyTableDark" rel="stylesheet" href="{{ asset('css/stickyTableDark.css') }}" disabled>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatableIndex.css') }}">
    @endpush
    <x-slot:extra_nav>
        @can('create', 'App\\Models\Exchange')
        <li class="nav-item mx-2">
            <button type="button" class="btn btn-icon text-success my-2 mx-0" id="createNew">
                <i class="fe fe-plus fe-16"></i>
            </button>
        </li>
        @endcan
        <li class="nav-item d-flex align-items-center justify-content-center">
            <button type="button" class="btn" id="refreshData"><span class="fe fe-refresh-ccw fe-16 text-white"></span></button>
        </li>
    </x-slot:extra_nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="exchanges-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 100px);">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-white text-center">#</th>
                                <th>تاريخ الصرف</th>
                                <th class="sticky" style="right: 0px; white-space: nowrap;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الاسم</span>
                                        <div class="filter-dropdown ml-4" style="display: block;">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="employee_name_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="employee_name">
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
                                    <span>الجمعية</span>
                                </th>
                                <th>خصم المستحقات ش</th>
                                <th>خصم الإدخارات $</th>
                                <th>مكافأة مالية</th>
                                <th>قرض الجمعية</th>
                                <th>قرض الإدخار</th>
                                <th>قرض اللجنة</th>
                                <th>الملاحظات</th>
                                <th>المستخدم</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen modal -->
    <div class="modal fade modal-full" id="editExchanges" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
        </button>
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <form id="editForm">
                        @include('dashboard.exchanges.editModal')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- small modal -->

    <div class="modal fade" id="searchEmployee" tabindex="-5" role="dialog" aria-labelledby="searchEmployeeLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchEmployeeLabel">البحث عن الموظفين</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_id_search" label="رقم الهوية" type="number" class="employee_fields_search"
                                    placeholder="إملا رقم هوية الموظف"  />
                            </div>
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_name_search" label="إسم الموظف" type="text" class="employee_fields_search"
                                    placeholder="إملا إسم الموظف" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">رقم الموظف</th>
                                    <th scope="col">رقم الهوية</th>
                                    <th scope="col">الإسم</th>
                                    <th scope="col">تاريخ الميلاد</th>
                                </tr>
                            </thead>
                            <tbody id="table_employee">
                                <tr>
                                    <td colspan='4'>يرجى تعبئة البيانات</td>
                                </tr>
                            </tbody>
                        </table>
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
                let table = $('#exchanges-table').DataTable({
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
                        url: '{{ route("exchanges.index") }}',
                        type: 'GET',
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('edit','App\\Models\Exchange')
                            let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":allocation"><i class="fe fe-edit"></i></button>`.replace(':allocation', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'discount_date', name: 'discount_date', orderable: false},
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
                        { data: 'receivables_discount', name: 'receivables_discount', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'savings_discount', name: 'savings_discount', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'reward', name: 'reward', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'association_loan', name: 'association_loan', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'savings_loan', name: 'savings_loan', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'shekel_loan', name: 'shekel_loan', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'notes', name: 'notes', orderable: false},
                        { data: 'username', name: 'username', orderable: false},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\Allocation')
                            return `
                                <form method="post" action="{{route('exchanges.printPdf',':exchanges')}}" target="_blank">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-icon p-1 text-info">
                                        <i class="fe fe-printer"></i>
                                    </button>
                                </form>
                                `.replace(':exchanges', data);
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'delete', name: 'delete', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('delete','App\\Models\Exchange')
                            let link = `<button class="btn btn-sm p-1 btn-icon text-danger delete_row"  style="padding: 1px;" data-id=":allocation"><i class="fe fe-trash"></i></button>`.replace(':allocation', data);
                            return link ;
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
                        $('#exchanges-table tbody tr').each(function() {
                            $(this).find('td').eq(2).css('right', '0px');
                        });
                    },
                    footerCallback: function(row, data, start, end, display) {
                        // let api = this.api();
                        // // تحويل القيم النصية إلى أرقام
                        // let intVal = function(i) {
                        //     return typeof i === 'string' ?
                        //         parseFloat(i.replace(/[\$,]/g, '')) :
                        //         typeof i === 'number' ? i : 0;
                        // };
                        // // 1. حساب عدد الأسطر في الصفحة الحالية
                        // // count_allocations 1
                        // let rowCount = display.length;

                        // for (let i = 5; i < 23; i++) {
                        //     let total = api
                        //         .column(i, { page: 'current' })
                        //         .data()
                        //         .reduce(function(a, b) {
                        //             b = formatData(b, $('#total_' + i).data('field'));
                        //             return intVal(a) + intVal(b);
                        //         }, 0);
                        //     $('#total_' + i).html(formatNumber(total,2));
                        // }
                        // // 4. عرض النتائج في `tfoot`

                        // $('#count_rows').html(formatNumber(rowCount));
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
                    isColumnFiltered(3) ? '' : populateFilterOptions(3, '.checkbox-list-3','employee_name');
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
                        url: '{{ route("exchanges.destroy", ":id") }}'.replace(':id', id),
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
                $(document).on('click', '.edit_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    editExchangesForm(id);
                });
                let exhanges = {
                    id : '',
                    name: '',
                    employee_id: '',
                    exchange_type: '',
                    discount_date: '',
                    notes: '',
                    username: '',
                    receivables_discount: 0,
                    savings_discount: 0,
                    reward : 0,
                    association_loan: 0,
                    savings_loan: 0,
                    shekel_loan: 0,
                    totals: [],
                };
                function editExchangesForm(id) {
                    $.ajax({
                        url: '{{ route("exchanges.edit", ":id") }}'.replace(':id', id),
                        method: 'GET',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            exhanges.id = response.id;
                            exhanges.name = response.name;
                            exhanges.employee_id = response.employee_id;
                            exhanges.totals = response.totals;
                            exhanges.exchange_type = response.exchange_type;
                            exhanges.discount_date = response.discount_date;
                            exhanges.notes = response.notes;
                            exhanges.username = response.username;
                            exhanges.receivables_discount = response.receivables_discount;
                            exhanges.savings_discount = response.savings_discount;
                            exhanges.reward = response.reward;
                            exhanges.association_loan = response.association_loan;
                            exhanges.savings_loan = response.savings_loan;
                            exhanges.shekel_loan = response.shekel_loan;
                            $.each(exhanges, function(key, value) {
                                let input = $('#' + key); // البحث عن العنصر باستخدام id
                                if (input.length) { // التحقق إذا كان العنصر موجودًا
                                    input.val(value); // تعيين القيمة
                                }
                            });
                            $('#employee_name').text(response.name);
                            $('#receivables_total').text(formatNumber(exhanges.totals.total_receivables,2));
                            $('#savings_total').text(formatNumber(exhanges.totals.total_savings,2));
                            $('#editExchanges').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    });
                }
                $(document).on('click', '#update', function () {
                    let formData = $('#editForm').serialize(); // جمع بيانات النموذج في سلسلة بيانات
                    let association_loan_total = parseFloat($('#association_loan_total').text()) || 0;
                    let savings_loan_total = parseFloat($('#savings_loan_total').text()) || 0;
                    let shekel_loan_total = parseFloat($('#shekel_loan_total').text()) || 0;
                    if(association_loan_total < 0 || savings_loan_total < 0 || shekel_loan_total < 0){
                        alert('لا يمكن أن يكون إجمالي القروض أقل من الصفر يرجى التدقيق لخصم القروض');
                        return;
                    }
                    $.ajax({
                        url: "{{ route('fixed_entries.update', ':id') }}".replace(':id', entry.id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            year: year
                        },
                        data: formData,  // البيانات التي تم جمعها من النموذج
                        success: function(response) {
                            $('#editExchanges').modal('hide');
                            table.ajax.reload();
                            alert('تم التعديل بنجاح');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        }
                    });
                });
                $(document).on('click', '#createNew', function () {
                    $.ajax({
                        url: '{{ route("exchanges.create") }}',
                        method: 'GET',
                        success: function (response) {
                            allocation.id = response.id;
                            allocation.date_allocation = response.date_allocation;
                            allocation.budget_number = response.budget_number;
                            allocation.broker_name = response.broker_name;
                            allocation.organization_name = response.organization_name;
                            allocation.project_name = response.project_name;
                            allocation.item_name = response.item_name;
                            allocation.quantity = response.quantity;
                            allocation.price = response.price;
                            allocation.total_dollar = response.total_dollar;
                            allocation.allocation = response.allocation;
                            allocation.currency_allocation = response.currency_allocation;
                            allocation.currency_allocation_name = response.currency_allocation_name;
                            allocation.currency_allocation_value = response.currency_allocation_value;
                            allocation.amount = response.amount;
                            allocation.number_beneficiaries = response.number_beneficiaries;
                            allocation.implementation_items = response.implementation_items;
                            allocation.date_implementation = response.date_implementation;
                            allocation.implementation_statement = response.implementation_statement;
                            allocation.amount_received = response.amount_received;
                            allocation.arrest_receipt_number = response.arrest_receipt_number;
                            allocation.notes = response.notes;
                            allocation.user_name = response.user_name;
                            allocation.manager_name = response.manager_name;
                            $.each(allocation, function(key, value) {
                                const input = $('#' + key); // البحث عن العنصر باستخدام id
                                if (input.length) { // التحقق إذا كان العنصر موجودًا
                                    input.val(value); // تعيين القيمة
                                }
                            });
                            $('#addAllocation').remove();
                            $('#update').remove();
                            $('#btns_form').append(`
                                <button type="button" id="addAllocation" class="btn btn-primary mx-2">
                                    <i class="fe fe-plus"></i>
                                    أضف
                                </button>
                            `);
                            $('.editForm').css('display','none');
                            $('#editAllocation').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                });
                $(document).on('click', '#addAllocation', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    createAllocationForm(id);
                });
                function createAllocationForm(id){
                    $.each(allocation, function(key, value) {
                        const input = $('#' + key); // البحث عن العنصر باستخدام id
                        if(key == 'id'){
                            allocation['id'] = null;
                        }else if(key == 'currency_allocation_value'){
                            allocation['currency_allocation_value'] = 1 / $('#currency_allocation_value').val();
                        }else{
                            allocation[key] = input.val();
                        }
                    });
                    console.log(allocation);
                    $.ajax({
                        url: "{{ route('exchanges.store') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: allocation,
                        success: function (response) {
                            $('#editAllocation').modal('hide');
                            table.ajax.reload();
                            alert('تم إضافة التخصيص بنجاح');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                };

            });
        </script>
        <script>
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
