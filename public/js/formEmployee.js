(function($){
    // date change
    $("input[name='date_of_birth']").on("input", function() {
        let date_of_birth = $("input[name='date_of_birth']").val();
        let thisYear = new Date().getFullYear();
        let year_of_birth = moment(date_of_birth).format('YYYY');
        $("input[name='age']").val(thisYear - year_of_birth);
        let futureDate = moment(date_of_birth, "YYYY-MM-DD").add(60, "years").format("YYYY-MM-DD");
        $("input[name='date_retirement']").val(futureDate);
    });
    $("input[name='date_installation']").on("input", function() {
        let thisYear = new Date().getFullYear();
        let date_installation = moment($("input[name='date_installation']").val()).format('YYYY');
        $("input[name='years_service']").val(thisYear - date_installation)
    });
    // type_appointment change
    let type_appointment = function () {
        let type = $('#type_appointment').val();
        if (type == "مثبت") {
            $("div#proven").slideDown();
            $("div#notProven").slideUp();
            $("div#daily").slideUp();
            $('#proven').find('input.required,select.required').each(function () {
                $(this).prop('required', true);
            });
        }else{
            $('#proven').find('input.required,select.required').each(function () {
                $(this).prop('required', false);
            });
            $("div#proven").slideUp();
        }
        if (type == "يومي") {
            $("div#daily").slideDown();
        }else{
            $("div#daily").slideUp();
        }
        if (type != "مثبت" && type != "نسبة" && type != "يومي") {
            $("div#notProven").slideDown();
        }else{
            $("div#notProven").slideUp();
        }
    };
    $("#type_appointment").on('change',function () {
        type_appointment();
    });
    type_appointment();

    // type_appointment == 'daily'
    let number_of_days = 0;
    let today_price = 0;
    $('.daily_fields').on('input', function() {
        let name = $(this).data("name");
        if (name == 'number_of_days') {
            number_of_days = $(this).val();
        }
        if (name == 'today_price') {
            today_price = $(this).val();
        }
        let total = number_of_days * today_price;
        $("input[name='specificSalary']").val(total)
    });

    // bank change
    let bank = function () {
        let bank_id = $('#bank_id').val();
        if(bank_id != null && bank_id != ""){
            $('#account_number').prop('required', true);
        }else{
            $('#account_number').prop('required', false);
        }
    }
    $('#bank_id').on('change',bank());
    bank();


    // form submit
    $.validator.messages.required = "هذا الحقل مطلوب";
    $("#myForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            }
        },
        messages: {
            name: "يرجى إدخال اسم المستخدم",
        }
    });
    $('.prev').click(function() {
        let tabIndex = $(this).data('num') - 1;
        $('.nav-link').removeClass('active');

        $('#tab' + (tabIndex)).addClass('active');

        $('.tab-pane').removeClass('active fade');
        $('.tab-pane').addClass('fade');

        $('#menu' + (tabIndex)).removeClass('fade');
        $('#menu' + (tabIndex)).addClass('active');
    });
    $('.next').click(function() {
        // التحقق من صحة الحقول في التاب الحالي باستخدام jQuery Validation
        let currentTab = $(this).closest('.tab-pane');
        let form = $('#myForm'); // اختر النموذج بشكل عام
        let isValid = true;
        // تحقق من صحة النموذج
        form.find('.tab-pane').each(function() {
            if ($(this).hasClass('active')) {
                // التحقق من صحة الحقول في التاب الحالي فقط
                isValid = form.validate().form(); // تحقق من صحة النموذج
            }
        });

        // إذا كانت جميع الحقول صحيحة
        if (isValid) {
            // الانتقال إلى التاب التالي
            let tabIndex = $(this).data('num') + 1;

            // إزالة التفعيل من التابات السابقة
            $('.nav-link').removeClass('active');
            $('#tab' + tabIndex).addClass('active');

            // تغيير محتوى التاب الحالي
            $('.tab-pane').removeClass('active fade').addClass('fade');
            $('#menu' + tabIndex).removeClass('fade').addClass('active');
            $('#alerts').slideUp();
        } else {
            // إذا كانت هناك أخطاء، لا تواصل
            $('#alerts').slideDown();
            $('#alerts').text("يرجى تصحيح الأخطاء في النموذج قبل المتابعة.");
        }
    });
    $('.nav-tabs .nav-item .nav-link').click(function(event) {
        let form = $('#myForm'); // اختر النموذج بشكل عام
        let isValid = true;
        // تحقق من صحة النموذج
        form.find('.tab-pane').each(function() {
            if ($(this).hasClass('active')) {
                // التحقق من صحة الحقول في التاب الحالي فقط
                isValid = form.validate().form(); // تحقق من صحة النموذج
            }
        });
        if (isValid) {
            $('#alerts').slideUp();
        }else{
            event.preventDefault(); // يمنع الإجراء الافتراضي للنموذج (مثل الإرسال).
            event.stopPropagation(); // يمنع انتشار الحدث إلى العناصر الأخرى.
            $('#alerts').slideDown();
            $('#alerts').text("يرجى تصحيح الأخطاء في النموذج قبل المتابعة.");
        }
    });

})(jQuery);

