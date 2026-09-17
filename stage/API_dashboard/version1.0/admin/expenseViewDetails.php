<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../config/core_distributor.php';

$input_data = json_decode(file_get_contents("php://input"));
$obj = new stdClass();

if (!isset($input_data->token) || !isset($input_data->date)) {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Invalid request";
    echo json_encode($obj);
    exit;
}

$token = mysqli_real_escape_string($link, trim($input_data->token));
$date = mysqli_real_escape_string($link, trim($input_data->date));

$result = mysqli_query($link, "SELECT
    employees.name AS employee_name,
    sales_rep__expense__details.token AS detail_token,
    allowance.allowane_type AS category_module,
    sales_rep__expense__details.amount,
    sales_rep__expense__details.image
FROM
    `sales_rep__expense__details`
INNER JOIN employees ON sales_rep__expense__details.sales_rep__token = employees.token
INNER JOIN allowance ON sales_rep__expense__details.category_token = allowance.token
WHERE
    sales_rep__expense__details.status = '1' AND sales_rep__expense__details.sales_rep__token = '$token' AND DATE(sales_rep__expense__details.date_time) = '$date'
ORDER BY sales_rep__expense__details.date_time ASC");

$details = [];
$name = '';
while ($row = mysqli_fetch_assoc($result)) {
    if ($name === '') {
        $name = $row['employee_name'] ?? '';
    }

    $images = array_filter(array_map(function ($image) {
        return trim((string) $image);
    }, explode(",", (string) ($row['image'] ?? ''))), function ($image) {
        return $image !== '';
    });

    if (empty($images)) {
        $images = ['assets/upload.png'];
    }

    $details[] = [
        'detail_token' => $row['detail_token'] ?? '',
        'category_module' => $row['category_module'] ?? '',
        'amount' => $row['amount'] ?? 0,
        'image' => array_values($images)
    ];
}

if (!empty($details)) {
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "List Successfully";
    $obj->data = [
        'name' => $name,
        'items' => $details
    ];
} else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "No expense details found";
    $obj->data = ['name' => '', 'items' => []];
}

echo json_encode($obj);
?>