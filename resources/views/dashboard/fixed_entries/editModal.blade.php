<div class="container-fluid  p-0">
    <h3>تعديلات الموظف : <span id="employee_name"></span></h3>
    <div class="row mx-0">
        <!-- Bordered table -->
        <div class="col-12 my-4 p-0">
            <div class="card shadow">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-dark">
                            <tr>
                                <th>التعديل</th>
                                <th>ثابت</th>
                                <th>يناير</th>
                                <th>فبراير</th>
                                <th>مارس</th>
                                <th>أبريل</th>
                                <th>مايو</th>
                                <th>يونيو</th>
                                <th>يوليه</th>
                                <th>أغسطس</th>
                                <th>سبتمبر</th>
                                <th>أكتوبر</th>
                                <th>نوفمبر</th>
                                <th>ديسمبر</th>
                            </tr>
                        </thead>
                        <tbody id="fixed_entries_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- Bordered table -->
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <span class="h5">إجمالي قرض الجمعية : </span>
                <span id="association_loan_total" class="btn btn-warning h4 text-white mx-2"></span>
            </div>
            <div class="d-flex align-items-center">
                <span class="h5">إجمالي قرض الإدخار : </span>
                <span id="savings_loan_total" class="btn btn-warning h4 text-white  mx-2"></span>
            </div>
            <div class="d-flex align-items-center">
                <span class="h5">إجمالي قرض اللجنة (الشيكل) : </span>
                <span id="shekel_loan_total" class="btn btn-warning h4 text-white  mx-2"></span>
            </div>

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
