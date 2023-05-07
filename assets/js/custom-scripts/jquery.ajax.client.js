(function ($) {

    //sunmit form 
    let ajax_url = $('#add-client-form').attr('action')
    $('#add-client-form').removeAttr('action')
    $(document.body).on('submit', '#add-client-form', function (e) {
        e.preventDefault();
        let this_form = $(this).closest('form');
        let form_data = this_form.serializeArray();
        let data = {
            "form_data": form_data,
        }
        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: data,
            success: function (data) {
                let response = JSON.parse(data);
                for (const key in response) {
                    if (response[key] === true) {
                        let success_html = '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert"> ';
                        success_html += '<strong>Client added Sucessfully!</strong>  ';
                        success_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> '
                        success_html += '</div>'
                        $(this_form)[0].reset();
                        $(this_form).prepend(success_html);
                        $('[name=textbox-usage]').trigger('change');
                        setTimeout(() => {
                            $('form .alert').remove();
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