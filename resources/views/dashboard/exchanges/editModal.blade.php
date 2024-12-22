<div class="container-fluid  p-0">
    <h3>تعديلات الموظف : <span id="employee_name"></span></h3>
    <div class="row">
        <div class="form-group p-1 col-6">
            <label for="employee_id">رقم الموظف</label>
            <div class="input-group mb-3">
                <x-form.input name="employee_id" placeholder="0" readonly required />
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee" >
                        <i class="fe fe-search"></i>
                    </button>
                </div>
            </div>
            <div id="name">
            </div>
        </div>
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
    <div class="row" id="exchanges_form">
        <div class="form-group p-3 col-4 exchanges" id="receivables" style="display: none;">
            <x-form.input type="number" min="0" value="0"  label="خصم المستحقات ش" name="receivables_discount" placeholder="0.." />
            <span class="totals" id="receivables_total">
            </span>
        </div>
        <div class="form-group p-3 col-4 exchanges" id="savings"  style="display: none;">
            <x-form.input type="number" min="0" value="0"  label="خصم الإدخارات $" name="savings_discount" placeholder="0.." />
            <span class="totals" id="savings_total">
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
            <textarea class="form-control" id="notes" name="notes" placeholder="....." rows="2"></textarea>
        </div>
    </div>
    <div class="d-flex justify-content-end" id="btns_form">
        <button aria-label="" type="button" class="btn btn-danger px-2" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
            إغلاق
        </button>
        <button type="button" id="update" class="btn btn-primary mx-2">
            <i class="fe fe-edit"></i>
            تعديل
        </button>
    </div>
</div>
