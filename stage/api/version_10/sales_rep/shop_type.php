<?php
include "../../config.php";
$array = array();
$shop_type = mysqli_query($link,"SELECT `token`,`name` FROM `shop__type`");
	while($type_row = mysqli_fetch_array($shop_type)){
		$obj = new stdClass();
		 $obj->shop_code = $type_row['token'];
		 $obj->shop_type_name = $type_row['name'];
		 array_push($array, $obj);
	}


	$obj1 = new stdClass;
if($shop_type){
    $obj1->status_code=200; 
    $obj1->message='Product found';
    $obj1->title='Success';
    $obj1->data = $array;
    
} else {
    $obj1->status_code=400; 
    $obj1->message='Product not found';
    $obj1->title='Success';
    
}
echo json_encode($obj1);

?>