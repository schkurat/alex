<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("function.php");

$pr_kred = (int)$_POST['pr_kred'];
$sum_kred = (float)str_replace(",", ".", $_POST['sum_kred']);

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$ath1 = mysql_query("UPDATE kredit_settings SET persent='$pr_kred',sum_bill='$sum_kred' WHERE kredit_settings.id=1");
if (!$ath1) {
    echo "Запис не скоригований";
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: store.php?filter=kredit_settinds_info");
