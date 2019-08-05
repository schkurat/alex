<?php
include_once "function.php";

$dt_now = date("Y-m-d H:i:s");

/*----- stage #1----------*/
$sql = "SELECT * FROM earnings ORDER BY `DT` DESC LIMIT 1";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $last_dt = $aut["DT"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #2----------*/
$sql = "SELECT SUM(`SUM`) AS SM_N FROM resipt WHERE DT>'$last_dt' AND (MONEY='Готівка' OR MONEY='')";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sm_n = $aut["SM_N"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #3----------*/
$sql = "SELECT SUM(`SUM`) AS SM_K FROM resipt WHERE DT>'$last_dt' AND MONEY='Карта'";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sm_k = $aut["SM_K"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #4----------*/
$sql = "SELECT SUM(`sm`) AS SM_PAY FROM payments WHERE dt>'$last_dt'";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sm_pay = $aut["SM_PAY"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #4.1----------*/
//SUM(`sm_bal`) AS SM_BAL_INVOICE,
$sql = "SELECT SUM(`sm_cash`) AS SM_CASH_INVOICE FROM invoicespay WHERE dt>'$last_dt'";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sm_invoice = $aut["CASH_INVOICE"]; //$aut["SM_BAL_INVOICE"] +
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #5----------*/
$sql = "SELECT SUM(`SUM`) AS POVER FROM store WHERE DT>'$last_dt' AND STATUS=4";
//echo $sql.'<br>';
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $pover = $aut["POVER"];
}
mysql_free_result($atu);
/*------------------------*/

/*----- stage #6----------*/
$sm_n = $sm_n - $sm_pay - $sm_invoice - $pover;
/*------------------------*/

/*----- stage #7 Salary ----------*/
$sum_obor = 0;
$worker = 1;
$time_now = date('H');
if ($time_now > 10) $worker = 2;

$sql = "SELECT `OPT`,`SUM` FROM store,product WHERE DT>'$last_dt' AND DT<'$dt_now' AND store.PRODUCT=product.ID AND product.GROUP!=7 AND store.STATUS=2";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sum_obor += ($aut["SUM"] - $aut["OPT"]);
}
mysql_free_result($atu);
$salary = (($sum_obor * 30) / 100) / $worker;
/*------------------------*/

/*----- stage #8----------*/
$ath1 = mysql_query("INSERT INTO earnings (NAL,TERM,SM_SALARY,SALARY,DT) VALUES('$sm_n','$sm_k','$sum_obor','$salary','$dt_now');");
if (!$ath1) {
    echo "Запис не внесений до БД";
}
/*------------------------*/
echo '<h1>Каса сформована!</h1>';

?>
<form action="store.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th align="center" style="border: none;" colspan="2">Введіть фактичну виручку</th>
        </tr>
        <tr>
            <td>Готівка:</td>
            <td><input type="text" id="nal_fact" name="nal_fact" value=""></td>
        </tr>
        <tr>
            <td>Термінал:</td>
            <td><input type="text" id="term_fact" name="term_fact" value=""></td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <input name="filter" type="hidden" value="inkasator_fact"/>
                <input name="Ok" type="submit" value="Зберегти" style="width: 82px;" onclick="return confirmKasa()"/>
            </td>
        </tr>
    </table>
</form>
<script language="JavaScript">
    function confirmKasa() {
        var nal_prog, term_prog, fact_nal, fact_ter, sum_prog, sum_fact, check_sum;

        nal_prog = '<?= $sm_n ?>';
        term_prog = '<?= $sm_k ?>';
        fact_nal = $("#nal_fact").val();
        fact_ter = $("#term_fact").val();

        sum_prog = nal_prog + term_prog;
        sum_fact = fact_nal - fact_ter;

        check_sum = sum_fact - sum_prog;

        if (check_sum < -100) {
            if (confirm("В касi нестача! Продовжити?")) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }
</script>
