<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("function.php");

$kr_sell = $_POST['kr_seller'];
$kr_cust = $_POST['kr_customer'];
$receipt = $_POST['receipt'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$seller = '';
$customer = '';
$kredit_settings = get_kredit_settings();
$bonus = $kredit_settings["persent"];

$sell = get_user($kr_sell);
if ($sell) $seller = $sell["pr"] . ' ' . $sell["im"] . ' ' . $sell["pb"];
$cust = get_user($kr_cust);
if ($cust) $customer = $cust["pr"] . ' ' . $cust["im"] . ' ' . $cust["pb"];

$seller_id = (!empty($sell["id"])) ? $sell["id"] : 0;
$customer_id = (!empty($cust["id"])) ? $cust["id"] : 0;

if ($seller_id > 0 && $customer_id > 0) {
    $kredit_today = get_sm_kredit_today($customer_id);
    $sql = "SELECT resipt_all.* FROM resipt_all WHERE resipt_all.ID_RESIPT='$receipt' AND resipt_all.DL='1'";
//echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        if ($kredit_today <= $kredit_settings["sum_bill"]) {
            $prib = 0;
            $sum_bonus = 0;
            $new_kredit_today = 0;
            $id_record = $aut["ID"];
            $klprod = $aut["NUMBER"];
            $smprod = $aut["SUM"];
            $smopt = $aut["OPT"];
            $prib = $smprod - $smopt;
            $sum_bonus = $smopt + ($prib * ($kredit_settings["persent"] / 100));
            $new_kredit_today = $kredit_today + $sum_bonus;
            if ($new_kredit_today <= $kredit_settings["sum_bill"]) {
                $ath1 = mysql_query("UPDATE resipt_all SET BONUS='$bonus',SUM_BONUS='$sum_bonus',SELLER='$seller_id',CUSTOMER='$customer_id' WHERE resipt_all.ID='$id_record'");
                if ($ath1) {
                    $kredit_today = $new_kredit_today;
                }
            }
        }
    }
    mysql_free_result($atu);
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: store.php?filter=product_to_customer&recipt=" . $receipt . "&seller=" . $seller . "&customer=" . $customer);