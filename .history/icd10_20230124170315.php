<?php 

include 'condb.php';
// if (!empty($_POST["searchTerm"])) {
//     var_dump($_POST);
//     print_r($_POST["searchTerm"]);


// }else{
  
// }
if(!empty($_POST["searchTerm"])){ 

    $search = $_POST['searchTerm'];   
    $fetchData = pg_query($conimed,"select replace(code,'.','')as\"code\",description from fix_icd10 where replace(lower(code),'.','') like  lower('%".$search."%')  or lower(description) like lower('%".$search."%') limit 10");
    
}else{ 
   
    $fetchData = pg_query($conimed,"select replace(code,'.','')as\"code\",description from fix_icd10 order by code limit 10"); 
} 

$data = array();
// echo $search;


//var_dump($fetchData);exit;

while ($row = pg_fetch_array($fetchData)) {    

    $data[] = array("id"=>$row['code'], "text"=>$row['code']." ".$row['description']);
}
// echo $html;
//var_dump($data);exit;
echo json_encode($data);
?>