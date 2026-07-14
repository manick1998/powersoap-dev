<?php

include "../../config.php";
$json_input=getInputs();
$sales_rep_token = $json_input->sales_rep_token;
$obj = new stdClass;


$data = array();





//Allowance_list
$sql1=mysqli_query($link,"SELECT `token`,`allowane_type` FROM `allowance`");
while($row = mysqli_fetch_array($sql1)) {
    $allowance_obj = new stdClass;
    $allowance_obj->token = $row["token"];
    $allowance_obj->name = $row["allowane_type"];
    array_push($data,$allowance_obj);
}




if($data) {
        $obj->status_code=200; 
        $obj->message='Data show successfully';
        $obj->title='Success';
        $obj->data=$data;
    }
    else {
        $obj->status_code=400; 
        $obj->message='error';
        $obj->title='error';
    }


echo json_encode($obj);

?>