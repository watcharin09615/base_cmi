<?php 

include 'condb.php';



   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code"); 



// echo $search;
$html = "";

$html .= "<thead>";
$html .= " <tr>";
$html .= "<th scope=\"col\">#</th>";
$html .= "<th scope=\"col\">Code</th>";
$html .= "<th scope=\"col\">Department</th>";
$html .= "</tr>";
$html .= "</thead>";
$html .= "<tbody>";
while ($row = pg_fetch_array($fetchData)) {    
    $html .= "<tr>\n";
    $html .= "  <td>\n";
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"".$row['code']."\">\n";
    $html .= "  </td>\n";
    $html .= "  <td>".$row['code']."</td>\n";
    $html .= "  <td>".$row['description']."</td>\n";
    $html .= "</tr>\n";
}

$html .= "</tbody>";
// echo $html;

echo ($html);
?>