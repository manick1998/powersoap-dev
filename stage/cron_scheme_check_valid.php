<?php
// include "API_dashboard/version1.0/config.php";

// $obj = new stdClass();
// $selectScheme = mysqli_query($link, "SELECT `id`, `product_token`, `start_date`, `end_date`, `is_scheme` FROM `products__scheme`");
//     if(mysqli_num_rows($selectScheme) > 0){
//         while($row = mysqli_fetch_assoc($selectScheme)){
//             $currentDate=date('Y-m-d', strtotime($currentDate));
//             $schemeEndDate=date('Y-m-d', strtotime($row["end_date"]));
//             if ($currentDate > $schemeEndDate){
//                 $updateScheme = "UPDATE `products__scheme` SET `is_scheme`='0' WHERE `product_token`=".$row["product_token"]." AND `is_scheme`='1'";
//                 if(mysqli_query($link, $updateScheme)){
//                     $obj->status_code = 200;
//                     $obj->header = "Success";
//                     $obj->message = "Updated Product Scheme";
//                 }
//             }
//         }
//     }else{
//             $obj->status_code = 400;
//             $obj->header = "Oops";
//             $obj->message = "No Product Scheme List Available";
//     }


include "API_dashboard/version1.0/config.php";

$obj = new stdClass();

// Get the current date in Y-m-d format
$currentDate = date('Y-m-d');

// Single query: Turn off 'is_scheme' for ALL products where the end date has passed today
$updateQuery = "UPDATE `products__scheme` 
                SET `is_scheme` = '0' 
                WHERE `end_date` < '$currentDate' 
                AND `is_scheme` = '1'";

if (mysqli_query($link, $updateQuery)) {
    // Check if any rows were actually changed
    if (mysqli_affected_rows($link) > 0) {
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Updated expired product schemes.";
    } else {
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "No schemes needed updating today.";
    }
} else {
    $obj->status_code = 500;
    $obj->header = "Error";
    $obj->message = "Database query failed: " . mysqli_error($link);
}

// Optional: Echo the JSON response for your API
echo json_encode($obj);

?>