<?php 

include 'condb.php';



   
$fetchData = pg_query($conimed,"select code,description from fix_icd9"); 



// echo $search;
$html = "";
while ($row = pg_fetch_array($fetchData)) {    
    $html .= "<tr>\n";
    $html .= "  <td>\n";
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"".$row['code']."\">\n";
    $html .= "  </td>\n";
    $html .= "  <td>".$row['code']."</td>\n";
    $html .= "  <td>".$row['description']."</td>\n";
    $html .= "</tr>\n";
}
// echo $html;

echo ($html);
?>