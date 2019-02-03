<?php
include_once "function.php";

$dt_now=date("Y-m-d H:i:s");

/*----- stage #1----------*/
$sql = "SELECT * FROM earnings ORDER BY `DT` DESC LIMIT 1";
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $last_dt=$aut["DT"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #2----------*/
$sql = "SELECT SUM(`SUM`) AS SM_N FROM resipt WHERE DT>'$last_dt' AND (MONEY='Готівка' OR MONEY='')";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $sm_n=$aut["SM_N"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #3----------*/
$sql = "SELECT SUM(`SUM`) AS SM_K FROM resipt WHERE DT>'$last_dt' AND MONEY='Карта'";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $sm_k=$aut["SM_K"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #4----------*/
$sql = "SELECT SUM(`sm`) AS SM_PAY FROM payments WHERE dt>'$last_dt'";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $sm_pay=$aut["SM_PAY"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #5----------*/
$sql = "SELECT SUM(`SUM`) AS POVER FROM store WHERE DT>'$last_dt' AND STATUS=4";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $pover=$aut["POVER"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #6----------*/
$sm_n = $sm_n - $sm_pay - $pover;
/*------------------------*/

/*----- stage #7----------*/
$ath1 = mysql_query("INSERT INTO earnings (NAL,TERM,DT) VALUES('$sm_n','$sm_k','$dt_now');");
    if(!$ath1){echo "Запис не внесений до БД";}
/*------------------------*/
echo '<h1>Закриття каси виконано!</h1>';
?>