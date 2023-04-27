(function ($) {
    //

    //address
    let address_text_no = $('[data-ref=use-text-box-no]');
    let address_text_yes = $('[data-ref=use-text-box-yes]');
    address_text_yes.addClass('d-none');
    address_text_yes.detach();
    $('[name=textbox-usage]').on('change', function () {
        $('[name=textbox-usage]').prop('checked', false);
        $(this).prop('checked', true);
        if ($(this).is(':checked')) {
            if ($(this).attr('id') === 'use-text-box-yes') {
                $('#address-box').append(address_text_yes);
                $('#address-box').find('.d-none').removeClass('d-none');
                address_text_no.detach();
                
            }
            else {
                $('#address-box').append(address_text_no);
                address_text_yes.detach();
                
            }
        }
    });


    let input_city = $('#input-city');
    let address_country_city = $('#address-country-city');
    // input_city.addClass('d-none');
    input_city.detach();
    $('#input-city-check').on('change', function(){
        if($(this).is(':checked')){
            $(this).parent().append(input_city);
            address_country_city.detach();
            $(this).parent().find('d-none').removeClass('d-none');
        }
        else{
            $(this).parent().parent().prepend(address_country_city);
            input_city.detach();
        }
    });

    //sunmit form 
    $(document.body).on('click','.submit-form',function(e){
        e.preventDefault();
        let this_form = $(this).closest('form');
        console.warn(this_form);
        let form_data = this_form.serializeArray();
        console.warn(form_data);
    });


})(jQuery);