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
                    <x-form.input type="month" :value="$month" name="month" label="الشهر المطلوب" />
                </div>
                <div class="form-group col-md-3">
                    <label for="area">المنظقة</label>
                    <select name="area" id="area" class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area }}"> {{ $area }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="matrimonial_status">الحالة الزوجية</label>
                    <select name="matrimonial_status" id="matrimonial_status"  class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($matrimonial_status as $matrimonial_status)
                            <option value="{{ $matrimonial_status }}"> {{ $matrimonial_status }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="scientific_qualification">المؤهل العلمي</label>
                    <select name="scientific_qualification" id="scientific_qualification"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($scientific_qualification as $scientific_qualification)
                            <option value="{{ $scientific_qualification }}">{{ $scientific_qualification }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="gender">الجنس</label>
                    <select name="gender" id="gender"   class="custom-select">
                        <option value="" selected>حدد جنس معين</option>
                        <option value="ذكر">ذكور</option>
                        <option value="انثى">إناث</option>
                    </select>
                </div>
                {{-- بيانات العمل --}}
                <div class="form-group col-md-3">
                    <label for="working_status">حالة الدوام</label>
                    <select name="working_status" id="working_status"   class="custom-select">
                        <option value="" selected>حدد الحالة</option>
                        @foreach ($working_status as $working_status)
                            <option value="{{ $working_status }}">{{ $working_status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">

                    <label for="field_action">مجال العمل</label>
                    <select name="field_action" id="field_action"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($field_action as $field_action)
                            <option value="{{ $field_action }}">{{ $field_action }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="dual_function">مزدوج الوظيفة</label>
                    <select name="dual_function" id="dual_function"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        <option value="غير موظف"> غير موظف</option>
                        <option value="موظف"> موظف</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="state_effectiveness">حالة الفعالية</label>
                    <select name="state_effectiveness" id="state_effectiveness"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($state_effectiveness as $state_effectiveness)
                            <option value="{{ $state_effectiveness }}">{{ $state_effectiveness }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="nature_work">طبيعة العمل</label>
                    <select name="nature_work" id="nature_work"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($nature_work as $nature_work)
                            <option value="{{ $nature_work }}">{{ $nature_work }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="workplace">مكان العمل</label>
                    <select name="workplace" id="workplace"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($workplace as $workplace)
                            <option value="{{ $workplace }}">{{ $workplace }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="section">القسم</label>
                    <select name="section" id="section"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($section as $section)
                            <option value="{{ $section }}">{{ $section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="type_appointment">نوع التعين</label>
                    <select name="type_appointment" id="type_appointment"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($type_appointment as $type_appointment)
                            <option value="{{ $type_appointment }}">{{ $type_appointment }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="dependence">التبعية</label>
                    <select name="dependence" id="dependence"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($dependence as $dependence)
                            <option value="{{ $dependence }}">{{ $dependence }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="establishment">المنشأة</label>
                    <select name="establishment" id="establishment"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($establishment as $establishment)
                            <option value="{{ $establishment }}">{{ $establishment }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="payroll_statement">بيان الراتب</label>
                    <select name="payroll_statement" id="payroll_statement"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($payroll_statement as $payroll_statement)
                            <option value="{{ $payroll_statement }}">{{ $payroll_statement }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="association">الجمعية</label>
                    <select name="association" id="association"   class="custom-select">
                        <option value="" selected>حدد القيمة</option>
                        @foreach ($association as $association)
                            <option value="{{ $association }}">{{ $association }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- إضافات --}}
                <div class="form-group col-md-3">
                    <label for="report_type">نوع الكشف</label>
                    <select class="custom-select" name="report_type" id="report_type" required>
                        <option  value="" disabled selected>حدد نوع الكشف</option>
                        <optgroup label="الكشوفات الأساسية">
                        <option value="employees">كشف موظفين</option>
                        <option value="salaries">كشف الرواتب</option>
                        <option value="accounts">كشف حسابات البنك</option>
                        <option value="employees_totals">كشف الإجماليات</option>
                        <option value="employees_fixed">كشف الإدخالات الثابتة</option>
                        <option value="bank" >كشف البنك</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="export_type">طريقة التصدير</label>
                    <select class="custom-select" name="export_type" id="export_type">
                        <option selected="" value="view">معاينة</option>
                        <option value="export_pdf">PDF</option>
                        <option value="export_excel">Excel</option>
                    </select>
                </div>
            </div>
            <div class="row" id="bankDiv" style="display: none;">
                <div class="form-group col-md-3">
                    <label for="bank">البنك</label>
                    <select name="bank" id="bank" class="custom-select">
                        <option value="" selected>حدد البنك المراد</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank}}">{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title"></h2>
                </div>
                <div class="col-auto">
                    <button type="reset"  class="btn btn-danger">
                        مسح
                    </button>
                    <button type="submit"  class="btn btn-primary">
                        تصدير
                    </button>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
    <script src="{{asset('js/report.js')}}"></script>
    @endpush
</x-front-layout>
