<x-front-layout>
    <div class="row align-items-center mb-2">
        <!-- Bordered table -->
        <div class="col-md-12 my-4">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول رواتب الموظفين الخاص</h2>
                    <p class="card-text">يمكنك تعديل الرواتب الموظفين الخاص من هنا</p>
                </div>

            </div>
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الموظف</th>
                                <th>الراتب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{route('specific_salaries.ratioCreate')}}" method="post">
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
                                        <div class="input-group">
                                            <x-form.input type="number" name="salaries[{{$employee->id}}]" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" min="0" class="d-inline" placeholder="0."/>
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
</x-front-layout>
