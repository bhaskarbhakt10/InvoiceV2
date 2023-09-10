(function ($) {
    let ajax_url = $('#makeit-invoice').val();
    console.log(ajax_url);
    $('#makeit-invoice').remove();
    // let download_btn = $('.download');
    // download_btn.detach();
    $(document.body).on('click', '.invoice', function(e){
        e.preventDefault();
        let this_btn = $(this);
        let this_closest_href = $(this).closest('td').find('.view-pdf').attr('href');
        // console.log(this_closest_href);
        let parent = $(this).parent();
        let client_id = $(this).attr('data-id');
        let unique_profoma_id = $(this).attr('data-uniqid');
        const customNumber = confirm("Do you want to give a custom invoice number?");
        let custNo ;
        if(customNumber === true){
            custNo = prompt('Enter Custom Number', '#001/2023-24');

        }
        else{
            custNo = '';
        }
        let data ={
            "client_id" :client_id,
            'unique_profoma_id' : unique_profoma_id,
            'customNumber' : custNo
        }
        
        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: data,
            success: function (data) {
                let data__ = JSON.parse(data);
                console.log(data__);
                for (const key in data__) {
                   if(data__[key] === true){
                        $(this_btn).remove();
                        $(parent).append('<a href="'+this_closest_href+'&trigger=download" class="btn btn-outline-success download" id="download"><i class="fa-duotone fa-download"></i></a>')
                   }
                   else{
                    alert('something went wrong');
                   }    
                }
            },
            error: function (error) {
                window.alert(error);
            }
        });
        
    });
})(jQuery);