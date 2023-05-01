(function ($) {
    //

    //address
    let address_text_no = $('[data-ref=use-text-box-no]');
    let address_text_yes = $('[data-ref=use-text-box-yes]');
    address_text_yes.addClass('d-none');
    address_text_yes.detach();
    $(document).on('change', '[name=textbox-usage]', function () {
        $('[name=textbox-usage]').prop('checked', false);
        $(this).prop('checked', true);
        if ($(this).is(':checked')) {
            if ($(this).attr('id') === 'use-text-box-yes') {
                // $('#address-box').append(address_text_yes);
                $(address_text_yes).insertAfter($('#address-box .address-wrapper'))
                $('#address-box').find('.d-none').removeClass('d-none');
                address_text_no.detach();
                $('#country-currency').removeAttr('readonly')

            }
            else {
                $('#address-box').prepend(address_text_no);
                address_text_yes.detach();

            }
        }
    });


    let input_city = $('#input-city');
    let address_country_city = $('#address-country-city');
    // input_city.addClass('d-none');
    input_city.detach();
    $('#input-city-check').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().append(input_city);
            address_country_city.detach();
            $(this).parent().find('d-none').removeClass('d-none');
        }
        else {
            $(this).parent().parent().prepend(address_country_city);
            input_city.detach();
        }
    });



    //textbox address 
    let igst__ = $('#IGST');
    let cgst__ = $('#CGST');
    let sgst__ = $('#SGST');
    $(document).on('blur', '#text-address-box', function () {
        let this_input__ = $(this).val().toLowerCase();
        let this_input = this_input__.replace(/[^\w\s\']|_/g, "")
        // console.log(this_input);
        let country = "India";
        let state = "Maharashtra";
        let country_l = country.toLowerCase();
        let state_l = state.toLowerCase();
        if (this_input.includes(country_l) === true && this_input.includes(state_l) === false) {
            igst__.val("18%");
            cgst__.val('N/A');
            sgst__.val('N/A');
        }
        else if (this_input.includes(state_l) === true && this_input.includes(country_l) === true) {
            igst__.val("N/A");
            cgst__.val('9%');
            sgst__.val('9%');
        }
        else {
            igst__.val("N/A");
            cgst__.val('N/A');
            sgst__.val('N/A');
        }

    });
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });

    $(document.body).on('click','.add-row', function(e){
        e.preventDefault();
        let details_row = $(this).closest('tr');
        $("<tr class='details-row'>"+details_row.html()+"</tr>").insertAfter($(details_row));
        let sr_no = $(this).closest('tbody').find('tr.details-row');
        calcSr_no(sr_no);
    });


    async function calcSr_no(sr_no){
        let srNo = $(sr_no).find('.sr-no');
        for (let index = 0; index < srNo.length; index++) {
            let sr_no__ = index + 1;
            // console.warn(sr_no__);
            $(srNo[index]).text(sr_no__);
            
        }
    }
    
    $(document.body).on('click','.remove-row', function(e){
        e.preventDefault();
        let details_row_length = $(this).closest('tbody').find('tr.details-row').length;
        if(details_row_length > 1){
            let details_row = $(this).closest('tr');
            let sr_no = $(this).closest('tbody').find('tr.details-row');
            $(details_row).remove();
            calcSr_no(sr_no);
        }
        else{
            alert("This row can't be removed");
        }
    });


})(jQuery);