(function ($) {
    // استخدم كائن Date للحصول على التاريخ الحالي
    let currentDate = new Date();
    // احصل على الشهر (بالتنسيق من 0 إلى 11، حيث يكون يناير هو الشهر 0)
    var currentMonth = currentDate.getMonth() +1;

    let fields = [
        'administrative_allowance',
        'scientific_qualification_allowance',
        'transport',
        'extra_allowance',
        'salary_allowance',
        'ex_addition',
        'mobile_allowance',
        'health_insurance',
        'f_Oredo',
        'association_loan',
        'tuition_fees',
        'voluntary_contributions',
        'savings_loan',
        'shekel_loan',
        'paradise_discount',
        'other_discounts',
        'proportion_voluntary',
        'savings_5',
    ];
    for (let field of fields) {
        $('#' + field + '_form').on('click', function (event) {
            $.ajax({
                url: "/fixed_entries/",
                method: "post",
                data: {
                    employee_id: $('#employee_id').val(),
                    [field + '_months']: $('#' + field + '_months').val(),
                    "01": $('#' + field + '_month-1').val(),
                    "02": $('#' + field + '_month-2').val(),
                    "03": $('#' + field + '_month-3').val(),
                    "04": $('#' + field + '_month-4').val(),
                    "05": $('#' + field + '_month-5').val(),
                    "06": $('#' + field + '_month-6').val(),
                    "07": $('#' + field + '_month-7').val(),
                    "08": $('#' + field + '_month-8').val(),
                    "09": $('#' + field + '_month-9').val(),
                    10: $('#' + field + '_month-10').val(),
                    11: $('#' + field + '_month-11').val(),
                    12: $('#' + field + '_month-12').val(),
                    [field + '_create']: true,
                    _token: csrf_token,
                },
                success: function (response) {
                    console.log(response);
                    $('#open_' + field).modal('toggle')
                },
                error: function (response) {
                    console.error(response);
                }
            });
        });
    }
    let total_association_loan;
    $(".table-hover").delegate("tr.employee_select", "click", function () {
        let employee_id_select = $(this).data("id");
        $.ajax({
            url: "/fixed_entries/getFixedEntriesData",
            method: "post",
            data: {
                employee_id: employee_id_select,
                _token: csrf_token,
            },
            success: function (response) {
                $("#total_association_loan").val(response)
                $("#total_association_loan_old").text(response)
                total_association_loan = response;
            },
            error: function (response) {
                console.error(response);
            }
        });
    });
    let association_loan_months_total = 0;
    let association_loan_basic;
    let association_loan_months;
    let total_association_loan_new_val;

    $('.association_loan_fields').on('input',function(e){
        association_loan_basic = $('#association_loan_basic').val();
        association_loan_months = $('#association_loan_months').val();
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                $("#association_loan_month-"+i).val(association_loan_months)
            }
        }
        association_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            association_loan_months_total = Number(association_loan_months_total) + Number($("#association_loan_month-" + i).val());
        }
        total_association_loan_new_val = Number(total_association_loan) +  (association_loan_basic - (association_loan_months_total))
        $("#total_association_loan").val(total_association_loan_new_val);
    })
    $('.association_loan_fields_month').on('input',function(e){
        total_association_loan_new_val = 0;
        association_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                association_loan_months_total += Number($("#association_loan_month-" + i).val());
            }
        }
        total_association_loan_new_val = Number(total_association_loan) + (association_loan_basic - (association_loan_months_total))
        $("#total_association_loan").val(total_association_loan_new_val);
    })
    $('#associationLoanSubmit').on('click', function (event) {
        $.ajax({
            url: "/fixed_entries/association_loan/",
            method: "post",
            data: {
                employee_id: $('#employee_id').val(),
                "01": $('#association_loan_month-1').val(),
                "02": $('#association_loan_month-2').val(),
                "03": $('#association_loan_month-3').val(),
                "04": $('#association_loan_month-4').val(),
                "05": $('#association_loan_month-5').val(),
                "06": $('#association_loan_month-6').val(),
                "07": $('#association_loan_month-7').val(),
                "08": $('#association_loan_month-8').val(),
                "09": $('#association_loan_month-9').val(),
                10: $('#association_loan_month-10').val(),
                11: $('#association_loan_month-11').val(),
                12: $('#association_loan_month-12').val(),
                total_association_loan: $('#total_association_loan').val(),
                _token: csrf_token,
            },
            success: function (response) {
                $('#open_association_loan').modal('toggle')
            },
            error: function (response) {
                console.error(response);
            }
        });
    });

})(jQuery);
