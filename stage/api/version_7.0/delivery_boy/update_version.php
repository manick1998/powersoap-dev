<?php

header('Content-Type: application/json');
$file = file_get_contents('php://input');
$json = json_decode($file);
$device=$json->device;
$app_version=$json->version;
$obj=new stdClass();

$php_version ="1.0";
      if($php_version == $app_version){
        $obj->isForceUpdate=false;
        
    }else{    
        $obj->isForceUpdate=true;
    }
        $obj->app_link="https://play.google.com/store/apps/details?id=com.app.powersoapsdistributordelivery";
        $obj->title="PowerSoap";
        $obj->description="Kindly update PowerSoap, We've upgraded your PowerSoap experience with this update.";
        $obj->button_title="Update";



    $obj1 = new stdClass;

    $obj1->status_code=200; 
    $obj1->message='delivered status';
    $obj1->data=$obj;




echo json_encode($obj1);  

?>