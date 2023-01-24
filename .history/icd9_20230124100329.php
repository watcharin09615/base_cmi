<?php 

include 'condb.php';

var_dump($_POST);
exit;


   
$fetchData = pg_query($conimed,"select code,description from fix_icd9 order by code"); 



// echo $search;
$html = "";
while ($row = pg_fetch_array($fetchData)) {    
    $html .= "<tr>";
    $html .= "<th scope=\"row\">";
    $html .= "<input class=\"form-check-input\" type=\"checkbox\" id=\"gridCheck1\">";
    $html .= "</th>";
    $html .= "<td>'$row['code']'</td>";
    $html .= "<td><a href="#" class="text-primary">At praesentium minu</a></td>"
        
    </tr>
    $data[] = array("id"=>$row['code'], "text"=>$row['code']." ".$row['description']);
}
// echo $html;
//var_dump($data);exit;
echo ($html);
?>