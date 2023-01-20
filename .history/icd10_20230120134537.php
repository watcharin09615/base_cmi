<?php 

include 'condb.php';


if(!isset($_POST['searchTerm'])){ 
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 order by code limit 10");
}else{ 
    $search = $_POST['searchTerm'];   
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 where code like '%".$search."%' or description like '%".$search."%' limit 10");
} 

$data = array();
while ($row = pg_fetch_array($fetchData)) {    
    $data[] = array("id"=>$row['code'], "text"=>$row['description']);
}
echo json_encode($data);
?>