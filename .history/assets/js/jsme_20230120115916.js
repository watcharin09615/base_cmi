(function ($) {
    $( document ).ready(function() {

        $('.form-select').select2();
        $('#department').select2({
            
            
        });

        $( "#icd10" ).change(function() {
            $.ajax({
                type: "POST",
                url: "ajax_db.php",
                data: {},
                success: function(data){
                   
                }
            })
        });
        













    });

})(jQuery);