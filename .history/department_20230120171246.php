<?php 

include 'condb.php';
// if (!empty($_POST["searchTerm"])) {
//     var_dump($_POST);
//     print_r($_POST["searchTerm"]);


// }else{
  
// }


   
$fetchData = mysqli_query($con,"select code,description from fix_icd10 order by code limit 10"); 
 

$data = array();
// echo $search;
$html = "";
$html .= "<option value=\"\"></option>\n";

//var_dump($fetchData);exit;

while ($row = mysqli_fetch_array($fetchData)) {    
    $html .=  '<option value="'.$row["code"].'">'.$row["code"].' '.$row["description"] .'</option>'."\n";

    $data[] = array("id"=>$row['code'], "text"=>$row['code']." ".$row['description']);
}
// echo $html;
//var_dump($data);exit;
echo json_encode($data);
?>