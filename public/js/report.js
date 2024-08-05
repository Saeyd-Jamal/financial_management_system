(function($){
    $("#report_type").on('change',function () {
        let type = $(this).val();
        if(type == "bank"){
            $("div#bankDiv").slideDown();
        }
        else{
            $("div#bankDiv").slideUp();
        }
    });
})(jQuery);
