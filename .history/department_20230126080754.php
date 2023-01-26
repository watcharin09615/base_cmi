<?php 

include 'condb.php';
// if (!empty($_POST["searchTerm"])) {
//     var_dump($_POST);
//     print_r($_POST["searchTerm"]);


// }else{
  
// }


   
$fetchData = mysqli_query($con,"select department_name from department order by id_department"); 
 

$data = array();
// echo $search;


//var_dump($fetchData);exit;

while ($row = mysqli_fetch_array($fetchData)) {    

    $data[] = array("id"=>$row['department_name'], "text"=>$row['department_name']);
}
// echo $html;
//var_dump($data);exit;
echo json_encode($data);
?>