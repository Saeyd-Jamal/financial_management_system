$(".employee_fields_search").on("input", function (e) {
    $.ajax({
        url: "/employees/",
        method: "post",
        data: {
            _token: csrf_token,
        },
        success: function (response) {

        },
        error: function (response) {

        }
    });
});

