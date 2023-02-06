<?php 

include 'condb.php';

$department = $_POST["department"];
$icd10 = $_POST["icd10"];

$query = "select icd9 from base where active = '1' and department = '$department' and icd10 = '$icd10'  " or die("Error:" . mysqli_error($con));
$result = mysqli_query($con, $query);


$base = array();
$num = mysqli_num_rows ($result);

if ($num > 0) {
    
    while($row = mysqli_fetch_assoc($result)){
        $base[] = $row["icd9"];
    };
}


   
$fetchData = pg_query($conimed,"select replace(code,'.','')as\"code\",description from fix_icd9 order by code"); 


$data = array();
// echo $search;

$sqlnon = "select department from base where active = '1' and icd9 = '' and icd10 = '$icd10'  " or die("Error:" . mysqli_error($con));
$resultnon = mysqli_query($con, $sqlnon);
$numnon = mysqli_num_rows ($resultnon);

$html = "";

$html .= "<tr>\n";
$html .= "  <td>\n";


if (in_array("",$base)) {
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"checkbox_icd9\" value=\"\" checked>\n";

}else {
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"checkbox_icd9\" value=\"\" >\n";
}
$html .= "  </td>\n";
$html .= "  <td>ไม่ระบุ</td>\n";
$html .= "  <td>ไม่ระบุ</td>\n";
$html .= "  <td>";

    if ($numnon > 0) {
        echo "1";
        
        while($row2 = mysqli_fetch_assoc($resultnon)){

            $html .= $row2["dapartment"]." , ";
        };
    }else {
        $html .= "ไม่มีแผนกร่วม";
    }
    
$html .= "</td>\n";
$html .= "</tr>\n";


while ($row = pg_fetch_array($fetchData)) {    

    $sqldeaprtment = "select department from base where active = '1' and icd9 = '".$row['code']."' and icd10 = '$icd10'  " or die("Error:" . mysqli_error($con));
    $resultdepart = mysqli_query($con, $sqldeaprtment);
    $numdepart = mysqli_num_rows ($resultdepart);

    // if ($numdepart > 0) {
        
    //     while($row = mysqli_fetch_assoc($result)){
    //         $department[] = $row["department"];
    //     };
    // }


    $html .= "<tr>\n";
    $html .= "  <td>\n";

    if (in_array($row['code'],$base)) {
        $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"checkbox_icd9\" value=\"".$row['code']."\" checked>\n";

    }else {
        $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"checkbox_icd9\" value=\"".$row['code']."\" >\n";
    }

    
    $html .= "  </td>\n";
    $html .= "  <td>".$row['code']."</td>\n";
    $html .= "  <td>".$row['description']."</td>\n";
    $html .= "  <td>";

    if ($numdepart > 0) {
        
        while($row1 = mysqli_fetch_assoc($result)){
            $html .= $row1["dapartment"]." , ";
        };
    }else {
        $html .= "ไม่มีแผนกร่วม";
    }
    
    $html .= "</td>\n";
    $html .= "</tr>\n";
}
pg_close($conimed);
mysqli_close($con);


echo $html;

// echo ($html);
?>