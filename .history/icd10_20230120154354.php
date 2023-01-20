<?php 

include 'condb.php';
if (!empty($_POST["searchTerm"])) {
    var_dump($_POST);
    print_r($_POST["searchTerm"]);

    print_r('00');
}else{
    print_r('11');
}
if(!empty($_POST["searchTerm"])){ 
    print_r('22');
    $search = $_POST['searchTerm'];   
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 where code like '%".$search."%' or description like '%".$search."%' limit 10");
    print_r('44');
    
}else{ 
    print_r('33');
    $fetchData = pg_query($conimed,"select code,description from fix_icd10 order by code limit 10");
    print_r('44');
} 
// echo $search;
$html .= "<option value=\"\"></option>";


while ($row = pg_fetch_array($fetchData)) {    
    $html .= " <option value=\"".$row["code"]."\">".$row["code"]." ".$row["description"] ."</option>\n";
}
echo $html;
?>