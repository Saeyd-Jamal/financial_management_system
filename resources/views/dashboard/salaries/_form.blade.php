<div class="row">
    <div class="form-group p-3 col-3">
        <label for="gender">رقم الموظف</label>
        <div class="input-group mb-3">
            <x-form.input :value="$salary->employee->id" name="employee_id" placeholder="0" readonly  />
            <div class="input-group-append">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee">
                    <i class="fe fe-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input label="" :value="$salary->name"  name="name" placeholder="" required/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ الميلاد" :value="$salary->date_of_birth"  name="date_of_birth" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="العمر" :value="$salary->age"  name="age" readonly  />
    </div>
    {{-- <div class="form-group p-3 col-3">
        <label for="matrimonial_status">الحالة الزوجية</label>
        <select class="custom-select" id="matrimonial_status" name="matrimonial_status" required>
            <option @selected($salary->matrimonial_status == null)>عرض القيم المتوفرة</option>
            @foreach ($matrimonial_status as $matrimonial_statusV)
                <option value="{{$matrimonial_statusV['value']}}" @selected($salary->matrimonial_status == $matrimonial_statusV)>{{$matrimonial_statusV['value']}}</option>
            @endforeach
        </select>
    </div> --}}
</div>

<div class="row align-items-center mb-2">
    <div class="col">
        <h2 class="h5 page-title"></h2>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            {{$btn_label ?? "أضف"}}
        </button>
    </div>
</div>
@push('scripts')
    <script>
        $("input[name='date_of_birth']").on("input", function () {
            let thisYear = new Date().getFullYear();
            let date_of_birth = moment($("input[name='date_of_birth']").val()).format('YYYY');
            $("input[name='age']").val(thisYear - date_of_birth)
        });
    </script>
@endpush
