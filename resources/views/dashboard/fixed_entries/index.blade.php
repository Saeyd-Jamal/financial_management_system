<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الإدخالات الثابتة</h2>
                    <p class="card-text">هنا يتم عرض البيانات المدخلة الشهرية لكل موظف والتي تستخدم في الرواتب</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-success" href="{{ route('fixed_entries.create') }}">
                        <i class="fe fe-plus"></i>
                    </a>
                    <div class="form-group col-6 d-inline">
                        <input type="month" id="monthInputSearch" name="month" value="{{$monthNow}}" class="form-control">
                    </div>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#getShowFixed">
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
                            <table class="table table-hover" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>علاوة إدارية</th>
                                        <th>علاوة مؤهل علمي</th>
                                        <th>مواصلات</th>
                                        <th>بدل إضافي</th>
                                        <th>علاوة اغراض راتب</th>
                                        <th>إضافة بأثر رجعي</th>
                                        <th>علاوة جوال</th>
                                        <th>تأمين صحي</th>
                                        <th>ف.أوريدو</th>
                                        <th>قرض جمعية </th>
                                        <th>رسوم دراسية</th>
                                        <th>تبرعات</th>
                                        <th>فئة الراتب</th>
                                    </tr>
                                </thead>
                                <tbody id="fixed_entries_table">
                                    @foreach ($fixed_entries as $fixed_entrie)
                                    <tr class="fixed_select" data-id="{{$fixed_entrie->id}}">
                                        <td>{{$fixed_entrie->employee->id}}</td>
                                        <td>{{$fixed_entrie->employee->name}}</td>
                                        <td>{{$fixed_entrie->administrative_allowance}}</td>
                                        <td>{{$fixed_entrie->scientific_qualification_allowance}}</td>
                                        <td>{{$fixed_entrie->transport}}</td>
                                        <td>{{$fixed_entrie->extra_allowance}}</td>
                                        <td>{{$fixed_entrie->salary_allowance}}</td>
                                        <td>{{$fixed_entrie->ex_addition}}</td>
                                        <td>{{$fixed_entrie->mobile_allowance}}</td>
                                        <td>{{$fixed_entrie->health_insurance}}</td>
                                        <td>{{$fixed_entrie->f_Oredo}}</td>
                                        <td>{{$fixed_entrie->association_loan}}</td>
                                        <td>{{$fixed_entrie->tuition_fees}}</td>
                                        <td>{{$fixed_entrie->voluntary_contributions}}</td>
                                        <td>{{$fixed_entrie->employee->salary_category}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{ $fixed_entries->links() }}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    <div class="modal fade" id="getShowFixed" tabindex="-1" role="dialog" aria-labelledby="getShowFixedTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getShowFixedLongTitle"> عرض الإدخالات الثابتة </h5>
                <div class="form-group col-4">
                    <input type="month" id="monthModalSearch" name="month" value="{{$monthNow}}" class="form-control">
                </div>
            </div>
            <div class="modal-body" id="showFixed">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/ajax.min.js') }}"></script>
        <script>
            const csrf_token = "{{ csrf_token() }}";
            const app_link = "{{ config('app.url') }}";
        </script>
        <script src="{{ asset('js/getShowFixed.js') }}"></script>
    @endpush
</x-front-layout>
