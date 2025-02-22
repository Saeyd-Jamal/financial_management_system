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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="entries-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 100px);">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-white opacity-7 text-center">#</th>
                                <th class="sticky" style="right: 0px; white-space: nowrap;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>الاسم</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="employee_name_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="employee_name_filter">
                                                    <input type="text" name="employee_name" class="form-control mr-2  py-0 px-2" list="employee_names_list" style="width: 200px"/>
                                                    <datalist id="employee_names_list">
                                                        @foreach ($employee_names as $employee_name)
                                                            <option value="{{$employee_name}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="2" data-field="employee_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    الجمعية
                                </th>
                                <th>
                                    <span>مكان العمل</span>
                                </th>
                                <th>علاوة إدارية</th>
                                <th>علاوة مؤهل علمي</th>
                                <th>مواصلات</th>
                                <th>بدل إضافي</th>
                                <th>علاوة اغراض راتب</th>
                                <th>إضافة بأثر رجعي</th>
                                <th>علاوة جوال</th>
                                <th>تأمين صحي</th>
                                <th>ف.أوريدو</th>
                                <th>رسوم دراسية</th>
                                <th>تبرعات</th>
                                <th>خصم اللجنة</th>
                                <th>خصومات الإخرى</th>
                                <th>تبرعات للحركة</th>
                                <th>نسبة إدخار للموظف</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td class="text-white opacity-7 text-center" id="count_rows"></td>
                                <td class='sticky text-right'>المجموع</td>
                                <td></td>
                                <td></td>
                                <td class='text-white' id="total_5" data-field="administrative_allowance"></td>
                                <td class='text-white' id="total_6" data-field="scientific_qualification_allowance"></td>
                                <td class='text-white' id="total_7" data-field="transport"></td>
                                <td class='text-white' id="total_8" data-field="extra_allowance"></td>
                                <td class='text-white' id="total_9" data-field="salary_allowance"></td>
                                <td class='text-white' id="total_10" data-field="ex_addition"></td>
                                <td class='text-white' id="total_11" data-field="mobile_allowance"></td>
                                <td class='text-white' id="total_12" data-field="health_insurance"></td>
                                <td class='text-white' id="total_13" data-field="f_Oredo"></td>
                                <td class='text-white' id="total_14" data-field="tuition_fees"></td>
                                <td class='text-white' id="total_15" data-field="voluntary_contributions"></td>
                                <td class='text-white' id="total_16" data-field="paradise_discount"></td>
                                <td class='text-white' id="total_17" data-field="other_discounts"></td>
                                <td class='text-white' id="total_18" data-field="proportion_voluntary"></td>
                                <td class='text-white' id="total_19" data-field="savings_rate"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen modal -->
    <div class="modal fade modal-full" id="editEntries" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
        </button>
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <form id="editForm">
                        @include('dashboard.fixed_entries.editModal')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- small modal -->

    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/datatable/dataTables.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                const year = "{{ $year }}";
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
                let total = 0;
                var currentMonth = "{{ $lastMonth }}";
                let table = $('#entries-table').DataTable({
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
                        url: '{{ route("fixed_entries.index") }}',
                        data: function (d) {
                            d.year = year;
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('edit','App\\Models\FixedEntries')
                            let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":allocation"><i class="fe fe-edit"></i></button>`.replace(':allocation', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }
                        },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
                        { data: 'workplace', name: 'workplace', orderable: false},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'administrative_allowance');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'scientific_qualification_allowance');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'transport');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'extra_allowance');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'salary_allowance');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'ex_addition');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'mobile_allowance');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'health_insurance');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'f_Oredo');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'tuition_fees');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'voluntary_contributions');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'paradise_discount');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'other_discounts');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'proportion_voluntary');
                        }},
                        { data: 'fixedEntriesView', name: 'fixedEntriesView', orderable: false, render: function(data, type, row) {
                            return  formatData(data,'savings_rate');
                        }},
                    ],
                    columnDefs: [
                        { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#entries-table tbody tr').each(function() {
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
                        // count_allocations 1
                        let rowCount = display.length;

                        for (let i = 5; i < 20; i++) {
                            let total = api
                                .column(i, { page: 'current' })
                                .data()
                                .reduce(function(a, b) {
                                    b = formatData(b, $('#total_' + i).data('field'));
                                    return intVal(a) + intVal(b);
                                }, 0);
                            $('#total_' + i).html(formatNumber(total,2));
                        }



                        // 4. عرض النتائج في `tfoot`

                        $('#count_rows').html(formatNumber(rowCount));




                        // $('#allocations-table_filter').addClass('d-none');
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
                    editEntriesForm(id);
                });
                let entry = {
                    id : '',
                    name : '',
                    totals : [],
                };
                let name_entry = {
                    'administrative_allowance' : 'علاوة إدارية',
                    'scientific_qualification_allowance' : 'علاوة مؤهل علمي	',
                    'transport' : 'المواصلات',
                    'extra_allowance' : 'بدل إضافي',
                    'salary_allowance' : 'علاوة اغراض راتب',
                    'ex_addition' : 'إضافة بأثر رجعي',
                    'mobile_allowance' : 'علاوة جوال',
                    'health_insurance' : 'تأمين صحي',
                    'f_Oredo'  : 'فاتورة الوطنية',
                    'tuition_fees'  : 'رسوم دراسية',
                    'voluntary_contributions'  : 'تبرعات',
                    'paradise_discount'  : 'خصم اللجنة',
                    'other_discounts'  : 'خصومات أخرى',
                    'proportion_voluntary'  : 'تبرعات للحركة',
                    'savings_rate'  : 'نسبة إدخار للموظف',
                };
                function editEntriesForm(id) {
                    $.ajax({
                        url: '{{ route("fixed_entries.getData") }}',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            entry.id = response.id;
                            entry.name = response.name;
                            $('#employee_name').text(entry.name);
                        }
                    });
                    $.ajax({
                        url: '{{ route("fixed_entries.edit", ":id") }}'.replace(':id', id),
                        method: 'GET',
                        success: function (response) {
                            let data = response;
                            $('#fixed_entries_tbody').empty();
                            $.each(name_entry, function(key, value) {
                                $('#fixed_entries_tbody').append(`
                                    <tr id="${key}_row">
                                        <td class="text-left">${value}</td>
                                    </tr>
                                `);
                                let staticEntry = data.find(entry => entry.month === "0000-00");
                                let staticVal = 0;
                                if(staticEntry){
                                    staticVal = staticEntry[key];
                                    if(staticVal == -1.00){
                                        staticVal = '';
                                    }
                                }else{
                                    staticVal = '';
                                }
                                if(key == "savings_rate"){
                                    $('#' + key + '_row').append(`
                                        <td>
                                            <input type="checkbox" id="${key}-0000" name="${key}-0000" ${staticVal == 1 ? 'checked' : ''} class="form-control const" style="width: 20px" month="0000-00" data-field="${key}">
                                        </td>
                                    `);
                                }else{
                                    $('#' + key + '_row').append(`
                                        <td>
                                            <x-form.input  month="0000-00" data-field="${key}" name="${key}-0000" value="${staticVal}" class="const" />
                                        </td>
                                    `);
                                }

                                for (let i = 1; i <= 12; i++) {
                                    if(i<10){
                                        i = '0'+i;
                                    }
                                    let  monthToFind = year + "-" + i;
                                    let foundEntry = data.find(entry => entry.month === monthToFind);
                                    let val = 0;
                                    if(foundEntry){
                                        val = foundEntry[key];
                                    }else{
                                        val = '0.00';
                                    }
                                    if(key == "savings_rate"){
                                        $('#' + key + '_row').append(`
                                            <td>
                                                <input type="checkbox" id="${key}-${i}" name="${key}-${i}" ${val == 1 ? 'checked' : ''} class="form-control" month="${i}" style="width: 20px"  employee_id="${id}" field="${key}">
                                            </td>
                                        `);
                                    }else{
                                        $('#' + key + '_row').append(`
                                            <td>
                                                <x-form.input value="${val}"  employee_id="${id}" field="${key}" month="${i}" name="${key}-${i}" />
                                            </td>
                                        `);
                                    }
                                    
                                    if(currentMonth != '12'){
                                        if (i <= currentMonth) {
                                            $("#" + key + "-" + i).attr('disabled', true);  // تعطيل الحقل إذا كان الشهر الحالي أكبر من الشهر المحدد
                                        }
                                    }

                                }
                            });
                            $('#editEntries').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                }
                $(document).on('click', '#update', function () {
                    let formData = $('#editForm').serialize(); // جمع بيانات النموذج في سلسلة بيانات
                    $.ajax({
                        url: "{{ route('fixed_entries.update', ':id') }}".replace(':id', entry.id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            year: year
                        },
                        data: formData,  // البيانات التي تم جمعها من النموذج
                        success: function(response) {
                            $('#editEntries').modal('hide');
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
                    console.log(field,value);
                    if(field == "savings_rate"){
                        for (let i = 1; i <= 12; i++) {
                            i = i < 10 ? '0' + i : i;
                            if (currentMonth != '12'){
                                if (i > currentMonth) {
                                    let fieldId = '#' + field + '-' + i;
                                    if ($(this).is(':checked')) {
                                        $(fieldId).prop('checked', true);
                                    } else {
                                        $(fieldId).prop('checked', false);
                                    }
                                }
                            }else{
                                let fieldId = '#' + field + '-' + i;
                                if ($(this).is(':checked')) {
                                    $(fieldId).prop('checked', true);
                                } else {
                                    $(fieldId).prop('checked', false);
                                }
                            }
                        }
                    }else{
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
                    }
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
            });
        </script>
        <script>
            $(document).ready(function() {
                let currentRow = 0;
                let currentCol = 0;

                // الحصول على الصفوف من tbody فقط
                const rows = $('#entries-table tbody tr');

                // إضافة الكلاس للخلايا عند تحميل الصفحة
                highlightCell(currentRow, currentCol);

                // التنقل باستخدام الأسهم
                $(document).on('keydown', function(e) {
                    // تحديث عدد الصفوف والأعمدة المرئية عند كل حركة
                    const totalRows = $('#entries-table tbody tr:visible').length;
                    const totalCols = $('#entries-table tbody tr:visible').eq(0).find('td').length;

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
                $('#entries-table tbody').on('dblclick', 'td', function() {
                    const cell = $(this);
                    currentRow = cell.closest('tr').index();
                    currentCol = cell.index();
                    highlightCell(currentRow, currentCol);
                });

                // دالة لتحديث الخلية النشطة
                function highlightCell(row, col) {
                    // استهداف الصفوف المرئية فقط
                    const visibleRows = $('#entries-table tbody tr:visible');
                    // التحقق من وجود الصف
                    if (visibleRows.length > row) {
                        // تحديد الصف والخلية المطلوبة
                        const targetRow = visibleRows.eq(row);
                        const targetCell = targetRow.find('td').eq(col);
                        if (targetCell.length) {
                            // إزالة التنسيقات السابقة
                            $('#entries-table tbody td').removeClass('active');
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
