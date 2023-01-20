<?php 

include 'condb.php';
// if (!empty($_POST["searchTerm"])) {
//     var_dump($_POST);
//     print_r($_POST["searchTerm"]);


// }else{
  
// }
if(!empty($_POST["searchTerm"])){ 

    $search = $_POST['searchTerm'];   
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 where code like '%".$search."%' or description like '%".$search."%' limit 10");
    
}else{ 
   
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 order by code limit 10"); 
} 

$data = array();
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
echo json_encode($data);
?>