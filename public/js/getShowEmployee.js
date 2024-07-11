(function ($) {
    $(".showEmployee").on("click", function () {
        let employee = $(this).data("id");
        $.ajax({
            url: app_link + "employees/" + employee, // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("div#ModalShow").remove();
                let employee = `<ul>
                                        <li>رقم الهوية : ` +
                    response["employee_id"] +
                    `</li>
                                        <li>العمر : ` +
                    response["age"] +
                    `</li>
                                        <li>تاريخ الميلاد : ` +
                    response["date_of_birth"] +
                    `</li>
                                        <li>الجنس : ` +
                    response["gender"] +
                    `</li>
                                        <li>الحالة الزوجية : ` +
                    response["matrimonial_status"] +
                    `</li>
                                        <li>عدد الزوجات : ` +
                    response["number_wives"] +
                    `</li>
                                        <li>عدد الأولاد : ` +
                    response["number_children"] +
                    `</li>
                                        <li>عدد الأولاد في الجامعة : ` +
                    response["number_university_children"] +
                    `</li>
                                        <li>المؤهل العلمي : ` +
                    response["scientific_qualification"] +
                    `</li>
                                        <li>التخصص : ` +
                    response["specialization"] +
                    `</li>
                                        <li>الجامعة : ` +
                    response["university"] +
                    `</li>
                                        <li>المنطقة : ` +
                    response["area"] +
                    `</li>
                                        <li>العنوان : ` +
                    response["address"] +
                    `</li>
                                        <li>الإيميل : ` +
                    response["email"] +
                    `</li>
                                        <li>رقم الهاتف : ` +
                    response["phone_number"] +
                    `</li>
                                        <li>فئة الراتب : ` +
                    response["salary_category"] +
                    `</li>
                                    </ul>`
                let WorkData = "";
                let btnWorkData = "";
                if (response["work_data"] != null) {
                    WorkData =
                        `<h3 class="h3">بيانات العمل</h3>
                        <ul>
                            <li>حالة الداوم : ` +
                        response["work_data"]["working_status"] +
                        `</li>
                            <li>نوع التعين : ` +
                        response["work_data"]["type_appointment"] +
                        `</li>
                            <li>مجال العمل : ` +
                        response["work_data"]["field_action"] +
                        `</li>
                            <li>موظف حكومة : ` +
                        response["work_data"]["government_official"] +
                        `</li>
                            <li>مزدوج الوظيفة : ` +
                        response["work_data"]["dual_function"] +
                        `</li>
                            <li>سنوات الخدمة : ` +
                        response["work_data"]["years_service"] +
                        `</li>
                            <li>طبيعة العمل : ` +
                        response["work_data"]["nature_work"] +
                        `</li>
                            <li>حالةا لفعالية : ` +
                        response["work_data"]["state_effectiveness"] +
                        `</li>
                            <li>جمعية : ` +
                        response["work_data"]["association"] +
                        `</li>
                            <li>مكان العمل : ` +
                        response["work_data"]["workplace"] +
                        `</li>
                            <li>قسم : ` +
                        response["work_data"]["section"] +
                        `</li>
                            <li>التبعية : ` +
                        response["work_data"]["dependence"] +
                        `</li>
                            <li>تاريخ العمل : ` +
                        response["work_data"]["working_date"] +
                        `</li>
                            <li>تاريخ التثبيت : ` +
                        response["work_data"]["date_installation"] +
                        `</li>
                            <li>تاريخ التقاعد : ` +
                        response["work_data"]["date_retirement"] +
                        `</li>
                            <li>الفرع : ` +
                        response["work_data"]["branch"] +
                        `</li>
                            <li>المنشأة : ` +
                        response["work_data"]["establishment"] +
                        `</li>
                            <li>المؤسسة E : ` +
                        response["work_data"]["foundation_E"] +
                        `</li>
                        </ul>`;
                    btnWorkData =
                        `<a href="` +
                        app_link +
                        `work_data_employees/` +
                        response["id"] +
                        `/edit" target="_blank" class="btn btn-primary">تعديل بيانات العمل</a>`;
                }

                let modalDiv =
                    `<div class="modal fade" id="ModalShow" tabindex="-1" role="dialog" aria-labelledby="ModalShowTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalShowTitle">الموظف/ة : ` +
                    response["name"] +
                    `</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                    <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingEmployee">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEmployee" aria-expanded="true" aria-controls="collapseEmployee">
                                            البيانات الشخصية
                                            </button>
                                        </h5>
                                        </div>
                                        <div id="collapseEmployee" class="collapse" aria-labelledby="headingEmployee" data-parent="#accordion">
                                        <div class="card-body">
                                            ` + employee +`
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingWorkData">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseWorkData" aria-expanded="true" aria-controls="collapseWorkData">
                                            بيانات العمل
                                            </button>
                                        </h5>
                                        </div>
                                        <div id="collapseWorkData" class="collapse" aria-labelledby="headingWorkData" data-parent="#accordion">
                                        <div class="card-body">
                                            `+ WorkData + `
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="` + app_link + `employees/` + response["id"] + `/edit" target="_blank" class="btn btn-primary">تعديل البينات الشخصية</a>
                                    ` + btnWorkData + `
                                </div>
                                </div>
                            </div>
                        </div>`;
                $("body").append(modalDiv);
                $("#openModalShow").click();
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });
})(jQuery);
