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
        'savings_loan' => 'قرض ادخار',
        'shekel_loan' => 'قرض شيكل',
        'paradise_discount' => 'خصم اللجنة',
        'other_discounts' => 'خصومات أخرى',
        'proportion_voluntary' => ' التبرعات للحركة',
        'savings_5' => 'ادخار5%',
    ];
    $controller = new \App\Http\Controllers\Dashboard\FixedEntriesController();
@endphp
<div class="row">
    <div class="form-group p-3 col-3">
        <label for="gender">رقم الموظف</label>
        <div class="input-group mb-3">
            <x-form.input :value="$fixed_entrie['employee']->id" name="employee_id" placeholder="0" readonly required />
            @if (!isset($btn_label))
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee" >
                        <i class="fe fe-search"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
    @foreach ($fields as $name => $label)
    <div class="form-group p-3 col-3">
        <label for="{{ $name }}">{{ $label }}</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" id="{{ $name }}" type="button"  data-toggle="modal" data-target="#open_{{ $name }}" >
                    <i class="fe fe-maximize"></i>
                </button>
            </div>
            <input type="text" class="form-control"  placeholder="" aria-label="" aria-describedby="basic-addon1">
        </div>
    </div>
    @endforeach
    <div class="form-group p-3 col-3">
        <label for="association_loan">قرض الجمعية</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" id="association_loan" type="button"  data-toggle="modal" data-target="#open_association_loan" >
                    <i class="fe fe-maximize"></i>
                </button>
            </div>
            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
        </div>
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

{{-- Models --}}


@foreach ($fields as $name => $label)
    <div class="modal fade" id="open_{{ $name }}" tabindex="-1" role="dialog" aria-labelledby="open_{{ $name }}Label" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="open_{{ $name }}Label">تحديد {{ $label }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('fixed_entries.store')}}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="form-group col-md-3">
                                <h3 class="ml-2">تحديد ثابت لكل شهر</h3>
                                <x-form.input name="{{ $name }}_months" type="number" placeholder="400"  />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <h3 class="ml-3">تحديد لكل شهر</h3>
                            @include('dashboard.fixed_entries._months_table')
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-status="create" id="{{ $name }}_form" class="btn btn-primary">إنشاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="modal fade" id="open_association_loan" tabindex="-1" role="dialog" aria-labelledby="open_association_loanLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="open_association_loanLabel">تحديد قرض الجمعية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('fixed_entries.store')}}" method="post">
                    @csrf
                    <div class="row mt-3 align-items-center">
                            <span>مبلغ القرض هو</span>
                            <div class="form-group col-md-3 m-0">
                                <x-form.input name="association_loan_basic" type="number" class="d-inline association_loan_fields" placeholder="4000...."  />
                            </div>
                            <span>ويصرف على كل شهر</span>
                            <div class="form-group col-md-3 m-0">
                                <x-form.input name="association_loan_months" type="number" class="d-inline association_loan_fields" placeholder="200..."  />
                            </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h3 class="ml-3">تحديد لكل شهر</h3>
                        @php
                            $name = 'association_loan';
                        @endphp
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">يناير</th>
                                    <th scope="col">فبراير</th>
                                    <th scope="col">مارس</th>
                                    <th scope="col">أبريل</th>
                                    <th scope="col">مايو</th>
                                    <th scope="col">يونيو</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-1" name="{{ $name }}_month-1" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 1) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'01',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-2" name="{{ $name }}_month-2" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 2) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'02',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-3" name="{{ $name }}_month-3" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 3) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'03',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-4" name="{{ $name }}_month-4" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 4) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'04',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-5" name="{{ $name }}_month-5" class="form-control association_loan_fields_month" placeholder="400."  @disabled($month > 5) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'05',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-6" name="{{ $name }}_month-6" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 6) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'06',$name)}}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">يوليو</th>
                                    <th scope="col">أغسطس</th>
                                    <th scope="col">سبتمبر</th>
                                    <th scope="col">أكتوبر</th>
                                    <th scope="col">نوفمبر</th>
                                    <th scope="col">ديسمبر</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-7" name="{{ $name }}_month-7" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 7) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'07',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-8" name="{{ $name }}_month-8" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 8) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'08',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-9" name="{{ $name }}_month-9" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 9) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'09',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-10" name="{{ $name }}_month-10" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 10) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'10',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-11" name="{{ $name }}_month-11" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 11) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'11',$name)}}">
                                    </td>
                                    <td>
                                        <input type="number" id="{{ $name }}_month-12" name="{{ $name }}_month-12" class="form-control association_loan_fields_month" placeholder="400." @disabled($month > 12) value="{{$controller->getFixedEntriesFialds($fixed_entrie,$year,'12',$name)}}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row mt-3 align-items-center">
                        <span>المبلغ الإجمالي القديم</span>
                        <span id="total_association_loan_old">
                            {{intval($total_association_loan_old)}}
                        </span>
                        <span>المبلغ الإجمالي المتبقي</span>
                        <div class="form-group col-md-3 m-0">
                            <x-form.input name="total_association_loan" type="number" class="d-inline" placeholder="4000...."  />
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" data-status="create" id="associationLoanSubmit" class="btn btn-primary">إنشاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
