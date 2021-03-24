<?php
include_once "function.php";

$dt_now = date("Y-m-d");
$typePeriod = (int)$_GET['typePeriod'];
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
        $robitnuk = $_GET['robitnuk'];
    }
}
if ($npr != "" and $kpr != "") {
        $flag = "DATE(`resipt_all`.`DT`)>='" . $npr . "' AND DATE(`resipt_all`.`DT`)<='" . $kpr . "'";
} else {
    $flag = "DATE(`resipt_all`.`DT`)='" . $dt_now . "'";
    $npr = $dt_now;
    $kpr = $dt_now;
}
if ($robitnuk != '') $flag .= " AND  `resipt_all`.`CUSTOMER`='$robitnuk'";

$p = '<table class="zmview">
<tr>
    <th>Дата</th>
    <th>Чек</th>
    <th>Взято кредиту</th>
</tr>';

$sql = "SELECT SUM(SUM_BONUS) AS SMB,resipt_all.DT,resipt_all.ID_RESIPT FROM `resipt_all` 
    LEFT JOIN `store` ON `resipt_all`.`SKOD`=`store`.`SKOD` AND `resipt_all`.`ID_RESIPT`=`store`.`RECEIPT` 
    WHERE " . $flag . " AND `resipt_all`.`DL`='1' AND `store`.`DL`=1 GROUP BY `resipt_all`.`ID_RESIPT`";

//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;

    $p .= '<tr>
    <td align="center">' . german_date($aut["DT"]) . '</td>
	<td align="center"><a href="print_chek.php?chk=' . $aut["ID_RESIPT"] . '">' . $aut["ID_RESIPT"] . '</a></td>
	<td align="center">' . $aut["SMB"] . '</td>
</tr>';
}
mysql_free_result($atu);
$p .= '</table>';
if ($kly > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Кредитів не знайдено</b></th></tr></table>';
