<?php 

include 'condb.php';

$department = $_POST["department"];
$icd10 = $_POST["icd10"];


$sql = mysqli_query($con,"select id_department,department_name from department where id_department = $department and icd10 = $icd10"); 

print_r(sql)

$base = array();



   
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

echo ($html);
?>