<?php 

include 'condb.php';



   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code"); 



// echo $search;
$html = "";
while ($row = pg_fetch_array($fetchData)) {    
    $html .= "<tr>\n";
    $html .= "  <th>\n";
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" id=\"".$row['code']."\">\n";
    $html .= "  </th>\n";
    $html .= "  <td>".$row['code']."</td>\n";
    $html .= "  <td>".$row['description']."</td>\n";
    $html .= "</tr>\n";
}
// echo $html;

echo ($html);
?>