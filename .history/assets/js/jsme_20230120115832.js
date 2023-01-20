(function ($) {
    $( document ).ready(function() {

        $('.form-select').select2();
        $('#department').select2({
            
            $.ajax({
                type: "POST",
                url: "ajax_db.php",
                data: {},
                success: function(data){
                   
                }
            })
        });

        $( "#icd10" ).change(function() {
            alert( "Handler for .change() called." );
          });
        













    });

})(jQuery);