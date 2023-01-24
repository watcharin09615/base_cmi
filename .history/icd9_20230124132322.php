<?php 

include 'condb.php';

$department = $_POST["department"];
$icd10 = $_POST["icd10"];

$query = "select icd9 from base where id_department = '$department' and icd10 = '$icd10'  " or die("Error:" . mysqli_error($con));
$result = mysqli_query($con, $query);


$base = array();
$num = mysqli_num_rows ($result);
echo $num;
if ($num > 0) {
    
    while($row = mysqli_fetch_assoc($result)){
        $base[] = $row["icd9"];
    };
}

var_dump($base);

exit;
   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code"); 


$data = array();
// echo $search;
$html = "";


while ($row = pg_fetch_array($fetchData)) {    
    $html .= "<tr>\n";
    $html .= "  <td>\n";
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"checkbox_icd9\" value=\"".$row['code']."\">\n";
    $html .= "  </td>\n";
    $html .= "  <td>".$row['code']."</td>\n";
    $html .= "  <td>".$row['description']."</td>\n";
    $html .= "</tr>\n";
}


// echo $html;

// echo ($html);
?>