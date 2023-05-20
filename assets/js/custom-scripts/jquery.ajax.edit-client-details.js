(function ($) {

    //sunmit form 
    let ajax_url = $('#edit-client-form').attr('action')
    $('#edit-client-form').removeAttr('action');
    console.log(ajax_url);
    $(document.body).on('submit', '#edit-client-form', function (e) {
        e.preventDefault();
        let this_form = $(this).closest('form');
        let form_data = this_form.serializeArray();
        let update_id = $('#client-id').attr('data-client-id')
        let data = {
            "form_data": form_data,
            "update_id":update_id
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
                        success_html += '<strong>Client Updated Sucessfully!</strong>  ';
                        success_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> ';
                        success_html += '</div>';
                        $(this_form).prepend(success_html);
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