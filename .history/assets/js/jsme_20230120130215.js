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

        $("#icd10").change(function() {
            console.log(this.value);
            $.ajax({
                type: "POST",
                url: "assets/functionajax/icd10.php",
                data: {data},
                success: function(data){
                    $("#icd10").val(data);
                   
                }
            })
        });
        













    });

})(jQuery);