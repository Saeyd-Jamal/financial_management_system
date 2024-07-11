<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الموظفين</h2>
                    <p class="card-text">هنا يتم عرض بيانات الموظفين الشخصية كاملة.</p>
                </div>
                <div class="col-auto">

                    <a class="btn btn-success" href="{{route('employees.create')}}">
                        <i class="fe fe-plus"></i>
                    </a>
                    <form action="{{route('employees.view_pdf')}}" method="post" class="d-inline" target="_blank">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-download"></i>
                        </button>
                    </form>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#ModalShow">
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>رقم الهوية</th>
                                        <th>العمر</th>
                                        <th>الحالة الزوجية</th>
                                        <th>رقم الهاتف</th>
                                        <th>المنطقة</th>
                                        <th>المؤهل العلمي</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{$employee->id}}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->employee_id}}</td>
                                        <td>{{$employee->age}}</td>
                                        <td>{{$employee->matrimonial_status}}</td>
                                        <td>{{$employee->phone_number}}</td>
                                        <td>{{$employee->area}}</td>
                                        <td>{{$employee->scientific_qualification}}</td>
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button  class="dropdown-item showEmployee" data-id="{{$employee->id}}" style="margin: 0.5rem -0.75rem; text-align: right;">عرض</button>
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('employees.edit',$employee->id)}}">تعديل</a>
                                                <form action="{{route('employees.destroy',$employee->id)}}" method="post">
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
                                {{$employees->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    @push('scripts')
        <script src="{{asset('assets/js/ajax.min.js')}}"></script>
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}";
            </script>
        <script src="{{asset('js/getShowEmployee.js')}}"></script>
    @endpush
</x-front-layout>
