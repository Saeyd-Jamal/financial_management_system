(function ($) {
    $(".employee_fields_search").on("input", function (e) {
        let employeeId = $('#employee_id_search').val();
        let employeeName = $('#employee_name_search').val();
        $.ajax({
            url: "/employees/getEmployee/", //data-id
            method: "post",
            data: {
                employeeId: employeeId,
                employeeName: employeeName,
                _token: csrf_token,
            },
            success: function (response) {
                $("#table_employee").empty();
                if (response.length != 0) {
                    for (let index = 0; index < response.length; index++) {
                        $("#table_employee").append(
                            "<tr class='employee_select' data-id=" +response[index]["id"] +"><th scope='row'>" +
                                response[index]["id"] +
                                "</th><td>" +
                                response[index]["employee_id"] +
                                "</td><td>" +
                                response[index]["name"] +
                                "</td><td>" +
                                response[index]["date_of_birth"] +
                                "</td></tr>"
                        );
                    }
                }else{
                    $("#table_employee").append(
                        "<tr><td colspan='3'>يرجى التأكد من صحة البيانات</td></tr>"
                    );
                }
            },
        });
    });
    $(".table-hover").delegate("tr.employee_select", "click", function () {
        let employee_id_select = $(this).data("id");
        $("input[name=employee_id]").val(employee_id_select);
        $("#searchEmployee .close").click();
        $("#searchEmployee").modal("toggle");
    });

})(jQuery);
