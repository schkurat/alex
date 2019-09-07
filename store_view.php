<?php
include_once "function.php";

$dt_now = date("Y-m-d");
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
        $provider = $_GET['provider'];
    }
}
if (isset($_GET['time1'])) {
    $time1 = $_GET['time1'];
    if (isset($_GET['time2'])) {
        $time2 = $_GET['time2'];
    }
}
if ($npr != "" and $kpr != "" and $time1 != "" and $time2 != "") {
    $flag = "store.DT>='" . $npr . " " . $time1 . "' AND store.DT<='" . $kpr . " " . $time2 . "'";
    if ($provider != '') $flag .= " AND  store.PROVIDER='$provider'";
} else {
    $flag = "store.DT>='" . $dt_now . " 00:00:00' AND store.DT<='" . $dt_now . " 23:59:59'";
    $npr = $dt_now;
    $kpr = $dt_now;
}
$stat = $_GET['stat'];
if ($stat != 0) {
    $flag .= " AND store.STATUS='" . $stat . "'";
}
if (isset($_GET['skod']) && $_GET['skod'] != '') $flag .= " AND store.SKOD='" . $_GET['skod'] . "'";
$p = '
<!--<script>
$("html").keydown(function(eventObject){ 
  if (eventObject.keyCode == 107) { //событие на нажатие клавиши "+"
    document.getElementById("plustov").click();
  }
});
</script>-->
<table class="zmview">
<tr>
<th class="add_record" colspan="2">#<!--<a href="store.php?filter=product_to_sklad&stat=1" id="plustov"><img src="images/add.png" border="0"></a>--></th>
<th>Штрих-код <a href="print_kod.php?npr=' . $npr . '&kpr=' . $kpr . '&time1=' . $time1 . '&time2=' . $time2 . '&stat=' . $stat . '&provider=' . $provider . '"><img src="images/print.png" border="0"></a> </th>
<th>Постачальник</th>
<th>Назва</th>
<th>Кількість</th>
<th>Ціна опт од.<br>(всього)</th>
<th>Ціна роздріб од.<br>(всього)</th>
<th>Дата<br>Час</th>
<th>Статус</th>
<th>Кас.ап.</th>
</tr>';

$kl_prod = 0;
$sopt = 0;
$ssum = 0;
$num_line = 0;
$sql = "SELECT store.*,provider.NAIM AS PROVIDER,product.NAIM AS PRODUCT FROM store,provider,product 
	WHERE " . $flag . " AND store.DL='1' AND store.PROVIDER=provider.ID AND provider.DL='1' AND store.PRODUCT=product.ID 
	AND product.DL='1' ORDER BY store.ID DESC";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $n_stat = '';
    $status = $aut["STATUS"];
    $kapp = $aut["KA"];
    If ($status == '1') $n_stat = 'надійшло';
    If ($status == '2') $n_stat = 'продано';
    If ($status == '3') $n_stat = 'списано';
    If ($status == '4') $n_stat = 'повернуто';
    if ($kapp == '1') $st_kap = 'так';
    else $st_kap = 'ні';
    $num_line++;
    $p .= '<tr>
<td>' . $num_line . '</td>
<td align="center"><a href="store.php?filter=edit_sklad&kl=' . $aut["ID"] . '"><img src="images/b_edit.png" border="0"></a></td>	
<td class="text-right">' . $aut["SKOD"] . '
<a href="print_kod.php?npr=' . $npr . '&kpr=' . $kpr . '&time1=' . $time1 . '&time2=' . $time2 . '&stat=' . $stat . '&provider=' . $provider . '&scd=' . $aut["SKOD"] . '&size=3"><img src="images/print.png" border="0">2x3</a>
<a href="print_kod.php?npr=' . $npr . '&kpr=' . $kpr . '&time1=' . $time1 . '&time2=' . $time2 . '&stat=' . $stat . '&provider=' . $provider . '&scd=' . $aut["SKOD"] . '&size=4"><img src="images/print.png" border="0">2.5x4</a>
</td>	
    <td>' . $aut["PROVIDER"] . '</td>
	<td align="center">' . $aut["PRODUCT"] . '</td>
	<td align="center">' . $aut["NUMBER"] . '</td>
        <td align="center">' . $aut["OPT"] . '<br>(<span style="color:green;">' . number_format($aut["OPT"] * $aut["NUMBER"], 2) . '</span>)</td>
	<td align="center">' . $aut["SUM"] . '<br>(<span style="color:green;">' . number_format($aut["SUM"] * $aut["NUMBER"], 2) . '</span>)</td>
	<td align="center">' . german_date($aut["DT"]) . '</td>
	<td align="center">' . $n_stat . '</td>
        <td align="center">' . $st_kap . '</td>
    </tr>';
    $kl_prod += $aut["NUMBER"];
    $sopt += $aut["OPT"] * $aut["NUMBER"];
    $ssum += $aut["SUM"] * $aut["NUMBER"];
}
mysql_free_result($atu);
$kl_prod = number_format($kl_prod, 2);
$sopt = number_format($sopt, 2);
$ssum = number_format($ssum, 2);
$p .= '<tr><td colspan="5">Всього:</td><td align="right">' . $kl_prod . '</td><td align="right">' . $sopt . '</td><td align="right">' . $ssum . '</td><td colspan="3"></td></tr></table>';
echo $p;
?>