<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include("function.php");

$group_product = $_GET['group_product'];
//смотрим дату последней ревизии
$sql = "SELECT primary_balance.dt FROM primary_balance,product 
    WHERE primary_balance.id_product=product.ID AND product.GROUP='$group_product' ORDER BY primary_balance.dt DESC LIMIT 1";
$atu = mysql_query($sql);
while($aut = mysql_fetch_array($atu)){
    $dt_n = $aut["dt"];
}
mysql_free_result($atu);

//$dt_k=date_bd($_GET["kpr"]).' '.$time2;

//if(isset($_GET['time1'])){
//    $time1 = $_GET['time1'];
//    if(isset($_GET['time2'])){
//        $time2 = $_GET['time2'];
//    }
//}
//$dt_n=date_bd($_GET["npr"]).' '.$time1;
//$dt_k=date_bd($_GET["kpr"]).' '.$time2;
   
//$ath=mysql_query("TRUNCATE TABLE  `balance`");
$ath = mysql_query("DELETE `balance` FROM `balance`,`product` WHERE `balance`.id_product=`product`.ID AND `product`.GROUP='$group_product'");


//вставка начальных остатков
$sql = "SELECT primary_balance.*,product.SKOD FROM primary_balance,product 
    WHERE primary_balance.dt>='$dt_n' AND primary_balance.dt<=NOW() 
        AND primary_balance.id_product=product.ID AND product.GROUP='$group_product'";
//echo $sql;
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
    $skod = $aut["SKOD"];
    $id_product = $aut["id_product"];
    $kl = $aut["kl"];
    $sm = $aut["sm"];
    $ath = mysql_query("INSERT INTO `balance` (`skod`,`id_product`,`kl`,`sm`) VALUES('$skod','$id_product','$kl','$sm')");
}
mysql_free_result($atu);

//вставка с текущего оборота
$sql="SELECT store.* FROM store,product WHERE store.DT>='$dt_n' AND store.DT<=NOW() AND store.DL='1' "
        . "AND store.PRODUCT=product.ID AND product.GROUP='$group_product'";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
    $skod = $aut["SKOD"];
    $id_product = $aut["PRODUCT"];
    $kl = $aut["NUMBER"];
    $smp = $aut["SUM"];
    $smpr = $kl*$smp;
    $status = $aut["STATUS"];

    $sql1 = "SELECT `id_product` FROM `balance` WHERE `id_product`='$id_product'"; 
    $atu1 = mysql_query($sql1);
    $num_rows = mysql_num_rows($atu1);
    if($num_rows != 0){
        if($status == 1){
            $ath = mysql_query("UPDATE `balance` SET `KL`=`KL` + $kl,`sm`=IF(sm>'$smp',sm,'$smp') WHERE id_product='$id_product'");
        }
        if($status == 4){
            $ath = mysql_query("UPDATE `balance` SET `KL`=`KL` + $kl,`sm`=IF(sm>'$smp',sm,'$smp') WHERE id_product='$id_product'");
        }
        if($status == 2){
            $ath = mysql_query("UPDATE `balance` SET `KL`=`KL` - $kl,`sm`=IF(sm>'$smp',sm,'$smp') WHERE id_product='$id_product'");
        }
        if($status == 3){
            $ath = mysql_query("UPDATE `balance` SET `KL`=`KL` - $kl,`sm`=IF(sm>'$smp',sm,'$smp') WHERE id_product='$id_product'");
        }
    }
    else{
        if($status == 1){
            $ath = mysql_query("INSERT INTO `balance` (`skod`,`id_product`,`kl`,`sm`) VALUES('$skod','$id_product','$kl','$smp')");
        }
        if($status == 4){
            $ath = mysql_query("INSERT INTO `balance` (`skod`,`id_product`,`kl`,`sm`) VALUES('$skod','$id_product','$kl','$smp')");
        }
        if($status == 2){
            $kl = $kl*(-1); 
            $smpr = $smpr*(-1); 
            $ath = mysql_query("INSERT INTO `balance` (`skod`,`id_product`,`kl`,`sm`) VALUES('$skod','$id_product','$kl','$smp')");
        }
        if($status == 3){
            $kl = $kl*(-1);
            $smpr = $smpr*(-1);
            $ath = mysql_query("INSERT INTO `balance` (`skod`,`id_product`,`kl`,`sm`) VALUES('$skod','$id_product','$kl','$smp')");
        }
    }
    mysql_free_result($atu1);
}
mysql_free_result($atu);
//--------------------
echo '<h1>Дані для контролю сформовані</h1>';
?>