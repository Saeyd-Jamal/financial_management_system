<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول رواتب الموظفين</h2>
                    <p class="card-text">هنا يتم عرض الرواتب الشهرية لكل موظف</p>
                </div>
                <div class="col-auto">
                    {{-- @can('create', 'App\\Models\Salary')
                    <a class="btn btn-success" href="{{route('salaries.create')}}">
                        <i class="fe fe-plus"></i>
                    </a>
                    @endcan
                    <a class="btn btn-danger" href="{{route('salaries.trashed')}}">
                        <i class="fe fe-trash"></i>
                    </a> --}}
                    @can('create-all', 'App\\Models\Salary')
                    @if ($btn_download_salary == "active")
                        <form action="{{route('salaries.createAllSalaries')}}" method="post" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="fe fe-activity"></i>
                                <span>تحميل جميع الرواتب لشهر {{$month}}</span>
                            </button>
                        </form>
                    @endif
                    @endcan
                    @can('delete-all', 'App\\Models\Salary')
                    @if ($btn_delete_salary == "active")
                    <form action="{{route('salaries.deleteAllSalaries')}}" method="post" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fe fe-activity"></i>
                            <span>حذف جميع الرواتب</span>
                        </button>
                    </form>
                    @endif
                    @endcan


                </div>

            </div>
            <div class="form-group p-3 col-3">
                <x-form.input type="month" label="حدد شهر معين" :value="$month"  name="month" placeholder="" required/>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered  table-hover datatables text-dark"  id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>الشهر</th>
                                        <th>الراتب الأولي</th>
                                        <th> علاوة درجة</th>
                                        <th>الراتب الاساسي</th>
                                        <th>اجمالي الراتب</th>
                                        <th>مستحقات متأخرة</th>
                                        <th>اجمالي الخصومات</th>
                                        <th>صافي الراتب</th>
                                        <th>البنك</th>
                                        <th>رقم الحساب</th>
                                        <th>مبلغ السنوي الخاضع للضريبة</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody id="table_salaries">
                                    @foreach($salaries as $salary)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$salary->employee->name}}</td>
                                        <td>{{$salary->month}}</td>
                                        <td>{{$salary->initial_salary}}</td>
                                        <td>{{$salary->grade_Allowance}}</td>
                                        <td>{{$salary->secondary_salary}}</td>
                                        <td>{{$salary->gross_salary}}</td>
                                        <td>{{$salary->late_receivables}}</td>
                                        <td>{{$salary->total_discounts}}</td>
                                        <td>{{$salary->net_salary}}</td>
                                        <td>{{$salary->bank}}</td>
                                        <td>{{$salary->account_number}}</td>
                                        <td>{{number_format($salary->annual_taxable_amount,2)}}</td>
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" target="_blank" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('salaries.show',$salary->id)}}">عرض</a>
                                                {{-- <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('salaries.edit',$salary->id)}}">تعديل</a> --}}
                                                @can('delete', 'App\\Models\Salary')
                                                <form action="{{route('salaries.destroy',$salary->id)}}" method="post">
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
    <!-- Modal -->'
    @if (session()->has('danger'))
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLongTitle">أخطاء حدتث في معالجة الراتب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(is_array(session('danger')))
                <ul class="list-group">
                    @foreach(session('danger') as $error)
                        <li class="list-group-item">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    @endif
    @push('scripts')

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
        <script>
            $(document).ready(function() {
                const csrf_token = "{{ csrf_token() }}";
                const app_link = "{{config('app.url')}}";
                $('#month').on('input', function() {
                    $.ajax({
                        url: app_link + "/salaries/getSalariesMonth",
                        method: "post",
                        data: {
                            _token: csrf_token,
                            month: $(this).val(),
                        },
                        success: function (response) {
                            console.log(response.length);
                            $("#table_salaries").empty();
                            response.forEach((salary) => {
                                $("#table_salaries").append(
                                    `<tr>
                                        <td>${response.indexOf(salary) + 1}</td>
                                        <td>`+ salary['employee']['name'] +`</td>
                                        <td>`+ salary['month'] +`</td>
                                        <td>`+ salary['initial_salary'] +`</td>
                                        <td>`+ salary['grade_Allowance'] +`</td>
                                        <td>`+ salary['secondary_salary'] +`</td>
                                        <td>`+ salary['gross_salary'] +`</td>
                                        <td>`+ salary['late_receivables'] +`</td>
                                        <td>`+ salary['total_discounts'] +`</td>
                                        <td>`+ salary['net_salary'] +`</td>
                                        <td>`+ salary['bank'] +`</td>
                                        <td>`+ salary['account_number'] +`</td>
                                        <td>`+ salary['annual_taxable_amount'] +`</td>
                                        <td>
                                            <button class="btn btn-sm dropdown-toggle more-horizontal"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"
                                                    style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="/salaries/`+ salary['id'] +`/">عرض</a>
                                                <form action="/salaries/`+ salary['id'] +`"
                                                    method="post">
                                                    <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                                                    <input type="hidden" name="_method" value="delete">
                                                    <button type="submit" class="dropdown-item"
                                                        style="margin: 0.5rem -0.75rem; text-align: right;"
                                                        href="#">حذف</button>
                                                </form>
                                            </div>
                                        </td>
                                </tr>`
                                );
                            });
                            if(response.length == 0){
                                $("#table_salaries").append(
                                    '<tr><td colspan="14" class="text-center text-danger">لا يوجد بيانات لعرضها</td></tr>'
                                );
                            }
                        },
                        error: function (response) {
                            console.error(response);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-front-layout>
