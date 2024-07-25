<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <x-slot:breadcrumbs>
        <div class="row align-items-center">
            <div class="col">
                <h2 class="h5 page-title">ثوابت النظام</h2>
            </div>
        </div>
    </x-slot:breadcrumbs>
    <hr class="border border-danger border-2 opacity-50">


    {{-- btns collapse --}}
    <div>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#advance_payment" aria-expanded="false"
                aria-controls="advance_payment">
            مبلغ السلفة
        </button>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>

    {{-- contents --}}
    <div class="collapse multi-collapse" id="advance_payment">
        <form action="{{ route('constants.store') }}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-6 d-flex align-items-end">
                    <label for="advance_payment_rate">مبلغ السلفة - نسبة</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" :value="$advance_payment_rate" min="0" name="advance_payment_rate" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
                <div class="form-group m-0 col-6 d-flex  align-items-end">
                    <label for="advance_payment_riyadh">مبلغ السلفة - رياض</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" min="0" :value="$advance_payment_riyadh"  name="advance_payment_riyadh" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-3">
                <div class="form-group m-0 col-6 d-flex align-items-end">
                    <label for="advance_payment_permanent">مبلغ السلفة - مداوم</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" min="0" :value="$advance_payment_permanent"  name="advance_payment_permanent" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
                <div class="form-group m-0 col-6 d-flex  align-items-end">
                    <label for="advance_payment_non_permanent">مبلغ السلفة - غير مداوم</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" min="0" :value="$advance_payment_non_permanent"  name="advance_payment_non_permanent" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row-reverse pr-3">
                <button class="btn btn-success" type="submit">
                    <i class="fe fe-check"></i>
                </button>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
</x-front-layout>
