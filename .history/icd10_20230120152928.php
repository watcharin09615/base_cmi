<?php 

include 'condb.php';
if (!empty($_post["searchTerm"])) {
var_dump($_POST);exit;

    echo "00";
}
if(!isset($_POST['searchTerm'])){ 
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 order by code limit 10");
}else{ 
    $search = $_POST['searchTerm'];   
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 where code like '%".$search."%' or description like '%".$search."%' limit 10");
} 
// echo $search;
$html .= "<option value=\"\"></option>";
$data = array();

while ($row = pg_fetch_array($fetchData)) {    
    $html .= " <option value=\"".$row["code"]."\">".$row["code"]." ".$row["description"] ."</option>";
    $data[] = array("id"=>$row['code'], "text"=>$row['description']);
}
echo $html;
?>