<?php 
    include 'condb.php';  
    $department = $_POST["department"];
    $icd10 = $_POST["icd10"];
    $icd9 = $_POST["icd9"];
    $for = $_POST["for"];

    $check = "SELECT * FROM bmi WHERE id_department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
    $result = mysqli_query($con, $check) or die(mysqli_error($con));
    $num=mysqli_num_rows($result);


    if ($for == 1) {
        if ($num == 0) {
            $sql = "INSERT INTO `bmi`(`id_department`, `icd9`, `icd10`) VALUES ('$department','$icd9','$icd10')";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
            mysqli_close($con);
        }else{
            echo 0;
        }
    }elseif ($for == 0) {
       if ($num > 0) {
        $sql = "DELETE FROM bmi WHERE id_department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_close($con);
       }else{
            echo 0;
       }
    }




?>