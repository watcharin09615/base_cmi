<?php 
    include 'condb.php';  
    var_dump($_POST);
    $department = $_POST["department"];
    $icd10 = $_POST["icd10"];
    $icd9 = $_POST["icd9"];
    $for = $_POST["for"];

    $check = "SELECT * FROM bmi WHERE id_department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
    $result = mysqli_query($con, $check) or die(mysqli_error($con));
    $num=mysqli_num_rows($result);


    if ($for == 1) {
        
    }elseif ($for == 0) {
        # code...
    }




?>