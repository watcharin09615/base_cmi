<?php 
    include 'condb.php';  
    var_dump($_POST);
    $department = $_POST["department"];
    $icd10 = $_POST["icd10"];
    $icd9 = $_POST["icd9"];
    $for = $_POST["for"];

    $check = "SELECT username FROM user WHERE username = '$a_user'";
    $result1 = mysqli_query($con, $check) or die(mysqli_error($con));
    $num=mysqli_num_rows($result1);


    if ($for == 1) {
        
    }elseif ($for == 0) {
        # code...
    }




?>