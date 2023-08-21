(function ($) {

    //sunmit form 
    let ajax_url = $('#add-client-form').attr('action')
    $('#add-client-form').removeAttr('action')
    $(document.body).on('submit', '#add-client-form', function (e) {
        e.preventDefault();
        let this_form = $(this).closest('form');
        let form_data = this_form.serializeArray();
        let client_name = $(this_form).find('[name="client-name"]').val();
        let client_country_code = $(this_form).find('[name="address-country-code"]').val();
        let client_phone_number = $(this_form).find('[name="client-phone-number"]').val();
        let client_email = $(this_form).find('[name="client-email"]').val();
        console.log(client_name, client_country_code, client_phone_number, client_email);
        let data = {
            "form_data": form_data,
            "client_name": client_name,
            "client_country_code": client_country_code,
            "client_phone_number": client_phone_number,
            "client_email": client_email
        }
        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: data,
            success: function (data) {
                console.log(data);
                let response = JSON.parse(data);
                const { response:status, msg } = response
                console.log(status,msg);
                if (status === true) {
                    let success_html = '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert"> ';
                    success_html += '<strong>' + msg + '</strong>  ';
                    success_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> ';
                    success_html += '</div>';
                    $(this_form)[0].reset();
                    $(this_form).prepend(success_html);
                    $('[name=textbox-usage]').trigger('change');
                    setTimeout(() => {
                        $('form .alert').remove();
                    }, 9000);
                }
                else {
                    let exists_html = '<div class="alert alert-warning alert-dismissible fade show mt-5" role="alert"> ';
                    exists_html += '<strong>' + msg + '</strong>  ';
                    exists_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> ';
                    exists_html += '</div>';
                    $(this_form)[0].reset();
                    $(this_form).prepend(exists_html);
                    $('[name=textbox-usage]').trigger('change');
                    setTimeout(() => {
                        $('form .alert').remove();
                    }, 9000);
                }
            },
            error: function (error) {
                window.alert(error);
            }
        });
    });





})(jQuery);