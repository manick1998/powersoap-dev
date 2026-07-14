<?php
include "API_dashboard/version1.0/config.php";

$obj = new stdClass();
$selectScheme = mysqli_query($link, "SELECT `id`, `product_token`, `start_date`, `end_date`, `is_scheme` FROM `products__scheme`");
    if(mysqli_num_rows($selectScheme) > 0){
        while($row = mysqli_fetch_assoc($selectScheme)){
            $currentDate=date('Y-m-d', strtotime($currentDate));
            $schemeEndDate=date('Y-m-d', strtotime($row["end_date"]));
            if ($currentDate > $schemeEndDate){
                $updateScheme = "UPDATE `products__scheme` SET `is_scheme`='0' WHERE `product_token`=".$row["product_token"]." AND `is_scheme`='1'";
                if(mysqli_query($link, $updateScheme)){
                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "Updated Product Scheme";
                }
            }
        }
    }else{
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "No Product Scheme List Available";
    }
?>