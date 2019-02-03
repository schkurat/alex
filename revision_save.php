<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("function.php");

$group_product = $_GET['group_product'];
//$time_rev=$_GET['time1'];
//$dt_rev=date_bd($_GET['dt_rev']).' '.$time_rev;

$sql = "SELECT balance.* FROM balance,product WHERE `balance`.id_product=`product`.ID AND `product`.GROUP='$group_product'";
$atu = mysql_query($sql);
while($aut = mysql_fetch_array($atu)){
    $product = 0;
    $kl = 0;
    $product = $aut["id_product"];
    $kl = $aut["rev"];
    $sm = $aut["sm"];

    $ath1 = mysql_query("INSERT INTO primary_balance (`dt`,`id_product`,`kl`,`sm`) VALUES(NOW(),'$product','$kl','$sm');");
    if(!$ath1){echo "Запис не внесений до БД";} 
}
echo 'Залишки успішно збережені.';		
?>