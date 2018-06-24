(function( $ ) {
    'use strict';
    $(document).ready(function() {
        $('.whtp-select-single, .whtp-select-multiple').select2();

        $("#hits-filter-text").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#hits-table tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#ip-filter-text").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#ips-table tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });   

})( jQuery );