<x-front-layout>
    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="h5 page-title">إنتاج التقارير</h2>
        </div>
    </div>
    <div class="row justify-content-between">
        <form action="{{route('report.export')}}" method="post" class="col-12" target="_blank">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <x-form.input  name="area" placeholder="أدخل المنطقة" label="المنظقة"
                        list="areas_list" />
                    <datalist id="areas_list">
                        @foreach ($areas as $area)
                            <option value="{{ $area }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="matrimonial_status"
                        placeholder="أدخل الحالة الزوجية" label="الحالة الزوجية" list="matrimonial_status_list" />
                    <datalist id="matrimonial_status_list">
                        @foreach ($matrimonial_status as $matrimonial_status)
                            <option value="{{ $matrimonial_status }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="scientific_qualification"
                        placeholder="أدخل المؤهل العلمي" label="المؤهل العلمي"
                        list="scientific_qualification_list" />
                    <datalist id="scientific_qualification_list">
                        @foreach ($scientific_qualification as $scientific_qualification)
                            <option value="{{ $scientific_qualification }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="gender" placeholder="أدخل الجنس" label="الجنس" list="gender_list" />
                    <datalist id="gender_list">
                        <option value="ذكر">
                        <option value="انثى">
                    </datalist>
                </div>
                {{-- بيانات العمل --}}
                <div class="form-group col-md-3">
                    <x-form.input  name="working_status" placeholder="أدخل حالة الدوام"
                        label="حالة الدوام" list="working_status_list" />
                    <datalist id="working_status_list">
                        @foreach ($working_status as $working_status)
                            <option value="{{ $working_status }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="type_appointment" placeholder="أدخل نوع التعين"
                        label="نوع التعين" list="type_appointment_list" />
                    <datalist id="type_appointment_list">
                        @foreach ($type_appointment as $type_appointment)
                            <option value="{{ $type_appointment }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="field_action" placeholder="أدخل مجال العمل"
                        label="مجال العمل" list="field_action_list" />
                    <datalist id="field_action_list">
                        @foreach ($field_action as $field_action)
                            <option value="{{ $field_action }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="dual_function" placeholder="أدخل الحالة"
                        label="مزدوج الوظيفة" list="dual_function_list" />
                    <datalist id="dual_function_list">
                        <option value="غير موظف">
                        <option value="موظف">
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="state_effectiveness"
                        placeholder="أدخل حالة الفعالية" label="حالة الفعالية" list="state_effectiveness_list" />
                    <datalist id="state_effectiveness_list">
                        @foreach ($state_effectiveness as $state_effectiveness)
                            <option value="{{ $state_effectiveness }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="nature_work" placeholder="أدخل طبيعة العمل"
                        label="طبيعة العمل" list="nature_work_list" />
                    <datalist id="nature_work_list">
                        @foreach ($nature_work as $nature_work)
                            <option value="{{ $nature_work }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="association" placeholder="أدخل الجمعية"
                        label="الجمعية" list="association_list" />
                    <datalist id="association_list">
                        @foreach ($association as $association)
                            <option value="{{ $association }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="workplace" placeholder="أدخل مكان العمل"
                        label="مكان العمل" list="workplace_list" />
                    <datalist id="workplace_list">
                        @foreach ($workplace as $workplace)
                            <option value="{{ $workplace }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="section" placeholder="أدخل القسم" label="القسم"
                        list="section_list" />
                    <datalist id="section_list">
                        @foreach ($section as $section)
                            <option value="{{ $section }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="dependence" placeholder="أدخل التبعية"
                        label="التبعية" list="dependence_list" />
                    <datalist id="dependence_list">
                        @foreach ($dependence as $dependence)
                            <option value="{{ $dependence }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="establishment" placeholder="أدخل المنشأة"
                        label="المنشأة" list="establishment_list" />
                    <datalist id="establishment_list">
                        @foreach ($establishment as $establishment)
                            <option value="{{ $establishment }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input  name="payroll_statement" placeholder="أدخل بيان الراتب"
                        label="بيان الراتب" list="payroll_statement_list" />
                    <datalist id="payroll_statement_list">
                        @foreach ($payroll_statement as $payroll_statement)
                            <option value="{{ $payroll_statement }}">
                        @endforeach
                    </datalist>
                </div>
                {{-- إضافات --}}
                <div class="form-group col-md-3">
                    <x-form.input type="month" :value="$month" name="month" label="الشهر المطلوب" />
                </div>
                <div class="form-group col-md-3">
                    <label for="report_type">نوع الكشف</label>
                    <select class="custom-select" name="report_type" id="report_type" required>
                        <option  value="" disabled selected>حدد نوع الكشف</option>
                        <option value="employees">كشف موظفين</option>
                        <option value="salaries">كشف الرواتب</option>
                        <option value="accounts">كشف حسابات البنك</option>
                        <option value="employees_totals">كشف الإجماليات</option>
                        <option value="employees_fixed">كشف الإدخالات الثابتة</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="export_type">طريقة التصدير</label>
                    <select class="custom-select" name="export_type" id="export_type">
                        <option selected="" value="view">معاينة</option>
                        <option value="export_pdf">PDF</option>
                        {{-- <option value="export_excel">Excel</option> --}}
                    </select>
                </div>
            </div>

            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title"></h2>
                </div>
                <div class="col-auto">
                    <button type="submit"  class="btn btn-primary">
                        تصدير
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-front-layout>
