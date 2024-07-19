(function ($) {
    $("#monthInputSearch").on("input", function () {
        let month = $(this).val();
        $.ajax({
            url: app_link + "fixed_entries/", // Replace with your Laravel route URL
            method: "GET",
            data: {
                monthChange: true,
                month: month, // Replace with the current month you want to show
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("#fixed_entries_table").empty();
                response = response['data'];
                if (response.length != 0) {
                    for (let index = 0; index < response.length; index++) {
                        $("#fixed_entries_table").append(`
                                    <tr class="fixed_select" data-id="`+response[index]['id']+`">
                                        <td>`+ response[index]['employee']['id'] +`</td>
                                        <td>`+ response[index]['employee']['name'] +`</td>
                                        <td>`+ response[index]['administrative_allowance'] +`</td>
                                        <td>`+ response[index]['scientific_qualification_allowance'] +`</td>
                                        <td>`+ response[index]['transport'] +`</td>
                                        <td>`+ response[index]['extra_allowance'] +`</td>
                                        <td>`+ response[index]['salary_allowance'] +`</td>
                                        <td>`+ response[index]['ex_addition'] +`</td>
                                        <td>`+ response[index]['mobile_allowance'] +`</td>
                                        <td>`+ response[index]['health_insurance'] +`</td>
                                        <td>`+ response[index]['f_Oredo'] +`</td>
                                        <td>`+ response[index]['association_loan'] +`</td>
                                        <td>`+ response[index]['tuition_fees'] +`</td>
                                        <td>`+ response[index]['voluntary_contributions'] +`</td>
                                    </tr>`);
                    }
                }else{
                    $("#fixed_entries_table").append(
                        '<tr><td colspan="14" class="text-center text-danger">لا يوجد بيانات لعرضها"></td></tr>'
                    );
                }
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });

    let fixed_entrie;
    $(".table-hover").delegate("tr.fixed_select", "click", function () {
        fixed_entrie = $(this).data("id");
        let monthNow = $("#monthInputSearch").val();
        $.ajax({
            url: app_link + "fixed_entries/" + fixed_entrie, // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                month: monthNow, // Replace with the current month you want to show
                fixed_entrie: fixed_entrie,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("#ulShowFixed").remove();
                $("div.modal-footer a").remove();
                $("div.modal-footer form").remove();
                $("#monthModalSearch").val(monthNow);
                let modalDiv =`
                                <ul id="ulShowFixed">
                                    <li> اسم الموظف: `+ response['employee']['name'] +` </li>
                                    <li>علاوة إدارية : `+ response['administrative_allowance'] +` </li>
                                    <li>علاوة مؤهل علمي : `+ response['scientific_qualification_allowance'] +` </li>
                                    <li>مواصلات : `+ response['transport'] +` </li>
                                    <li>بدل إضافي : `+ response['extra_allowance'] +` </li>
                                    <li>علاوة أغراض راتب : `+ response['salary_allowance'] +` </li>
                                    <li>علاوة إضافة بأثر رجعي : `+ response['ex_addition'] +` </li>
                                    <li>علاوة جوال : `+ response['mobile_allowance'] +` </li>
                                    <li>تأمين صحي : `+ response['health_insurance'] +` </li>
                                    <li>ف. أوريدو : `+ response['f_Oredo'] +` </li>
                                    <li>قرض جمعية : `+ response['association_loan'] +` </li>
                                    <li>رسوم دراسية : `+ response['tuition_fees'] +` </li>
                                    <li>تبرعات : `+ response['voluntary_contributions'] +` </li>
                                    <li>قرض إدخار : `+ response['savings_loan'] +` </li>
                                    <li>قرض شيكل : `+ response['shekel_loan'] +` </li>
                                    <li>خصم اللجنة : `+ response['paradise_discount'] +` </li>
                                    <li>خصومات أخرى : `+ response['other_discounts'] +` </li>
                                    <li>تبرعات للحركة : `+ response['proportion_voluntary'] +` </li>
                                    <li>إدخار 5% : `+ response['savings_5'] +` </li>
                                </ul>
                            `;
                $("div#showFixed").append(modalDiv);
                $("div.modal-footer").append(`
                    <form action="`+app_link+`fixed_entries/`+ response['employee_id'] +`" method="post" class="mr-3">
                        <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin: 0.5rem -0.75rem; text-align: right;"
                        href="#">حذف</button>
                    </form>
                `);
                $("div.modal-footer").append(`<a href="`+app_link+`fixed_entries/`+ response['employee_id'] +`/edit" target="_blank" class="btn btn-primary mr-3">تعديل</a>`);
                $("#openModalShow").click();
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });
    $("#monthModalSearch").on("input", function () {
        let monthNow = $(this).val();
        $.ajax({
            url: app_link + "fixed_entries/" + fixed_entrie, // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                monthT: monthNow, // Replace with the current month you want to show
                fixed_entrie: fixed_entrie,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("#ulShowFixed").remove();
                $("div.modal-footer a").remove();
                $("div.modal-footer form").remove();
                let modalDiv =`
                                <ul id="ulShowFixed">
                                    <li> اسم الموظف: `+ response['employee']['name'] +` </li>
                                    <li>علاوة إدارية : `+ response['administrative_allowance'] +` </li>
                                    <li>علاوة مؤهل علمي : `+ response['scientific_qualification_allowance'] +` </li>
                                    <li>مواصلات : `+ response['transport'] +` </li>
                                    <li>بدل إضافي : `+ response['extra_allowance'] +` </li>
                                    <li>علاوة أغراض راتب : `+ response['salary_allowance'] +` </li>
                                    <li>علاوة إضافة بأثر رجعي : `+ response['ex_addition'] +` </li>
                                    <li>علاوة جوال : `+ response['mobile_allowance'] +` </li>
                                    <li>تأمين صحي : `+ response['health_insurance'] +` </li>
                                    <li>ف. أوريدو : `+ response['f_Oredo'] +` </li>
                                    <li>قرض جمعية : `+ response['association_loan'] +` </li>
                                    <li>رسوم دراسية : `+ response['tuition_fees'] +` </li>
                                    <li>تبرعات : `+ response['voluntary_contributions'] +` </li>
                                    <li>قرض إدخار : `+ response['savings_loan'] +` </li>
                                    <li>قرض شيكل : `+ response['shekel_loan'] +` </li>
                                    <li>خصم اللجنة : `+ response['paradise_discount'] +` </li>
                                    <li>خصومات أخرى : `+ response['other_discounts'] +` </li>
                                    <li>تبرعات للحركة : `+ response['proportion_voluntary'] +` </li>
                                    <li>إدخار 5% : `+ response['savings_5'] +` </li>
                                </ul>
                            `;
                $("div#showFixed").append(modalDiv);
                $("div.modal-footer").append(`
                    <form action="`+app_link+`fixed_entries/`+ response['employee_id'] +`" method="post" class="mr-3">
                        <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin: 0.5rem -0.75rem; text-align: right;"
                        href="#">حذف</button>
                    </form>
                `);
                $("div.modal-footer").append(`<a href="`+app_link+`fixed_entries/`+ response['employee_id'] +`/edit" target="_blank" class="btn btn-primary mr-3">تعديل</a>`);
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });



})(jQuery);
