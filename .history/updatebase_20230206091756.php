<?php 
    include 'condb.php';  
    $department = $_POST["department"];
    $icd10 = $_POST["icd10"];
    $icd9 = $_POST["icd9"];
    $for = $_POST["for"];
   

    $check = "SELECT * FROM base WHERE active = '1'and department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
    $result = mysqli_query($con, $check) or die(mysqli_error($con));
   
    $num=mysqli_num_rows($result);


    if ($for == "1") {
        if ($num == 0) {

            $sql1 = "INSERT INTO base(department, icd9, icd10, find) VALUES ('$department','$icd9','$icd10','$icd10|$icd9')";
            $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1 " . mysqli_error($con));
            // mysqli_close($con);
            if ($con->query($sql1) === TRUE) {
                $last_id = $con->insert_id;
                echo "New record created successfully. Last inserted ID is: " . $last_id;
            } else {
            echo "Error: " . $sql1 . "<br>" . $con->error;
            }
        }else{
            echo 0;
        }
    }elseif ($for == "0") {
       if ($num > 0) {
        $sql1 = "UPDATE base SET active = '0' WHERE active = '1' and department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1 " . mysqli_error($con));
        mysqli_close($con);
        echo 1;
       }else{
            echo 0;
       }
    }else {
        echo 0;
    }

?>