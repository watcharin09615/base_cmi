
(function ($) {
$(".form-select").change(function() {
    var icd10 = document.getElementById("icd10");
    var department = document.getElementById("department");
    console.log(icd10.value);
    console.log(department.value);
    $.ajax({
      type:"POST",
      url:"icd9.php",
      data:{
        icd10:icd10,
        department:department
      },
      success:function(data){
        // $("#table_icd9").html(data);
        // $("#table_icd9").show();
      }
    })
    
  });

})(jQuery);