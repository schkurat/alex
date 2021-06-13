<?php
include_once "function.php";

$dt_now = date("Y-m-d");
$typePeriod = (int)$_GET['typePeriod'];
$typeForm = (int)$_GET['typeForm'];
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
        $provider = $_GET['provider'];
    }
}
if ($npr != "" and $kpr != "") {
    if ($typePeriod == 0) {
        $flag = "invoices.dt>='" . $npr . "' AND invoices.dt<='" . $kpr . "'";
    } else {
        $flag = "DATE_FORMAT(invoicespay.dt,'%Y-%m-%d')>='" . $npr . "' AND DATE_FORMAT(invoicespay.dt,'%Y-%m-%d')<='" . $kpr . "'";
    }
    if ($provider != '') $flag .= " AND  invoices.provider='$provider'";
} else {
    if ($typePeriod == 0) {
        $flag = "invoices.dt='" . $dt_now . "'";
    } else {
        $flag = "DATE_FORMAT(invoicespay.dt,'%Y-%m-%d')='" . $dt_now . "'";
    }
    $npr = $dt_now;
    $kpr = $dt_now;
}
$flag .= " AND invoices.type='" . $typeForm . "'";

$p = '<table class="zmview">
<tr>
    <th colspan="2"><a href="print_invoice.php?npr=' . $npr . '&kpr=' . $kpr . '"><img src="images/print.png" border="0"></a></th>
    <th>Накладна</th>
    <th>Постачальник</th>
    <th>Дата<br>накладної</th>
    <th>Оплата<br>із залишку</th>
    <th>Оплата<br>з готівки</th>
    <th>Повернення</th>
    <!--<th>Дата<br>розрахунку</th>-->
    <th>Сума<br>постачальника</th>
    <th>Залишок</th>
    <!--<th>Надійшло товару</th>-->
    <th>Копія</th>
</tr>';

$sm_balance = 0;
$sm_provider = 0;
$sm_paid = 0;
$sum_sm_back = 0;
if ($typePeriod == 0) {
    $sql = "SELECT invoices.*,provider.NAIM FROM invoices,provider 
	WHERE " . $flag . " AND invoices.dl='1' AND invoices.provider=provider.ID AND provider.DL='1' ORDER BY invoices.id";
} else {
    $sql = "SELECT invoices.*,provider.NAIM FROM invoices,provider,invoicespay
    WHERE " . $flag . " AND invoices.id=invoicespay.invoice 
    AND invoices.dl='1' AND invoices.provider=provider.ID AND provider.DL='1' ORDER BY invoices.id";
}
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;
    $invoiceid = $aut["id"];
    $katalog = '/home/sc_mg/' . $aut["id"];
    if (is_dir($katalog . '/')) $skrepka = '<a href="download_sc.php?katalog=/home/sc_mg/' . $aut["id"] . '&npr=' . $npr . '&kpr=' . $kpr . '&provider=' . $provider . '"><img src="images/skrepka.png" border="0"></a>';
    else $skrepka = '';

    $smbal = '';
    $smcash = '';
    $sum_smbal = 0;
    $sum_smcash = 0;
    $sm_back = 0;
    $sql1 = "SELECT sm_bal, sm_cash, DATE_FORMAT(`dt`,'%d.%m.%Y') as dt FROM invoicespay WHERE invoice='$invoiceid' AND dl='1'";
//echo $sql;
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        if ($aut1["sm_bal"] != 0) {
            $smbal .= $aut1["sm_bal"] . ' - ' . $aut1["dt"] . '<br>';
            $sum_smbal += $aut1["sm_bal"];
        }
        if ($aut1["sm_cash"] != 0) {
            $smcash .= $aut1["sm_cash"] . ' - ' . $aut1["dt"] . '<br>';
            $sum_smcash += $aut1["sm_cash"];
        }
    }
    mysql_free_result($atu1);
    $sm_paid += $sum_smbal;

    $sql1 = "SELECT store.NUMBER,store.OPT FROM store WHERE store.invoice='$invoiceid' AND store.STATUS='5' AND DL='1'";
//echo $sql;
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $sm_back += $aut1["NUMBER"] * $aut1["OPT"];
        $sum_sm_back += $sm_back;
    }
    mysql_free_result($atu1);

    $balance = $aut["sm_prov"] - $sum_smbal - $sm_back;
    $sm_balance += $balance;
    $balance = number_format($balance,2);
    $sm_provider += $aut["sm_prov"];

    $p .= '<tr>
    <td align="center"><a href="store.php?filter=invoice_open&kl=' . $invoiceid . '&provider=' . $aut["NAIM"] . '"><img src="images/b_edit.png" border="0"></a></td>
    <td align="center"><a href="store.php?filter=pay_info&kl=' . $invoiceid . '&provider=' . $aut["NAIM"] . '"><img src="images/add.png" border="0"></a></td>    
    <td align="center" class="zal"><a href="store.php?filter=product_to_sklad&stat=1&invoice=' . $invoiceid . '">' . $invoiceid . '</a></td>	
    <td>' . $aut["NAIM"] . '</td>
        <td align="center">' . german_date($aut["dt"]) . '</td>
	<td align="center">' . $smbal . '<b>' . $sum_smbal . '</b></td>
	<td align="center">' . $smcash . '<b>' . $sum_smcash . '</b></td>
	<td align="center">' . $sm_back . '</td>
	<td align="center">' . $aut["sm_prov"] . '</td>
	<td align="right" style="color: red;">' . $balance . '</td>
	<td align="center">' . $skrepka . '</td>
</tr>';
}
mysql_free_result($atu);
$p .= '<tr class="result"><th colspan="5">Всього</th><th class="number">' . $sm_paid . '</th><th></th><th class="number">' . $sum_sm_back . '</th><th class="number">'.$sm_provider.'</th><th class="number">'.$sm_balance.'</th><th></th></tr></table>';
if ($kly > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Накладних не знайдено</b></th></tr></table>';
?>