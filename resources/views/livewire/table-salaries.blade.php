<div class="container-fluid">
    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/funFixedView.css') }}">
    @endpush
    <div class="row">
        <form method="post" id="filter" class="col-12">
            @csrf
            <div class="row">
                <div class="form-group col-3">
                    <x-form.input type="month" label="حدد شهر معين" :value="$month" name="month" wire:model="filterArray.month" wire:input="filter"/>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="name" label="اسم الموظف" placeholder="إملأ الاسم" wire:model="filterArray.name" wire:input="filter" />
                </div>
            </div>
        </form>
    </div>
    <div class="row my-4">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body"  id="table_box">
                    <!-- table -->
                    <table class="table table-bordered  table-hover datatables text-dark"  id="dataTable-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th   class="sticky">الاسم</th>
                                <th>مكان العمل</th>
                                <th>الراتب الاساسي</th>
                                <th>علاوة الأولاد</th>
                                <th>علاوة طبيعة العمل</th>
                                <th>علاوة إدارية</th>
                                <th>علاوة مؤهل علمي</th>
                                <th>المواصلات</th>
                                <th>بدل إضافي +-</th>
                                <th>علاوة أغراض راتب</th>
                                <th>إضافة بأثر رجعي</th>
                                <th>علاوة جوال</th>
                                <th>نهاية الخدمة</th>
                                <th>إجمالي الراتب</th>
                                <th>تأمين صحي</th>
                                <th>ض.دخل</th>
                                <th>إدخار 5%</th>
                                <th>قرض الجمعية</th>
                                <th>قرض الإدخار</th>
                                <th>قرض شيكل</th>
                                <th>مستحقات متأخرة</th>
                                <th>إجمالي الخصومات</th>
                                <th>صافي الراتب</th>
                                <th></th>
                            </tr>
                        </thead>
                            @foreach($salaries as $salary)
                                @php
                                    $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="white-space: nowrap;"   class="sticky">{{$salary->employee->name ?? ''}}</td>
                                    <td>{{$salary->employee->workData->workplace ?? ''}}</td>
                                    <td>{{$salary->secondary_salary ?? ''}}</td>
                                    <td>{{$salary->allowance_boys ?? ''}}</td>
                                    <td>{{$salary->nature_work_increase ?? ''}}</td>
                                    <td>{{$fixedEntries->administrative_allowance ?? ''}}</td>
                                    <td>{{$fixedEntries->scientific_qualification_allowance ?? ''}}</td>
                                    <td>{{$fixedEntries->transport ?? ''}}</td>
                                    <td>{{$fixedEntries->extra_allowance ?? ''}}</td>
                                    <td>{{$fixedEntries->salary_allowance ?? ''}}</td>
                                    <td>{{$fixedEntries->ex_addition ?? ''}}</td>
                                    <td>{{$fixedEntries->mobile_allowance ?? ''}}</td>
                                    <td>{{$salary->termination_service ?? ''}}</td>
                                    <td>{{$salary->gross_salary }}</td>
                                    <td>{{$fixedEntries->health_insurance ?? ''}}</td>
                                    <td>{{$salary->z_Income ?? ''}}</td>
                                    <td>{{$fixedEntries->savings_rate ?? ''}}</td>
                                    <td>{{$fixedEntries->association_loan ?? ''}}</td>
                                    <td>{{$fixedEntries != null  ? $fixedEntries->savings_loan * $USD : ''}}</td>
                                    <td>{{$fixedEntries->shekel_loan ?? ''}}</td>
                                    <td>{{$salary->late_receivables ?? ''}}</td>
                                    <td>{{$salary->total_discounts ?? ''}}</td>
                                    <td style="color: #000; background: #dddddd; font-weight: bold;">{{$salary->net_salary ?? ''}}</td>
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
                <div class="m-3 display-5 text-center">
                    <span>
                        إجمالي عدد الموظفين الذي نزل لهم الراتب : {{$salaries->count()}}
                    </span>
                </div>
            </div>
        </div> <!-- simple table -->
    </div> <!-- end section -->
</div>