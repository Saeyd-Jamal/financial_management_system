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
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#areas" aria-expanded="false"
                aria-controls="areas">
            المناطق
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#working_status" aria-expanded="false"
                aria-controls="working_status">
            حالة الدوام
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#nature_work" aria-expanded="false"
                aria-controls="nature_work">
            طبيعة العمل
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#type_appointment" aria-expanded="false"
                aria-controls="type_appointment">
            نوع التعين
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#government_official" aria-expanded="false"
                aria-controls="government_official">
            موظف حكومة
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#field_action" aria-expanded="false"
                aria-controls="field_action">
            مجال العمل
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#matrimonial_status" aria-expanded="false"
                aria-controls="matrimonial_status">
            الحالة الزوجية
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#scientific_qualification" aria-expanded="false"
                aria-controls="scientific_qualification">
            المؤهل العلمي
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#state_effectiveness" aria-expanded="false"
                aria-controls="state_effectiveness">
            حالة الفعالية
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#association" aria-expanded="false"
                aria-controls="association">
            الجمعية
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#workplace" aria-expanded="false"
                aria-controls="workplace">
            مكان العمل
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#section" aria-expanded="false"
                aria-controls="section">
            القسم
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#dependence" aria-expanded="false"
                aria-controls="dependence">
            التبعية
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#branch" aria-expanded="false"
                aria-controls="branch">
            الفرع
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#establishment" aria-expanded="false"
                aria-controls="establishment">
            المُنشأة
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#foundation_E" aria-expanded="false"
                aria-controls="foundation_E">
            المؤسسة بالإنجليزي
        </button>
        <button class="btn btn-info m-2"
            type="button" data-toggle="collapse"
            data-target=".multi-collapse" aria-expanded="false"
            aria-controls=".multi-collapse">
            عرض الجميع
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
    <div class="collapse multi-collapse" id="areas">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="areas">المناطق</label>
                    <x-form.input required name="areas" placeholder="إضافة منطقة جديدة : دير البلح" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="areas" name="areas">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($areas as $area)
                                <option value="{{$area['id']}}">{{$area['value']}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete fe-30"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="working_status">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="working_status">حالة الدوام</label>
                    <x-form.input required name="working_status" placeholder="إضافة قيمة جديدة : مداوم ، نسبة ..." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="working_status" name="working_status">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($working_status as $working_status)
                                <option value="{{$working_status['id']}}">{{$working_status['value']}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="nature_work">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="nature_work">طبيعة العمل</label>
                    <x-form.input required name="nature_work" placeholder="إضافة قيمة جديدة : مدير عام / محاسب .." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="nature_work" name="nature_work">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($nature_work as $nature_work)
                                <option value="{{$nature_work['id']}}">{{$nature_work['value']}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="type_appointment">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="type_appointment">نوع التعين</label>
                    <x-form.input required name="type_appointment" placeholder="إضافة قيمة جديدة : مثبت ..." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="type_appointment" name="type_appointment">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($type_appointment as $type_appointment)
                                <option value="{{$type_appointment['id']}}">{{$type_appointment['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="government_official">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="government_official">موظف حكومة</label>
                    <x-form.input required name="government_official" placeholder="إضافة قيمة جديدة : مثبت ...." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="government_official" name="government_official">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($government_official as $government_official)
                                <option value="{{$government_official['id']}}">{{$government_official['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="field_action">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="field_action">مجال العمل</label>
                    <x-form.input required name="field_action" placeholder="إضافة قيمة جديدة : إداري / صحة ...." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="matrimonial_status" name="matrimonial_status">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($field_action as $field_action)
                                <option value="{{$field_action['id']}}">{{$field_action['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="matrimonial_status">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="matrimonial_status">الحالة الزوجية</label>
                    <x-form.input required name="matrimonial_status" placeholder="إضافة قيمة جديدة : متزوج / أعزب ...." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="matrimonial_status" name="matrimonial_status">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($matrimonial_status as $matrimonial_status)
                                <option value="{{$matrimonial_status['id']}}">{{$matrimonial_status['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="scientific_qualification">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="scientific_qualification">المؤهل العلمي</label>
                    <x-form.input required name="scientific_qualification" placeholder="إضافة قيمة جديدة : بكالوريوس" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="scientific_qualification" name="scientific_qualification">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($scientific_qualification as $scientific_qualification)
                                <option value="{{$scientific_qualification['id']}}">{{$scientific_qualification['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="state_effectiveness">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="state_effectiveness">حالة الفعالية</label>
                    <x-form.input required name="state_effectiveness" placeholder="إضافة قيمة جديدة : فعال / شهيد" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="state_effectiveness" name="state_effectiveness">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($state_effectiveness as $state_effectivene)
                                <option value="{{$state_effectivene['id']}}">{{$state_effectivene['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="association">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="association">الجمعية</label>
                    <x-form.input required name="association" placeholder="إضافة قيمة جديدة : صلاح" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="association" name="association">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($association as $association)
                                <option value="{{$association['id']}}">{{$association['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="workplace">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="workplace">مكان العمل</label>
                    <x-form.input required name="workplace" placeholder="إضافة قيمة جديدة : المقر ..." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="workplace" name="workplace">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($workplace as $workplace)
                                <option value="{{$workplace['id']}}">{{$workplace['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="section">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="section">الأقسام</label>
                    <x-form.input required name="section" placeholder="إضافة قسم جديد : الكفالات ..." class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="section" name="section">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($section as $section)
                                <option value="{{$section['id']}}">{{$section['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="dependence">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="dependence">التبعية</label>
                    <x-form.input required name="dependence" placeholder="إضافة قيمة جديدة : م.يافا" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="dependence" name="dependence">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($dependence as $dependence)
                                <option value="{{$dependence['id']}}">{{$dependence['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="branch">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="branch">الفرع</label>
                    <x-form.input required name="branch" placeholder="إضافة فرع جديد : دير البلح" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="branch" name="branch">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($branch as $branch)
                                <option value="{{$branch['id']}}">{{$branch['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="establishment">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="establishment">المنشأة</label>
                    <x-form.input required name="establishment" placeholder="إضافة قيمة جديدة : جمعية دار اليتيم" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="establishment" name="establishment">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($establishment as $establishment)
                                <option value="{{$establishment['id']}}">{{$establishment['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="foundation_E">
        <form action="{{ route('constants.store')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="foundation_E">المؤسسة بالإنجليزي</label>
                    <x-form.input required name="foundation_E" placeholder="إضافة قيمة جديدة : Palestinian Orphans Home" class="d-inline w-75" />
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <select class="custom-select" id="foundation_E" name="foundation_E">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($foundation_E as $foundation_E)
                                <option value="{{$foundation_E['id']}}">{{$foundation_E['value']}}</option>
                            @endforeach
                        </select><div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
</x-front-layout>
