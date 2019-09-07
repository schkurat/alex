<?php
include_once "function.php";

$nal_fact = str_replace(",", ".", $_GET['nal_fact']);
$term_fact = str_replace(",", ".", $_GET['term_fact']);

$sql = "SELECT ID FROM earnings ORDER BY `DT` DESC LIMIT 1";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $earnings_id = $aut["ID"];
}
mysql_free_result($atu);

$ath1 = mysql_query("UPDATE earnings SET NAL_FACT='$nal_fact',TERM_FACT='$term_fact' WHERE ID='$earnings_id'");

echo '<h1>Закриття каси виконано!</h1>';

