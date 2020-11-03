<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("function.php");

$pasw = $_GET['pasw'];
$kl = (isset($_GET['kl'])) ? (int)$_GET['kl'] : 0;
if (isset($_GET['st']) && $kl != 0) {
    if ((int)$_GET['st'] == 1) {
        $st = '0';
    } else {
        $st = '1';
    }

    $db = mysql_connect("localhost", $lg, $pas);
    if (!$db) echo "Не вiдбулося зєднання з базою даних";

    if (!@mysql_select_db(magazin, $db)) {
        echo("Не завантажена таблиця");
        exit();
    }

    $ath1 = mysql_query("UPDATE provider SET DL='$st' WHERE provider.ID='$kl'");
    if (!$ath1) {
        echo "Запис не скоригований";
    }

//Zakrutie bazu
    if (mysql_close($db)) {
        // echo("Закриття бази даних");
    } else {
        echo("Не можливо виконати закриття бази");
    }
}

header("location: store.php?filter=provider_view");
