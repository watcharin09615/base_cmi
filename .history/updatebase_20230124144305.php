<?php 
    include 'condb.php';  
    var_dump($_POST);
    $department = $_POST["department"];
    $icd10 = $_POST["icd10"];
    $icd9 = $_POST["icd9"];
    $for = $_POST["for"];
    $check = "SELECT * FROM base WHERE icd10=icd10 and department: department and icd9: icd9,";




?>