<?php 

include 'condb.php';

var_dump($_POST);
exit;


   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code"); 



// echo $search;
$html = "";
while ($row = pg_fetch_array($fetchData)) {    
    $html .= "<tr>";
    $html .= "<th><input class=\"form-check-input\" type=\"checkbox\" id=\"$row['code']\"></th>";

    $data[] = array("id"=>$row['code'], "text"=>$row['code']." ".$row['description']);
}
// echo $html;
//var_dump($data);exit;
echo ($html);
?>