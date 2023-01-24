<?php 

include 'condb.php';

var_dump($_POST);
exit;


   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code limit 20"); 



// echo $search;
$html = "";
while ($row = pg_fetch_array($fetchData)) {    
    print_r("i");
    $html .= "<tr>";
    $html .= "  <td>";
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"".$row['code']."\">";
    $html .= "  </td>";
    $html .= "  <td>".$row['code']."</td>";
    $html .= "  <td>".$row['description']."</td>";
    $html .= "</tr>";
}
// echo $html;

echo ($html);
?>