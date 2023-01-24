<?php 

include 'condb.php';

var_dump($_POST);
exit;


   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code"); 



// echo $search;
$html = "";
$html .= "<option value=\"\"></option>\n";

//var_dump($fetchData);exit;

while ($row = pg_fetch_array($fetchData)) {    
    $html .=  '<option value="'.$row["code"].'">'.$row["code"].' '.$row["description"] .'</option>'."\n";

    $data[] = array("id"=>$row['code'], "text"=>$row['code']." ".$row['description']);
}
// echo $html;
//var_dump($data);exit;
echo ($html);
?>