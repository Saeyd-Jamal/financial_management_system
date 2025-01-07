<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#menu1" id="tab1" disabled>
                مبلغ السلفة
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2" id="tab2">
                حالة الفعالية
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu3" id="tab3">
                نسبة نهاية الخدمة
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu4" id="tab4">
                رواتب الصحة المثبتين
            </a>
        </li>

    </ul>

    <!-- Tab panes -->
<form action="{{ route('constants.store') }}" method="post">
    @csrf
<div class="tab-content">
    <div class="tab-pane active" id="menu1">
        <h2 class="h3 mt-4">تحديد ملبغ السلفة حسب حالة الدوام للثبتين</h2>
        <div class="row">
            <div class="form-group my-2 col-md-6 d-flex align-items-end">
                <label for="advance_payment_rate">مبلغ السلفة - نسبة</label>
                <div class="col-8 input-group">
                    <x-form.input required type="number" value="{{$constants->where('type_constant', 'advance_payment_rate')->first() ? $constants->where('type_constant', 'advance_payment_rate')->first()->value : 0 }}" min="0" name="advance_payment_rate" placeholder="1000" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
            <div class="form-group my-2  col-md-6 d-flex  align-items-end">
                <label for="advance_payment_riyadh">مبلغ السلفة - رياض</label>
                <div class="col-8 input-group">
                    <x-form.input required type="number" min="0" :value="$constants->where('type_constant', 'advance_payment_riyadh')->first() ? $constants->where('type_constant', 'advance_payment_riyadh')->first()->value : 0"  name="advance_payment_riyadh" placeholder="1000" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
            <div class="form-group my-2  col-md-6 d-flex align-items-end">
                <label for="advance_payment_permanent">مبلغ السلفة - مداوم</label>
                <div class="col-8 input-group">
                    <x-form.input required type="number" min="0" :value="$constants->where('type_constant', 'advance_payment_permanent')->first() ? $constants->where('type_constant', 'advance_payment_permanent')->first()->value : 0"  name="advance_payment_permanent" placeholder="1000" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
            <div class="form-group my-2  col-md-6 d-flex  align-items-end">
                <label for="advance_payment_non_permanent">مبلغ السلفة - غير مداوم</label>
                <div class="col-8 input-group">
                    <x-form.input required type="number" min="0" :value="$constants->where('type_constant', 'advance_payment_non_permanent')->first() ? $constants->where('type_constant', 'advance_payment_non_permanent')->first()->value : 0"  name="advance_payment_non_permanent" placeholder="1000" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end align-items-center mb-2">
            <button type="submit" class="btn btn-primary mx-2">
                تعديل
            </button>
        </div>
    </div>

    <div class="tab-pane fade" id="menu2">
        <div class="row">

        </div>
        <div class="row justify-content-end align-items-center mb-2">
            <button type="submit" class="btn btn-primary mx-2">
                تعديل
            </button>
        </div>
    </div>

    <div class="tab-pane fade" id="menu3">
        <h2 class="h3 mt-4">تحديد نسبة الخدمة</h2>
        <div class="row">
            <div class="form-group my-2 col-6 d-flex align-items-end">
                <label for="termination_service">نسبة نهاية الخدمة للمؤسسة (الإدخار للمؤسسة)</label>
                <div class="col-4 input-group">
                    <x-form.input required type="number" :value="$constants->where('type_constant', 'termination_service')->first() ? $constants->where('type_constant', 'termination_service')->first()->value : 0" min="0" name="termination_service" placeholder="10" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group my-2 col-6 d-flex align-items-end">
                <label for="termination_service">نسبة إدخار للموظف</label>
                <div class="col-4 input-group">
                    <x-form.input required type="number" :value="$constants->where('type_constant', 'termination_employee')->first() ? $constants->where('type_constant', 'termination_employee')->first()->value : 0" min="0" name="termination_employee" placeholder="5" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end align-items-center mb-2">
            <button type="submit" class="btn btn-primary mx-2">
                تعديل
            </button>
        </div>
    </div>
    <div class="tab-pane fade" id="menu4">
        <h2 class="h3 mt-4">تحديد رواتب الصحة المثبتين</h2>
        <div class="row">
            <div class="form-group my-2 col-6 d-flex align-items-end">
                <label for="health_bachelor">البكالوريوس</label>
                <div class="input-group">
                    <x-form.input required type="number" :value="$constants->where('type_constant', 'health_bachelor')->first() ? $constants->where('type_constant', 'health_bachelor')->first()->value : 0" min="0" name="health_bachelor" placeholder="" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
            <div class="form-group my-2 col-6 d-flex align-items-end">
                <label for="health_diploma">الدبلوم</label>
                <div class="input-group">
                    <x-form.input required type="number" :value="$constants->where('type_constant', 'health_diploma')->first() ? $constants->where('type_constant', 'health_diploma')->first()->value : 0" min="0" name="health_diploma" placeholder="" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
            <div class="form-group my-2 col-6 d-flex align-items-end">
                <label for="health_secondary">ثانوية عامة</label>
                <div class="input-group">
                    <x-form.input required type="number" :value="$constants->where('type_constant', 'health_secondary')->first() ? $constants->where('type_constant', 'health_secondary')->first()->value : 0" min="0" name="health_secondary" placeholder="" class="d-inline" />
                    <div class="input-group-append">
                        <span class="input-group-text">₪</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end align-items-center mb-2">
            <button type="submit" class="btn btn-primary mx-2">
                تعديل
            </button>
        </div>
    </div>
</div>
</form>

</x-front-layout>
