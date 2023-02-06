<?php 
    include 'condb.php';  
    $department = $_POST["department"];
    $icd10 = $_POST["icd10"];
    $icd9 = $_POST["icd9"];
    $for = $_POST["for"];

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    $ip = get_client_ip();
   

    $check = "SELECT * FROM base WHERE active = '1'and department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
    $result = mysqli_query($con, $check) or die(mysqli_error($con));
   
    $num=mysqli_num_rows($result);


    if ($for == "1") {
        if ($num == 0) {

            $sql1 = "INSERT INTO base(department, icd9, icd10, find) VALUES ('$department','$icd9','$icd10','$icd10|$icd9')";
            // $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1 " . mysqli_error($con));
            
            if ($con->query($sql1) === TRUE) {
                $last_id = $con->insert_id;
                $sql2 = "INSERT INTO history(id_base, ip, transition) VALUES ('$last_id','$ip','1')";
                $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2 " . mysqli_error($con));
                mysqli_close($con);
                echo 1;
            } else {
            echo "Error: " . $sql1 . "<br>" . $con->error;
            mysqli_close($con);
            }
        }else{
            echo 0;
        }
    }elseif ($for == "0") {
       if ($num > 0) {
        $sql1 = "UPDATE base SET active = '0' WHERE active = '1' and department = '$department' and icd10 = '$icd10' and icd9 = '$icd9'";
        // $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1 " . mysqli_error($con));
        if ($con->query($sql1) === TRUE) {
            $last_id = $result['id_base'];
            $sql2 = "INSERT INTO history(id_base, ip, transition) VALUES ('$last_id','$ip','0')";
            $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2 " . mysqli_error($con));
            mysqli_close($con);
            echo 1;
        } else {
        echo "Error: " . $sql1 . "<br>" . $con->error;
        mysqli_close($con);
        echo 0;
        }
       }else{
            echo 0;
       }
    }else {
        echo 0;
    }

?>