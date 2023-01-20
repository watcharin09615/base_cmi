(function ($) {
    $( document ).ready(function() {

        $('.form-select').select2();
        // $('#department').select2( function (){
        //     $.ajax({
        //         type: "POST",
        //         url: "ajax_db.php",
        //         success: function(data){
                   
        //         }
        //     })
            
        // });


        $("#icd10").select2({
    
            ajax: { 
                url: "getData.php",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        })
         

})(jQuery);