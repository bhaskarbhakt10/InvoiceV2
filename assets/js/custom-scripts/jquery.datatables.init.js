(function($){

    $('#invoices-tables').DataTable({
        language: { search: '', searchPlaceholder: "Search..." },
    });
    $('#invoices-tables_filter input[type="search"]').addClass('form-control form-field search-field');
})(jQuery)