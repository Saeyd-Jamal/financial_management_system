(function($){
    $("#type_appointment").on('change',function () {
        let type = $(this).val();
        if(type == "مثبت"){
            $("div#proven").slideDown();
        }
        else{
            $("div#proven").slideUp();
        }
    });
})(jQuery);

