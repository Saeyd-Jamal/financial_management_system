<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <style>
        hr {
            position: absolute;
            top: 50px;
            right: 15px;
            width: 35%;
            height: 5px;
            border-radius: 10px;
            background: linear-gradient(to right, rgba(210, 255, 82, 1) 0%, rgba(40, 64, 18, 1) 100%);
            margin: 0;
        }

        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
    </style>
@endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">تعديل بيانات الموظف : {{$employee->name}}</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <form action="{{route('employees.update',$employee->id)}}" method="post" class="col-12  mt-3">
            @csrf
            @method('PUT')
            @include("dashboard.employees._form")

        </form>

        {{-- create model --}}
        @can('create', 'App\\Models\Exchange')
        <div class="modal fade" id="createExchange" tabindex="-2" role="dialog" aria-labelledby="createExchangeLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createExchangeLabel">إنشاء صرف جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('exchanges.store')}}" method="post" class="col-12">
                            @csrf
                            <div class="row">
                                <x-form.input type="hidden" name="employee_id" placeholder="0" value="{{$employee->id}}" readonly required />
                                <div class="form-group p-1 col-6">
                                    <label for="exchange_type">نوع الصرف</label>
                                    <select class="custom-select" name="exchange_type" id="exchange_type" required>
                                        <option selected="" value="">إختر</option>
                                        <option value="receivables_discount">خصم المستحقات ش</option>
                                        <option value="savings_discount">خصم الإدخارات $</option>
                                        <option value="receivables_savings_discount">خصم المستحقات والإدخارات</option>
                                        <option value="reward">مكافأة</option>
                                        <option value="association_loan">قرض الجمعية ش</option>
                                        <option value="savings_loan">قرض الإدخار $</option>
                                        <option value="shekel_loan">قرض اللجنة ش</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group p-3 col-4 exchanges" id="receivables" style="display: none;">
                                    <x-form.input type="number" min="0" value="0"  label="خصم المستحقات ش" name="receivables_discount" placeholder="0.." />
                                    <span class="totals" id="receivables_total">
                                        {{$totals['total_receivables'] ?? ''}}
                                    </span>
                                </div>
                                <div class="form-group p-3 col-4 exchanges" id="savings"  style="display: none;">
                                    <x-form.input type="number" min="0" value="0"  label="خصم الإدخارات $" name="savings_discount" placeholder="0.." />
                                    <span class="totals" id="savings_total">
                                        {{$totals['total_savings']  ?? ''}}
                                    </span>
                                </div>
                                <div class="form-group p-3 col-4 exchanges" id="reward"  style="display: none;">
                                    <x-form.input type="number" min="0" value="0"  label="صرف مكافأة ش" name="reward" placeholder="0.." />
                                </div>
                                <div class="form-group p-3 col-4 exchanges" id="association_loan"  style="display: none;">
                                    <x-form.input type="number" min="0" value="0"  label="صرف قرض الجمعية" name="association_loan" placeholder="0.." />
                                </div>
                                <div class="form-group p-3 col-4 exchanges" id="savings_loan"  style="display: none;">
                                    <x-form.input type="number" min="0" value="0"  label="صرف قرض الإدخار" name="savings_loan" placeholder="0.." />
                                </div>
                                <div class="form-group p-3 col-4 exchanges" id="shekel_loan"  style="display: none;">
                                    <x-form.input type="number" min="0" value="0"  label="صرف قرض اللجنة" name="shekel_loan" placeholder="0.." />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <x-form.input type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"  label="تاريخ الصرف" name="discount_date"  />
                                </div>
                                <div class="form-group p-3 col-12">
                                    <label for="notes">ملاحظات حول الصرف</label>
                                    <textarea class="form-control" id="notes" name="notes" placeholder="....." rows="3"></textarea>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

</x-front-layout>
