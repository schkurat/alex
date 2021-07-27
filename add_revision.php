<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("function.php");

$skod = $_POST['skod'];
$kol = str_replace(",", ".", $_POST['kol']);
$group = $_POST['group'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$ath1 = mysql_query("UPDATE balance SET `rev`=`rev`+'$kol',dt_rev=NOW() WHERE balance.skod='$skod'");
if (!$ath1) {
    echo "Запис не скоригований";
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: store.php?filter=balance&group=" . $group);
