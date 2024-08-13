<x-front-layout classC="shadow p-3 mb-5 bg-white rounded">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الصرف</h2>
                    <p class="card-text">هنا يتم عرض الصرف الذي يحدث للموظف من المستحقات والقروض</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\Exchange')
                    <a type="button" class="btn btn-success" data-toggle="modal" data-target="#createItem">
                        <i class="fe fe-plus"></i>
                    </a>
                    @endcan
                    {{-- <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#editItem">
                        Launch demo modal
                    </button> --}}
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered  table-hover datatables"  id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الموظف</th>
                                        <th>خصم المستحقات ش</th>
                                        <th>خصم الإدخارات $</th>
                                        <th>تاريخ الخصم</th>
                                        <th>المستخدم</th>
                                        <th>حدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exchanges as $exchange)
                                    <tr class="exchange_select" data-id="{{$exchange->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$exchange->employee->name}}</td>
                                        <td>{{$exchange->receivables_discount}}</td>
                                        <td>{{$exchange->savings_discount}}</td>
                                        <td>{{$exchange->discount_date}}</td>
                                        <td>{{$exchange->username}}</td>
                                        <td>
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                {{-- <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('salaries.edit',$salary->id)}}">تعديل</a> --}}
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
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    {{-- create model --}}
    @can('create', 'App\\Models\Exchange')
    <div class="modal fade" id="createItem" tabindex="-2" role="dialog" aria-labelledby="createItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemLabel">إنشاء إجماليات جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('exchanges.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="row">
                            <div class="form-group p-1 col-6">
                                <label for="employee_id">رقم الموظف</label>
                                <div class="input-group mb-3">
                                    <x-form.input name="employee_id" placeholder="0" value="{{$employee_id ?? 0}}" readonly required />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee" >
                                            <i class="fe fe-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group p-1 col-6">
                                <label for="discount_type">نوع الخصم</label>
                                <select class="custom-select" name="discount_type" id="discount_type" required>
                                    <option selected="" value="">إختر</option>
                                    <option value="receivables_discount">خصم المستحقات ش</option>
                                    <option value="savings_discount">خصم الإدخارات $</option>
                                    <option value="receivables_savings_discount">خصم المستحقات والإدخارات</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group p-3 col-4" id="receivables" style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="خصم المستحقات ش" name="receivables_discount" placeholder="0.." />
                                <span class="totals" id="receivables_total">
                                    {{$totals['total_receivables'] ?? ''}}
                                </span>
                            </div>
                            <div class="form-group p-3 col-4" id="savings"  style="display: none;">
                                <x-form.input type="number" min="0" value="0"  label="خصم الإدخارات $" name="savings_discount" placeholder="0.." />
                                <span class="totals" id="savings_total">
                                    {{$totals['total_savings']  ?? ''}}
                                </span>
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"  label="تاريخ الخصم" name="discount_date"  />
                            </div>
                            <div class="form-group p-3 col-12">
                                <label for="notes">ملاحظات حول الخصم</label>
                                <textarea class="form-control" id="notes" name="notes" placeholder="....." rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{$btn_label ?? "أضف"}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
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
        <script src="{{asset('assets/js/ajax.min.js')}}"></script>
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}";
        </script>
        {{-- <script src="{{ asset('js/getEmployee.js') }}"></script> --}}
        <script src="{{ asset('js/exchange.js') }}"></script>
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
        <script>
            $('#dataTable-1').DataTable(
            {
                autoWidth: true,
                "lengthMenu": [
                [10, 20, 100, -1],
                [10, 20, 100, "جميع"]
                ]
            });
        </script>
    @endpush
</x-front-layout>
