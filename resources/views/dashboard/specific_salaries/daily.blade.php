<x-front-layout>
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    @endpush
    <div class="row align-items-center mb-2">
        <!-- Bordered table -->
        <div class="col-md-12 my-4">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول رواتب الموظفين اليومين</h2>
                    <p class="card-text">يمكنك تعديل الرواتب الموظفين اليومين من هنا</p>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <style>
                        td{
                            box-sizing: border-box !important;
                        }
                    </style>
                    <table class="datatables table table-bordered table-hover mb-0 " style="box-sizing: border-box" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الموظف</th>
                                <th>عدد الأيام</th>
                                <th>تكلفة اليوم</th>
                                <th>الراتب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{route('specific_salaries.dailyCreate')}}" method="post">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group col-md-3">
                                            <x-form.input type="month" :value="$month" name="month" label="شهر الراتب المطلوب" />
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        {{-- @can('preparation', 'App\\Models\User') --}}
                                        <button class="btn btn-info mb-2" type="submit">
                                            <i class="fe fe-download"></i>
                                            <span>حفظ الرواتب</span>
                                        </button>
                                        {{-- @endcan --}}
                                    </div>
                                </div>
                                @csrf
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$employee->name}}</td>
                                    <td>
                                        <x-form.input type="number" class="d-inline daily_fields" data-id="{{$employee->id}}" name="number_of_days[{{$employee->id}}]"  data-name="number_of_days" value="{{$employee->specificSalaries()->where('month', $month)->first()->number_of_days ?? 0}}" min="0" placeholder="0."/>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <x-form.input type="number"  class="d-inline daily_fields" data-id="{{$employee->id}}" name="today_price[{{$employee->id}}]" data-name="today_price" value="{{$employee->specificSalaries()->where('month', $month)->first()->today_price ?? 0}}" min="0" placeholder="0."/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">₪</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="{{$employee->id}}" name="salaries[{{$employee->id}}]" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" class="form-control d-inline daily_fields" data-name="salaries" data-id="{{$employee->id}}" min="0" placeholder="0." readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">₪</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('js/dailyEmployee.js') }}"></script>
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
