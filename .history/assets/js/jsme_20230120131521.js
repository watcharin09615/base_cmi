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
              data: function (params) {
                return {
                  q: params.term, // ค่าที่ส่งไป
                  page: params.page
                };

              },
              processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                  results: data.items,
                  pagination: {
                    more: (params.page * 30) < data.total_count
                  }
                };
              },
              cache: true
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