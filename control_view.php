<?php
include_once "function.php";

$dt_now = date("Y-m-d");
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
        $group_product = $_GET['group_product'];
    }
}

if ($npr != "" and $kpr != "") {
    $flag = "primary_balance.dt>='" . $npr . "' AND primary_balance.dt<='" . $kpr . "'";
} else {
    $flag = "primary_balance.dt='" . $dt_now . "'";
    $npr = $dt_now;
    $kpr = $dt_now;
}

$sm_gr = 0.0;

$sql = "SELECT primary_balance.dt,ROUND(SUM(primary_balance.sm * kl), 2) AS sm,group_product.NAIM FROM primary_balance,group_product,product  
	WHERE " . $flag . " AND group_product.ID='$group_product' AND product.ID=primary_balance.id_product AND product.GROUP=group_product.ID AND primary_balance.kl>0 GROUP BY primary_balance.dt";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;
    $p .= '<tr><td align="center">' . german_date($aut["dt"]) . '</td><td align="center">' . $aut["sm"] . '</b></td></tr>';
    $sm_gr += $aut["sm"];
    $group_name = $aut["NAIM"];
}
mysql_free_result($atu);

$head = '<table class="zmview">
<tr><th colspan="2">' . $group_name . '</th></tr>
<tr><th colspan="2">Період з ' . german_date($npr) . ' по ' . german_date($kpr) . '</th></tr>
<tr>
    <th>Дата</th>
    <th>Сума</th>
</tr>';

$p .= '<tr class="result"><th>Всього</th><th class="number">' . number_format($sm_gr,2) . '</th></tr></table>';
if ($kly > 0) echo $head . $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>У вказаний період не було ревізій</b></th></tr></table>';
