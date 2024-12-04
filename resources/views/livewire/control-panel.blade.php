<div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/stickyTable.css') }}">
        <style>
            th{
                color: #000 !important;
                padding: 10px 12px !important;
            }
            td{
                padding: 4px 12px !important;
            }
        </style>
    @endpush
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body p-2 d-flex justify-content-between">
                    <div class="form-group col-3 m-0 p-0">
                        <input type="search" class="form-control" placeholder="بحث بالاسم" id="name-search">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-info" id="store-btn" data-toggle="modal" data-target="#store-modal">
                            <i class="fe fe-external-link"></i>
                        </button>
                        <i class="fe fe-fe-check-circle"></i>
                        <button class="btn btn-warning" id="filter-btn" data-toggle="modal" data-target="#filter-modal">
                            <i class="fe fe-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <form id="employees-form" method="POST">
                        <table class="table table-bordered table-hover mb-0 sticky" id="employees-table" style="display: table; height: 100%;">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>رقم الهوية</th>
                                    <th>نوع التعين</th>
                                    <th>الجمعية</th>
                                    <th>مكان العمل</th>
                                    <th>مجال العمل</th>
                                    <th>العلاوة</th>
                                    <th>الدرجة</th>
                                    <th>الحالة</th>
                                    <th>العمر</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr for="employee_id" class="employee-row" data-employee-id="{{ $employee->id }}">
                                        <th>
                                            <input type="checkbox" name="employees_id[]" id="employee_id_{{ $employee->id }}" value="{{ $employee->id }}">
                                        </th>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->employee_id }}</td>
                                        <td>{{ $employee->workData->type_appointment }}</td>
                                        <td>{{ $employee->workData->association }}</td>
                                        <td>{{ $employee->workData->workplace }}</td>
                                        <td>{{ $employee->workData->field_action }}</td>
                                        <td>{{ $employee->workData->allowance }}</td>
                                        <td>{{ $employee->workData->grade }}</td>
                                        <td>{{ $employee->workData->state_effectiveness }}</td>
                                        <td>{{ $employee->age }}</td>
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('edit', 'App\\Models\Employee')
                                                    <a class="dropdown-item"
                                                        style="margin: 0.5rem -0.75rem; text-align: right;"
                                                        href="{{ route('employees.edit', $employee->id) }}">تعديل</a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-right modal-slide" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">فلترة الموظفين</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="area" placeholder="أدخل المنطقة" label="المنظقة"
                                list="areas_list" wire:model="filter.area" />
                            <datalist id="areas_list">
                                @foreach ($areas as $area)
                                    <option value="{{ $area }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="matrimonial_status"
                                placeholder="أدخل الحالة الزوجية" label="الحالة الزوجية" list="matrimonial_status_list" wire:model="filter.matrimonial_status" />
                            <datalist id="matrimonial_status_list">
                                @foreach ($matrimonial_status as $matrimonial_status)
                                    <option value="{{ $matrimonial_status }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="scientific_qualification"
                                placeholder="أدخل المؤهل العلمي" label="المؤهل العلمي"
                                list="scientific_qualification_list" wire:model="filter.scientific_qualification" />
                            <datalist id="scientific_qualification_list">
                                @foreach ($scientific_qualification as $scientific_qualification)
                                    <option value="{{ $scientific_qualification }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="gender" placeholder="أدخل الجنس" label="الجنس"
                                list="gender_list" wire:model="filter.gender" />
                            <datalist id="gender_list">
                                <option value="ذكر">
                                <option value="انثى">
                            </datalist>
                        </div>
                        {{-- بيانات العمل --}}
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="working_status" placeholder="أدخل حالة الدوام"
                                label="حالة الدوام" list="working_status_list" wire:model="filter.working_status" />
                            <datalist id="working_status_list">
                                @foreach ($working_status as $working_status)
                                    <option value="{{ $working_status }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="type_appointment" placeholder="أدخل نوع التعين"
                                label="نوع التعين" list="type_appointment_list" wire:model="filter.type_appointment" />
                            <datalist id="type_appointment_list">
                                @foreach ($type_appointment as $type_appointment)
                                    <option value="{{ $type_appointment }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="field_action" placeholder="أدخل مجال العمل"
                                label="مجال العمل" list="field_action_list" wire:model="filter.field_action" />
                            <datalist id="field_action_list">
                                @foreach ($field_action as $field_action)
                                    <option value="{{ $field_action }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="dual_function" placeholder="أدخل الحالة"
                                label="مزدوج الوظيفة" list="dual_function_list" wire:model="filter.dual_function" />
                            <datalist id="dual_function_list">
                                <option value="غير موظف">
                                <option value="موظف">
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="state_effectiveness"
                                placeholder="أدخل حالة الفعالية" label="حالة الفعالية" list="state_effectiveness_list"  wire:model="filter.state_effectiveness" />
                            <datalist id="state_effectiveness_list">
                                @foreach ($state_effectiveness as $state_effectiveness)
                                    <option value="{{ $state_effectiveness }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="nature_work" placeholder="أدخل طبيعة العمل"
                                label="طبيعة العمل" list="nature_work_list" wire:model="filter.nature_work" />
                            <datalist id="nature_work_list">
                                @foreach ($nature_work as $nature_work)
                                    <option value="{{ $nature_work }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="association" placeholder="أدخل الجمعية"
                                label="الجمعية" list="association_list" wire:model="filter.association" />
                            <datalist id="association_list">
                                @foreach ($association as $association)
                                    <option value="{{ $association }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="workplace" placeholder="أدخل مكان العمل"
                                label="مكان العمل" list="workplace_list" wire:model="filter.workplace" />
                            <datalist id="workplace_list">
                                @foreach ($workplace as $workplace)
                                    <option value="{{ $workplace }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="section" placeholder="أدخل القسم" label="القسم"
                                list="section_list" wire:model="filter.section" />
                            <datalist id="section_list">
                                @foreach ($section as $section)
                                    <option value="{{ $section }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="dependence" placeholder="أدخل التبعية"
                                label="التبعية" list="dependence_list" wire:model="filter.dependence" />
                            <datalist id="dependence_list">
                                @foreach ($dependence as $dependence)
                                    <option value="{{ $dependence }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="establishment" placeholder="أدخل المنشأة"
                                label="المنشأة" list="establishment_list" wire:model="filter.establishment" />
                            <datalist id="establishment_list">
                                @foreach ($establishment as $establishment)
                                    <option value="{{ $establishment }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input class="employee_filter" name="payroll_statement" placeholder="أدخل بيان الراتب"
                                label="بيان الراتب" list="payroll_statement_list" wire:model="filter.payroll_statement" />
                            <datalist id="payroll_statement_list">
                                @foreach ($payroll_statement as $payroll_statement)
                                    <option value="{{ $payroll_statement }}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn mb-2 btn-danger">مسح</button>
                    <button type="button" class="btn mb-2 btn-info" data-dismiss="modal" wire:click="filterEmployees">بحث</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="store-modal" tabindex="-1" role="dialog" aria-labelledby="store-modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="store-modalTitle">نموذج التعبئة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12">
                        <label for="type">إختر نوع التحديد</label>
                        <select name="type" id="type">
                            <option value="" selected disabled>النوع</option>
                            <option value="exchange">صرف</option>
                            <option value="editData">تعديل بيانات</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn mb-2 btn-primary">إرسال</button>
                </div>
            </div>
        </div>
    </div>

    @can('create', 'App\\Models\Exchange')
    <div class="modal fade" id="createExchange" tabindex="-2" role="dialog" aria-labelledby="createItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemLabel">إنشاء صرف جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="col-12" id="createExchangeForm">
                        @csrf
                        <div class="row">
                            <div class="form-group p-1 col-6">
                                <label for="exchange_type">نوع الصرف</label>
                                <select class="custom-select" name="exchange_type" id="exchange_type" required>
                                    <option selected="" value="">إختر</option>
                                    <option value="receivables_discount">خصم المستحقات ش</option>
                                    <option value="savings_discount">خصم الإدخارات $</option>
                                    <option value="receivables_savings_discount">خصم المستحقات والإدخارات</option>
                                    <option value="reward">مكافأة</option>
                                    <option value="association_loan">قرض الجمعية ش</option>
                                    <option value="savings_loan">قرض الإدخار $</option>
                                    <option value="shekel_loan">قرض اللجنة ش</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group p-3 col-4 exchanges" id="receivables" style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="خصم المستحقات ش" name="receivables_discount" placeholder="0.." />
                                <span class="totals" id="receivables_total">
                                    {{$totals['total_receivables'] ?? ''}}
                                </span>
                            </div>
                            <div class="form-group p-3 col-4 exchanges" id="savings"  style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="خصم الإدخارات $" name="savings_discount" placeholder="0.." />
                                <span class="totals" id="savings_total">
                                    {{$totals['total_savings']  ?? ''}}
                                </span>
                            </div>
                            <div class="form-group p-3 col-4 exchanges" id="reward"  style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="صرف مكافأة ش" name="reward" placeholder="0.." />
                            </div>
                            <div class="form-group p-3 col-4 exchanges" id="association_loan"  style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="صرف قرض الجمعية" name="association_loan" placeholder="0.." />
                            </div>
                            <div class="form-group p-3 col-4 exchanges" id="savings_loan"  style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="صرف قرض الإدخار" name="savings_loan" placeholder="0.." />
                            </div>
                            <div class="form-group p-3 col-4 exchanges" id="shekel_loan"  style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="صرف قرض اللجنة" name="shekel_loan" placeholder="0.." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"  label="تاريخ الصرف" name="discount_date"  />
                            </div>
                            <div class="form-group p-3 col-12">
                                <label for="notes">ملاحظات حول الصرف</label>
                                <textarea class="form-control" id="notes" name="notes" placeholder="....." rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    أضف
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @push('scripts')
        <script src='{{asset('js/select2.min.js')}}'></script>
        <script src="{{ asset('js/exchange.js') }}"></script>
        <script>
            $('.select2-multi').select2(
            {
                multiple: true,
                theme: 'bootstrap4',
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#selectAll').on('click', function() {
                    var isChecked = $(this).prop('checked');
                    $('input[type="checkbox"]').not(this).prop('checked', isChecked);
                });
                $('.employee-row').on('click', function() {
                    var checkbox = $(this).find('input[type="checkbox"]');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                });
                $('#name-search').on('input', function() {
                    let searchTerm = $(this).val().toLowerCase();
                    console.log(searchTerm);
                    $('#employees-table tbody tr').each(function() {
                        let employeeName = $(this).find('td').eq(1).text().toLowerCase();
                        if (employeeName.indexOf(searchTerm) === -1) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
                $('#type').on('change', function() {
                    let type = $(this).val();
                    if(type == "exchange"){
                        $('#createExchange').modal('show');
                    }else{
                        // $('#createExchange').modal('hide');
                    }
                });
                $('#store').on('click', function() {
                    // $('#store-modal').modal('show');
                    let formData = $('#employees-form').serialize();
                    // استخدام URLSearchParams لتحليل السلسلة
                    let params = new URLSearchParams(formData);
                    // تحويل البيانات إلى كائن عادي
                    let employeesIdArray = params.getAll('employees_id[]');
                    $.ajax({
                        url: "{{ route('control-panel.store') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: {
                            formData : employeesIdArray,
                            type: 'exchange',
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    })
                })
            });
        </script>
    @endpush
</div>
