<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الإجماليات</h2>
                    <p class="card-text">هنا يتم عرض جدول الإجماليات</p>
                </div>
                <div class="col-auto">
                    <a type="button" class="btn btn-success" data-toggle="modal" data-target="#createItem">
                        <i class="fe fe-plus"></i>
                    </a>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#editItem">
                        Launch demo modal
                    </button>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الموظف</th>
                                        <th>إجمالي المستحقات</th>
                                        <th>إجمالي الإدخارات</th>
                                        <th>إجمالي القروض</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totals as $total)
                                    <tr class="total_select" data-id="{{$total->id}}">
                                        <td>{{$total->id}}</td>
                                        <td>{{$total->employee->name}}</td>
                                        <td>{{$total->total_receivables}}</td>
                                        <td>{{$total->total_savings}}</td>
                                        <td>{{$total->total_association_loan}}</td>
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
    <div class="modal fade" id="createItem" tabindex="-2" role="dialog" aria-labelledby="createItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemLabel">إنشاء إجماليات جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('totals.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="form-group p-1 col-6">
                            <label for="gender">رقم الموظف</label>
                            <div class="input-group mb-3">
                                <x-form.input name="employee_id" placeholder="0" readonly required />
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee" >
                                        <i class="fe fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0"  label="إجمالي المستحقات" name="total_receivables" placeholder="5000...." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0"  label="إجمالي الإدخارات" name="total_savings" placeholder="5000...." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0"  label="إجمالي القروض" name="total_association_loan" placeholder="5000...." />
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
    <div class="modal fade" id="editItem" tabindex="-3" role="dialog" aria-labelledby="editItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemLabel">تعديل نسبة </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body " id="showtotal">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('js/getEmployee.js') }}"></script>
    <script src="{{asset('js/getShowTotals.js')}}"></script>
@endpush
</x-front-layout>
