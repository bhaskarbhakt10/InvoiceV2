(function ($) {

    //sunmit form 
    let ajax_url = $('#gen-invoice-form').attr('action')
    let proforma_btn = $('#proforma-btn-group');
    proforma_btn.detach();

    $('#gen-invoice-form').removeAttr('action')
    $(document.body).on('submit', '#gen-invoice-form', function (e) {
        e.preventDefault();
        let this_form = $(this).closest('form');
        let form_data = this_form.serializeArray();
        // console.log(form_data);
        let data = {
            "form_data": form_data,
        }
        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: data,
            success: function (data) {
                // console.log(data);
                let response = JSON.parse(data);
                for (const key in response) {
                    if (response[key] === true) {
                        let success_html = '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert"> ';
                        success_html += '<strong>Proforma added Sucessfully!</strong>  ';
                        success_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> ';
                        success_html += '</div>';
                        $(this_form)[0].reset();
                        $(this_form).prepend(success_html);
                        $(this_form).find('#btn-group').append(proforma_btn);
                        $(this_form).find('#btn-group #proforma-btn-group').removeClass('d-none');
                        // setTimeout(() => {

                        //     $('form .alert').remove();
                        //     window.location.reload();
                        // }, 3000);
                    }
                    if (response[key] === false) {
                        let exists_html = '<div class="alert alert-danger alert-dismissible fade show mt-5" role="alert"> ';
                        exists_html += '<strong>Oops Something Went Wrong!</strong>  ';
                        exists_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> ';
                        exists_html += '</div>';
                        $(this_form)[0].reset();
                        $(this_form).prepend(exists_html);
                        $('[name=textbox-usage]').trigger('change');
                        setTimeout(() => {
                            $('form .alert').remove();
                            window.location.reload();
                        }, 3000);
                    }
                }
            },
            error: function (error) {
                window.alert(error);
            }
        });


    });




})(jQuery);