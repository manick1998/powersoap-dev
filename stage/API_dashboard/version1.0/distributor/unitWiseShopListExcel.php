<?php
include_once '../config/core_distributor.php';

if (!isset($_POST['v_id']) || $_POST['v_id'] != $verification_code) {
    http_response_code(403);
    exit;
}

include_once '../config/database.php';
include_once '../objects/retailer_distributor.php';

$unitToken = isset($_POST['unitToken']) ? $_POST['unitToken'] : '';
$distributorToken = isset($_POST['distributor_token']) ? $_POST['distributor_token'] : '';
$unitName = isset($_POST['unitName']) ? $_POST['unitName'] : '';

if ($unitToken == '' || $distributorToken == '') {
    http_response_code(400);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$retailer = new Retailer($db);
$retailer->unit_token = $unitToken;
$retailer->distributor_token = $distributorToken;
$stmt = $retailer->unitWiseRetailerList();

$fileName = 'unitWiseShopList_' . preg_replace('/[^A-Za-z0-9_-]/', '', $unitToken) . '_' . date('Ymd_His') . '.xls';

header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Pragma: no-cache');
header('Expires: 0');

function excelValue($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="11">SHOP LIST <?php echo excelValue($unitName); ?></th>
            </tr>
            <tr>
                <th colspan="11">DATE: <?php echo excelValue($indiaDateFormat); ?></th>
            </tr>
            <tr>
                <th>Sno</th>
                <th>Retailer Code</th>
                <th>Retailer Name</th>
                <th>Type</th>
                <th>Unit Name</th>
                <th>Mobile Number</th>
                <th>Contact Person</th>
                <th>Joining Date</th>
                <th>GST Number</th>
                <th>Paid Amount</th>
                <th>O/S Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slno = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $slno++;
                $joinDate = $row['join_date'] != '' ? date('d/m/Y', strtotime($row['join_date'])) : '';
            ?>
            <tr>
                <td><?php echo $slno; ?></td>
                <td><?php echo excelValue($row['retail_code']); ?></td>
                <td><?php echo excelValue($row['retailer_name']); ?></td>
                <td><?php echo excelValue($row['shop_type']); ?></td>
                <td><?php echo excelValue($row['unit_name']); ?></td>
                <td><?php echo excelValue($row['mobile_number']); ?></td>
                <td><?php echo excelValue($row['contact_person']); ?></td>
                <td><?php echo excelValue($joinDate); ?></td>
                <td><?php echo excelValue($row['license_number']); ?></td>
                <td><?php echo round($row['paid_amount']); ?></td>
                <td><?php echo round($row['outstanding_amount']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
