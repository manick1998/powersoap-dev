<?php
include "../../config.php";

echo genToken("token","orders");
function genToken1($col,$table){
    $gen_token1 = mysqli_query($GLOBALS['link'],"SELECT ROUND((RAND() * (99999999-10000000))+10000000) AS `random_num` FROM `$table` WHERE 'random_num' NOT IN (SELECT `$col` FROM `$table`) LIMIT 1");
    // echo " SELECT ROUND((RAND() * (99999999-10000000))+10000000) AS `random_num` FROM `$table` WHERE 'random_num' NOT IN (SELECT `$col` FROM `$table`) LIMIT 1";
    $token_number = mysqli_fetch_array($gen_token1);
    if($token_number == ''){
     return rand(10000000,99999999);
    }else{
    return $token_number['random_num'];
    }
    
    
}
?>