<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "function.php";
$cost = 0;
$prov = 0;

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (isset($_POST['kod']) && isset($_POST['inv'])) {
    $skod = $_POST['kod'];
    $inv = (int)$_POST['inv'];

    $ath = mysql_query("SELECT store.OPT,store.PROVIDER FROM store WHERE store.SKOD='$skod' AND store.invoice='$inv'");
    if ($ath) {
        while ($aut = mysql_fetch_array($ath)) {
            $cost = $aut['OPT'];
            $prov = $aut['PROVIDER'];
        }
        mysql_free_result($ath);
    }
}
echo $cost . ':' . $prov;

if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}
