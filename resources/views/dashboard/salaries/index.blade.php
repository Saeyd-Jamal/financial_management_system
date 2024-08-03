<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
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
                    @can('createAll', 'App\\Models\Salary')
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
                    @can('deleteAll', 'App\\Models\Salary')
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
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered  table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>الشهر</th>
                                        <th>الراتب الأولي</th>
                                        <th> علاوة درجة</th>
                                        <th>الراتب الاساسي</th>
                                        <th>اجمالي الإضافات</th>
                                        <th>اجمالي الراتب</th>
                                        <th>اجمالي الخصومات</th>
                                        <th>صافي الراتب</th>
                                        <th>البنك</th>
                                        <th>رقم الحساب</th>
                                        <th>مبلغ السنوي الخاضع للضريبة</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                            <div>
                                {{$salaries->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
