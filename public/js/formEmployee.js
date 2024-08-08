(function($){
    $("#type_appointment").on('change',function () {
        let type = $(this).val();
        if(type == "مثبت"){
            $("div#proven").slideDown();
            $("div#notProven").slideUp();
        }
        else{
            $("div#proven").slideUp();
            $("div#notProven").slideDown();
        }
    });
})(jQuery);

