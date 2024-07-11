<h2 class="h3">البيانات الشخصية</h2>
<div class="row">
    <div class="form-group p-3 col-3">
        <x-form.input label="إسم الموظف" :value="$employee->name"  name="name" placeholder="أحمد محمد ...." required/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input label="رقم الهوية" minlength="9" maxlength="9" :value="$employee->employee_id"  name="employee_id" placeholder="400000000" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ الميلاد" :value="$employee->date_of_birth"  name="date_of_birth" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="العمر" :value="$employee->age"  name="age" readonly  />
    </div>
    <div class="form-group p-3 col-3">
        <label for="gender">الجنس</label>
        <select class="custom-select" id="gender" name="gender"  >
            <option value="ذكر">ذكر</option>
            <option value="أنثى">أنثى</option>
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="matrimonial_status">الحالة الزوجية</label>
        <select class="custom-select" id="matrimonial_status" name="matrimonial_status" required>
            <option @selected($employee->matrimonial_status == null)>عرض القيم المتوفرة</option>
            @foreach ($matrimonial_status as $matrimonial_statusV)
                <option value="{{$matrimonial_statusV['value']}}" @selected($employee->matrimonial_status == $matrimonial_statusV)>{{$matrimonial_statusV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="عدد الزوجات" :value="$employee->number_wives"  name="number_wives" placeholder="0" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="عدد الأولاد" :value="$employee->number_children"  name="number_children" placeholder="0" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="عدد الأولاد في الجامعة" :value="$employee->number_university_children"  name="number_university_children" placeholder="0" required />
    </div>
    <div class="form-group p-3 col-3">
        <label for="scientific_qualification">المؤهل العلمي</label>
        <select class="custom-select" id="scientific_qualification" name="scientific_qualification" required>
            <option @selected($employee->scientific_qualification == null)>عرض القيم المتوفرة</option>
            @foreach ($scientific_qualification as $scientific_qualificationV)
                <option value="{{$scientific_qualificationV['value']}}" @selected($employee->scientific_qualification == $scientific_qualificationV)>{{$scientific_qualificationV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="التخصص" :value="$employee->specialization"  name="specialization" placeholder="محاسبة...." required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="الجامعة" :value="$employee->university"  name="university" placeholder="الأزهر...." required />
    </div>
    <div class="form-group p-3 col-3">
        <label for="area">المنطقة</label>
        <select class="custom-select" id="area" name="area" required>
            <option @selected($employee->area == null)>عرض القيم المتوفرة</option>
            @foreach ($areas as $area)
                <option value="{{$area['value']}}" @selected($employee->area == $area)>{{$area['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="العنوان بالتفصيل" :value="$employee->address"  name="address" placeholder="دير البلح - شارع يافا - حي البشارة - مستشفى يافا" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="email" label="الإيميل" :value="$employee->email"  name="email" placeholder="email@example.com" />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="رقم الهاتف" :value="$employee->phone_number"  name="phone_number" placeholder="(734) 767-4418" required />
    </div>

</div>

<h2 class="h3">بيانات العمل</h2>
<div class="row">
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="درجة العلاوة من السلم" min="0" max="40" :value="$workData->allowance" name="allowance" placeholder="0" />
    </div>
    <div class="form-group p-3 col-3">
        <label for="grade">الدرجة في سلم الرواتب</label>
        <select class="custom-select" id="grade" name="grade" required>
            <option value="null">عرض القيم المتوفرة</option>
            <option value="10" @selected($workData->grade == 10)>10</option>
            <option value="9" @selected($workData->grade == 9)>9</option>
            <option value="8" @selected($workData->grade == 8)>8</option>
            <option value="7" @selected($workData->grade == 7)>7</option>
            <option value="6" @selected($workData->grade == 6)>6</option>
            <option value="5" @selected($workData->grade == 5)>5</option>
            <option value="4" @selected($workData->grade == 4)>4</option>
            <option value="3" @selected($workData->grade == 3)>3</option>
            <option value="2" @selected($workData->grade == 2)>2</option>
            <option value="1" @selected($workData->grade == 1)>1</option>
            <option value="C" @selected($workData->grade == "C")>C</option>
            <option value="B" @selected($workData->grade == "B")>B</option>
            <option value="A" @selected($workData->grade == "A")>A</option>
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="نسبة علاوة درجة" :value="$workData->grade_allowance_ratio" name="grade_allowance_ratio" placeholder="10%.." />
    </div>
    <div class="form-group p-3 col-3">
        <label for="salary_category">فئة الراتب</label>
        <select class="custom-select" id="salary_category" name="salary_category" required>
            <option >عرض القيم المتوفرة</option>
            <option value="1"  @selected($workData->salary_category == 1)>الأولى</option>
            <option value="2"  @selected($workData->salary_category == 2)>الثانية</option>
            <option value="3"  @selected($workData->salary_category == 3)>الثالثة</option>
            <option value="4"  @selected($workData->salary_category == 4)>الرابعة</option>
            <option value="5"  @selected($workData->salary_category == 5)>الخامسة</option>
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ العمل" :value="$workData->working_date"  name="working_date" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ التثبيت" :value="$workData->date_installation"  name="date_installation" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="سنوات الخدمة" :value="$workData->years_service" name="years_service" placeholder="0" readonly  />
    </div>

    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ التقاعد" :value="$workData->date_retirement" name="date_retirement" readonly />
    </div>
    <div class="form-group p-3 col-3">
        <label for="working_status">حالةا لدوام</label>
        <select class="custom-select" id="working_status" name="working_status" required>
            <option @selected($workData->working_status == null)>عرض القيم المتوفرة</option>
            @foreach ($working_status as $working_status)
                <option value="{{$working_status['value']}}" @selected($workData->working_status == $working_status['value'])>{{$working_status['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="type_appointment">نوع التعين</label>
        <select class="custom-select" id="type_appointment" name="type_appointment" required>
            <option @selected($workData->type_appointment == null)>عرض القيم المتوفرة</option>
            @foreach ($type_appointment as $type_appointment)
                <option value="{{$type_appointment['value']}}" @selected($workData->type_appointment == $type_appointment['value'])>{{$type_appointment['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="field_action">مجال العمل</label>
        <select class="custom-select" id="field_action" name="field_action" required>
            <option @selected($workData->field_action == null)>عرض القيم المتوفرة</option>
            @foreach ($field_action as $field_action)
                <option value="{{$field_action['value']}}" @selected($workData->field_action == $field_action['value'])>{{$field_action['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="government_official">موظف حكومة</label>
        <select class="custom-select" id="government_official" name="government_official" required>
            <option value="غير موظف" @selected($workData->government_official == null || $workData->government_official == "غير موظف")>غير موظف</option>
            @foreach ($government_official as $government_official)
                <option value="{{$government_official['value']}}" @selected($workData->government_official == $government_official['value'])>{{$government_official['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="dual_function">مزدوج الوظيفة</label>
        <select class="custom-select" id="dual_function" name="dual_function" >
            <option value="لا" @selected($workData->dual_function == "لا" || $workData->dual_function == null)>لا</option>
            <option value="نعم" @selected($workData->dual_function == "نعم")>نعم</option>
        </select>
    </div>

    <div class="form-group p-3 col-3">
        <label for="state_effectiveness">حالة الفعالية</label>
        <select class="custom-select" id="state_effectiveness" name="state_effectiveness" required>
            <option @selected($workData->state_effectiveness == null)>عرض القيم المتوفرة</option>
            @foreach ($state_effectiveness as $state_effectiveness)
                <option value="{{$state_effectiveness['value']}}" @selected($workData->state_effectiveness == $state_effectiveness['value'])>{{$state_effectiveness['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="nature_work">طبيعةالعمل</label>
        <select class="custom-select" id="nature_work" name="nature_work" required>
            <option @selected($workData->nature_work == null)>عرض القيم المتوفرة</option>
            @foreach ($nature_work as $nature_work)
                <option value="{{$nature_work['value']}}" @selected($workData->nature_work == $nature_work['value'])>{{$nature_work['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="association">الجمعية</label>
        <select class="custom-select" id="association" name="association" required>
            <option @selected($workData->association == null)>عرض القيم المتوفرة</option>
            @foreach ($association as $association)
                <option value="{{$association['value']}}" @selected($workData->association == $association['value'])>{{$association['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="workplace">مكان العمل</label>
        <select class="custom-select" id="workplace" name="workplace" required>
            <option @selected($workData->workplace == null)>عرض القيم المتوفرة</option>
            @foreach ($workplace as $workplaceV)
                <option value="{{$workplaceV['value']}}" @selected($workData->workplace == $workplaceV['value'])>{{$workplaceV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="section">القسم</label>
        <select class="custom-select" id="section" name="section" required>
            <option @selected($workData->section == null)>عرض القيم المتوفرة</option>
            @foreach ($section as $sectionV)
                <option value="{{$sectionV['value']}}" @selected($workData->section == $sectionV['value'])>{{$sectionV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="dependence">التبعية</label>
        <select class="custom-select" id="dependence" name="dependence" required>
            <option @selected($workData->dependence == null)>عرض القيم المتوفرة</option>
            @foreach ($dependence as $dependenceV)
                <option value="{{$dependenceV['value']}}" @selected($workData->dependence == $dependenceV['value'])>{{$dependenceV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="branch">الفرع</label>
        <select class="custom-select" id="branch" name="branch" required>
            <option @selected($workData->branch == null)>عرض القيم المتوفرة</option>
            @foreach ($branch as $branchV)
                <option value="{{$branchV['value']}}" @selected($workData->branch == $branchV['value'])>{{$branchV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <label for="establishment">المنشأة</label>
        <select class="custom-select" id="establishment" name="establishment" required>
            <option @selected($workData->establishment == null)>عرض القيم المتوفرة</option>
            @foreach ($establishment as $establishmentV)
                <option value="{{$establishmentV['value']}}" @selected($workData->establishment == $establishmentV['value'])>{{$establishmentV['value']}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input label="بيان الراتب" :value="$workData->payroll_statement" name="payroll_statement" placeholder="0" />
    </div>
    <div class="form-group p-3 col-3">
        <label for="foundation_E">المؤسسة E</label>
        <select class="custom-select" id="foundation_E" name="foundation_E" required>
            <option @selected($workData->foundation_E == null)>عرض القيم المتوفرة</option>
            @foreach ($foundation_E as $foundation_EV)
                <option value="{{$foundation_EV['value']}}" @selected($workData->foundation_E == $foundation_EV['value'])>{{$foundation_EV['value']}}</option>
            @endforeach
        </select>
    </div>

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
            let date_of_birth = $("input[name='date_of_birth']").val();
            let thisYear = new Date().getFullYear();
            let year_of_birth = moment(date_of_birth).format('YYYY');
            $("input[name='age']").val(thisYear - year_of_birth);
            let futureDate = moment(date_of_birth, "YYYY-MM-DD").add(60, "years").format("YYYY-MM-DD");
            $("input[name='date_retirement']").val(futureDate);
        });
        $("input[name='date_installation']").on("input", function () {
            let thisYear = new Date().getFullYear();
            let date_installation = moment($("input[name='date_installation']").val()).format('YYYY');
            $("input[name='years_service']").val(thisYear - date_installation)
        });
    </script>
@endpush
