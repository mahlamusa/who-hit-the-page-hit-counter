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

        $('.confirm-delete').click( function(e){
            if ( ! confirm('Are you sure you want to delete this?') ) {
                e.preventDefault();   
            }
        });

        $('.confirm-ignore').click( function(e){
            if ( ! confirm('Are you sure you want to ignore this IP? Ignored IPs will not be counted') ) {
                e.preventDefault();   
            }
        });

        $('.confirm-reset').click( function(e){
            if ( ! confirm('Are you sure you want to reset this. If you click OK the count will be set to 0.') ) {
                e.preventDefault();   
            }
        });

        $('.confirm-discount').click( function(e){
            if ( ! confirm('Are you sure you want to discount this page.') ) {
                e.preventDefault();   
            }
        });
    });   

})( jQuery );