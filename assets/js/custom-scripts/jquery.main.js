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
    $('#input-city-check').on('change', function (e) {

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

    //detach gstin
    let gstin = $('#gstin>*');
    gstin.detach();
    $('body').on('change', '#address-country', function (e) {
        let this_value = $(this).val();
        gstin__check(this_value);
    });
    
    function gstin__check(this_value){
        let cmp_country = "India";
        if (this_value.toLowerCase() === cmp_country.toLowerCase()) {
            $('#gstin').append(gstin);
        }
        else {
            gstin.detach();

        }
    }



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
            gstin__check(country_l);
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

    $(document.body).on('click', '.add-row', function (e) {
        e.preventDefault();
        let details_row = $(this).closest('tr');
        $("<tr class='details-row'>" + details_row.html() + "</tr>").insertAfter($(details_row));
        let sr_no = $(this).closest('tbody').find('tr.details-row');
        calcSr_no(sr_no);
    });


    async function calcSr_no(sr_no) {
        let srNo = $(sr_no).find('.sr-no');
        for (let index = 0; index < srNo.length; index++) {
            let sr_no__ = index + 1;
            // console.warn(sr_no__);
            $(srNo[index]).text(sr_no__);

        }
    }

    $(document.body).on('click', '.remove-row', function (e) {
        e.preventDefault();
        let details_row_length = $(this).closest('tbody').find('tr.details-row').length;
        if (details_row_length > 1) {
            let details_row = $(this).closest('tr');
            let sr_no = $(this).closest('tbody').find('tr.details-row');
            $(details_row).remove();
            calcSr_no(sr_no);
            $('[name="price"]').trigger('blur');
            $('[name="subtotal"]').trigger('change');
        }
        else {
            alert("This row can't be removed");
        }
    });

    $(document.body).on('blur', '[name="price"]', function (e) {
        e.preventDefault();
        let this_value = $(this).val();
        const sum_price = sub_total();
        $('#subtotal').val(sum_price);
        $('[name="subtotal"]').trigger('change');
        $('[name="discount"]').trigger('blur');
    });
    
    $(document.body).on('change', '[name="subtotal"]', function (e) {
        let sum_price = $('#subtotal').val();
        let igst ;
        let total;
        if($('#IGST').length !== 0){
            igst = $('#IGST').val();
            calcIGST(igst, sum_price);
            total = calcGst(igst,sum_price);
        }
        else if($('#SGST').length !==0 && $('#CGST').length !== 0 ){
            igst =  parseInt($('#SGST').val()) + parseInt($('#CGST').val());
            total = calcGst(igst,sum_price);
            let sgst = parseInt($('#SGST').val()) ;
            calcCGST(sgst , sum_price)
            let cgst = parseInt($('#CGST').val());
            calcSGST(cgst , sum_price);
        }
        $('#total').val(total);
    });

    $(document.body).on('blur', '[name="discount"]', function (e) {
        let discount_price =  parseFloat($(this).val());
        const discounted_price = discount(discount_price);
        $('#subtotal').val(discounted_price);
    });

    function sub_total() {
        let price_array = new Array(0);
        let price = $('[name="price"]').toArray();
        for (let index = 0; index < price.length; index++) {
            let value = $(price[index]).val();
            if (value.includes(',') === true) {
                value = value.replaceAll(',', '');
            }
            // if(value ==='' || value === null || value === undefined){
            //     value = 0;
            // }
            price_array.push(parseFloat(value));
        }
        let sum_price = price_array.reduce((a, b) => a + b, 0);
        return sum_price;
    }

    function calcGst(igst, sum_price){
        let this_igst = (parseFloat(sum_price)*(parseInt(igst)) / 100);
        return parseFloat(sum_price) + this_igst;
    }
    function calcCGST(igst, sum_price){
        let this_cgst = (parseFloat(sum_price)*(parseInt(igst)) / 100);
        $('#CGST-value').val(this_cgst);
    }
    function calcSGST(igst, sum_price){
        let this_sgst = (parseFloat(sum_price)*(parseInt(igst)) / 100);
        $('#SGST-value').val(this_sgst);
    }
    function calcIGST(igst, sum_price){
        let this_igst = (parseFloat(sum_price)*(parseInt(igst)) / 100);
        $('#IGST-value').val(this_igst);
    }

    function discount(discount_price){
        let subtotal = parseFloat($('#subtotal').val());
        return (subtotal - discount_price);

    }




})(jQuery);