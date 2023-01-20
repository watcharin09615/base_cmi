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
              url: "assets/functionajax/icd10.php",/* Url ที่ต้องการส่งค่าไปประมวลผลการค้นข้อมูล*/
              dataType: 'json',
              delay: 250,
              data: {data:this.value},
              success: function(data){
                   
                console.log(data);

              }
            },
          });

        // $("#icd10").select2(function() {
        //     console.log(this.value);
        //     $.ajax({
        //         type: "POST",
        //         url: "assets/functionajax/icd10.php",
        //         data: {data},
        //         success: function(data){
        //             $("#icd10").val(data);
                   
        //         }
        //     })
        });
        













  

})(jQuery);