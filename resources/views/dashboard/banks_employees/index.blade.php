<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول حسابات الموظفين</h2>
                    <p class="card-text">هنا يتم عرض بيانات حسابات الموظفين في البنوك.</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-success" href="{{route('banks_employees.create')}}">
                        <i class="fe fe-plus"></i>
                    </a>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>البنك - الفرع</th>
                                        <th>رقم الحساب</th>
                                        <th>؟الأساسي</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banks_employees as $bank_employee)
                                    <tr>
                                        <td>{{$bank_employee->id}}</td>
                                        <td>{{$bank_employee->employee->name}}</td>
                                        <td>{{$bank_employee->bank->name . " - " . $bank_employee->bank->branch}}</td>
                                        <td>{{$bank_employee->account_number}}</td>
                                        @if ($bank_employee->default == 1)
                                            <td>الأساسي</td>
                                        @else
                                            <td>---</td>
                                        @endif
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('banks_employees.edit',$bank_employee->id)}}">تعديل</a>
                                                <form action="{{route('banks_employees.destroy',$bank_employee->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="#">حذف</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{$banks_employees->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
