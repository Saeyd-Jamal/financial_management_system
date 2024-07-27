<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @php
        $fields = [
            'administrative_allowance' => 'العلاوة الإدارية',
            'scientific_qualification_allowance' => 'العلاوة المؤهل العلمي',
            'transport' => 'المواصلات',
            'extra_allowance' => 'بدل إضافي',
            'salary_allowance' => 'علاوة أغراض راتب',
            'ex_addition' => 'اضافة بأثر رجعي',
            'mobile_allowance' => 'علاوة جوال',
            'health_insurance' => 'تامين صحي',
            'f_Oredo' => 'ف. اوريدو',
            'tuition_fees' => 'رسوم دراسية',
            'voluntary_contributions' => 'تبرعات',
            'paradise_discount' => 'خصم اللجنة',
            'other_discounts' => 'خصومات أخرى',
            'proportion_voluntary' => ' التبرعات للحركة',
            'savings_rate' => 'ادخار5%',
        ];
        $fieldsLoan=[
            'association_loan' => 'قرض الجمعية',
            'savings_loan' => 'قرض ادخار بالدولار',
            'shekel_loan' => 'قرض اللجنة (الشيكل)',
        ]
    @endphp
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/funFixedView.js') }}"></script>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">واجهة التعديلات</h2>
                    <p class="card-text">هنا يتم عرض البيانات المدخلة الشهرية لكل موظف والتي تستخدم في الرواتب</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-info mb-2" href="{{ route('fixed_entries.index') }}">
                        <i class="fe fe-home"></i> عرض التعديلات
                    </a>
                    <div class="form-group col-6 d-inline">
                        <input type="month" id="monthInputSearch" name="month" value="{{$monthNow}}" class="form-control">
                    </div>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#openModal">
                        btn to show modal
                    </button>
                    <button style="display: none;" id="openModalLoanShow" data-toggle="modal" data-target="#openModalLoan">
                        btn to show modal loan
                    </button>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered  table-hover" style="display: block; overflow-x: auto;" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 150px">الاسم</th>
                                        <th>علاوة إدارية</th>
                                        <th>علاوة مؤهل علمي</th>
                                        <th>مواصلات</th>
                                        <th>بدل إضافي</th>
                                        <th>علاوة اغراض راتب</th>
                                        <th>إضافة بأثر رجعي</th>
                                        <th>علاوة جوال</th>
                                        <th>تأمين صحي</th>
                                        <th>ف.أوريدو</th>
                                        <th>رسوم دراسية</th>
                                        <th>تبرعات</th>
                                        <th>خصم اللجنة</th>
                                        <th>خصومات الإخرى</th>
                                        <th>تبرعات للحركة</th>
                                        <th>إدخار 5%</th>
                                        <th>قرض جمعية </th>
                                        <th>قرض الإدخار</th>
                                        <th>قرض اللجنة</th>
                                    </tr>
                                </thead>
                                <tbody id="fixed_entries_table">
                                    @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$employee->name}}</td>
                                        @foreach ($fields as $name => $label)
                                            <td>
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary openModal" id="{{ $name }}" title="{{ $label }} ل{{$employee->name}}" type="button" data-type="{{$name}}" data-label="{{$label}}" data-employeeid="{{$employee->id}}">
                                                        <i class="fe fe-maximize"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endforeach
                                        @foreach ($fieldsLoan as $name => $label)
                                            <td>
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary openModalLoan" id="{{ $name }}" title="{{ $label }} ل{{$employee->name}}" type="button" data-type="{{$name}}" data-label="{{$label}}" data-employeeid="{{$employee->id}}">
                                                        <i class="fe fe-maximize"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{ $employees->links() }}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    {{-- Model for fixed entries --}}
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="openModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="openModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sendModalForm" action="{{ route('fixed_entries.store') }}" method="post">
                        @csrf
                        <div class="modalBody">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Model for loan --}}
    <div class="modal fade" id="openModalLoan" tabindex="-1" role="dialog" aria-labelledby="openModalLoanLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="openModalLoanLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fixed_entries.store') }}" method="post" id="sendModalLoanForm">
                        @csrf
                        <div class="modalBodyLoan">

                        </div>
                    </form>
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
        <script src="{{ asset('js/getModalForm.js') }}"></script>
    @endpush
</x-front-layout>