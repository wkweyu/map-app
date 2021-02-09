<?php

function productCode($group_name){
$groupCode = '';
$productId ="001";
$y = explode(' ',$group_name);
foreach($y AS $k){
$groupCode .= strtoupper(substr($k,0,1));
}
return $groupCode.$productId;
};

function pre_r($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    
}
?>
