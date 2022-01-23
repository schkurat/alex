<?php
include_once "function.php";

$dt_now = date("Y-m-d");
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
    }
}
if ($npr != "" and $kpr != "") {
    $flag = "DATE_FORMAT(store.DT, '%Y-%m-%d')>='" . $npr . "' AND DATE_FORMAT(store.DT, '%Y-%m-%d')<='" . $kpr . "'";
} else {
    $flag = "DATE_FORMAT(store.DT, '%Y-%m-%d')='" . $dt_now . "' AND DATE_FORMAT(store.DT, '%Y-%m-%d')<='" . $dt_now . "'";
    $npr = $dt_now;
    $kpr = $dt_now;
}

$type = $_GET['type'];
?>
<style>
tr th{
    text-align: center;
}
</style>
<table class="zmview">
<tr>
    <th rowspan="2">Дата</th>
    <th colspan="2">Надійшло</th>
    <th colspan="2">Денна виручка</th>
    <th colspan="2">Нічна виручка</th>
    <th colspan="2">Всього</th>
    <th rowspan="2">Всього виручка</th>
    <th rowspan="2">Борг постачальник</th>
    <th rowspan="2">Списання</th>
</tr>
    <tr>
    <th>Оптова</th>
    <th>Роздріб</th>
    <th>Термінал</th>
    <th>Готівка</th>
    <th>Термінал</th>
    <th>Готівка</th>
    <th>Термінал</th>
    <th>Готівка</th>
</tr>

<?php
$ssum = 0;

$sql = "SELECT DATE_FORMAT(store.DT, '%Y-%m-%d') AS DT, SUM(store.OPT * store.`NUMBER`) AS OPT, SUM(store.SUM * store.`NUMBER`) AS ROZN FROM store,provider,product  
    WHERE " . $flag . " AND store.STATUS=1 AND store.DL='1' AND store.PROVIDER=provider.ID AND provider.DL='1' AND store.PRODUCT=product.ID 
	AND product.DL='1' GROUP BY DATE_FORMAT(store.DT, '%Y-%m-%d')";

//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $term_total = 0;
    $nal_total = 0;
    $spis = 0;
    $nal = [];
    $term = [];
    $i=1;
    $sql1 = "SELECT * FROM earnings WHERE DATE_FORMAT(earnings.DT, '%Y-%m-%d')='" . $aut["DT"] . "' ORDER BY `DT` DESC";
//    echo $sql1;
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $nal[$i] = $aut1["NAL"];
        $term[$i] = $aut1["TERM"];
        $i++;
    }
    mysql_free_result($atu1);
    $term_total = $term[1] + $term[2];
    $nal_total = $nal[1] + $nal[2];

    $sql2 = "SELECT SUM(product.cost * store.`NUMBER`) AS SPIS FROM store,provider,product  
    WHERE DATE_FORMAT(store.DT, '%Y-%m-%d')='" . $aut["DT"] . "'  AND store.STATUS=3 AND store.DL='1' 
        AND store.PROVIDER=provider.ID AND provider.DL='1' AND store.PRODUCT=product.ID 
	    AND product.DL='1'";
//    echo $sql2;
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $spis = $aut2["SPIS"];
    }
    mysql_free_result($atu2);
    ?>
    <tr>
               <td><?= $aut["DT"] ?></td>
               <td align="center"><?= number_format($aut["OPT"], 2) ?></td>
               <td align="center"><?= number_format($aut["ROZN"], 2) ?></td>
               <td align="center"><?= $term[1] ?></td>
               <td align="center"><?= $nal[1] ?></td>
               <td align="center"><?= $term[2] ?></td>
               <td align="center"><?= $nal[2] ?></td>
               <td align="center"><?= $term_total ?></td>
               <td align="center"><?= $nal_total ?></td>
               <td align="center"><?= $term_total + $nal_total ?></td>
               <td align="center"></td>
               <td align="center"><?= number_format($spis, 2) ?></td>
           </tr>
<?php
//    $ssum += $aut["SUM"];
//    $suma_karta += $sm_karta;
//    $suma_cash += $sm_cash;
//    $sm_karta = 0;
//    $sm_cash = 0;
}
mysql_free_result($atu);
$ssum = number_format($ssum, 2);

//$p .= '<tr><td colspan="3">Всього:</td><td align="right">' . $ssum . '</td>'
//    . '<td align="right">' . $suma_karta . '</td>'
//    . '<td align="right">' . $suma_cash . '</td><td align="center">-</td></tr></table>';
echo $p;
