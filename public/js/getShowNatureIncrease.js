(function ($) {
    $(".table-hover").delegate("tr.increase_select", "click", function () {
        nature_work_increase = $(this).data("id");
        $.ajax({
            url: app_link + "nature_work_increases/" + nature_work_increase + "/edit", // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                nature_work_increase: nature_work_increase,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("div#showIncrease form").remove();
                $("div.modal-footer form").remove();
                let modalDiv =`
                        <form action="`+app_link+`nature_work_increases/`+ response['id'] +`" method="post" class="col-12">
                            <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                            <input type="hidden" name="_method" value="put">
                            <div class="row">
                                <div class="form-group p-3 col-4">
                                    <label for="nature_work">طبيعة العمل</label>
                                    <select class="custom-select" id="nature_work" name="nature_work" required>
                                        <option>عرض القيم المتوفرة</option>
                                        <option selected value="`+ response['nature_work'] +`" >`+ response['nature_work'] +`</option>
                                    </select>
                                </div>
                                <div class="form-group p-3 col-5">
                                    <label for="scientific_qualification">المؤهل العلمي</label>
                                    <select class="custom-select" id="scientific_qualification" name="scientific_qualification" required>
                                        <option>عرض القيم المتوفرة</option>
                                        <option selected value="`+ response['scientific_qualification'] +`">`+ response['scientific_qualification'] +`</option>
                                    </select>
                                </div>
                                <div class="form-group p-3 col-3">
                                    <label for="percentage">النسبة</label>
                                    <input type="number" id="percentage" name="percentage" class="form-control" min="0" max="100" placeholder="25%" value="`+ response['percentage'] +`" required="required">
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        تعديل
                                    </button>
                                </div>
                            </div>
                        </form>
                            `;
                $("div#showIncrease").append(modalDiv);
                $("div.modal-footer").append(`
                    <form action="`+app_link+`nature_work_increases/`+ response['id'] +`" method="post" class="mr-3">
                        <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin: 0.5rem -0.75rem; text-align: right;"
                        href="#">حذف</button>
                    </form>
                `);
                $("#openModalShow").click();
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });


})(jQuery);
