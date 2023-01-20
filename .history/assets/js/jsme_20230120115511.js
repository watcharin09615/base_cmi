(function() {
    $( document ).ready(function() {

        $('.form-select').select2();
        $('#department').select2({
            $.ajax({
                type: "POST",
                url: "ajax_db.php",
                data: {id:id_province,function:'provinces'},
                success: function(data){
                    $('#amphures').html(data); 
                    $('#districts').html(' '); 
                    $('#districts').val(' ');  
                    $('#zip_code').val(' '); 
                }
            })
        });

        $( "#icd10" ).change(function() {
            alert( "Handler for .change() called." );
          });
        













    });

})();