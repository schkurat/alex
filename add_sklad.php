<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("function.php");
$group_pr = '';
$new_product = '';
$stat = $_POST['stat'];
if (isset($_POST['invoice'])) $invoice = $_POST['invoice']; else $invoice = 0;
$dt = date_bd($_POST['dt']) . ' ' . date("H:i:s");
$provider = $_POST['provider'];
$skod = $_POST['skod'];
$product = $_POST['product'];
$klprod = str_replace(",", ".", $_POST['klprod']);
$klprod = ($klprod < 0) ? $klprod * (-1) : $klprod;
if ($stat == '1') {
    $smopt = str_replace(",", ".", $_POST['smopt']);
    $smprod = str_replace(",", ".", $_POST['smprod']);
}
if ($stat == '4') {
    $smpover = str_replace(",", ".", $_POST['smpover']);
    $time_back = $_POST['time_back'];
    $dt_back = date_bd($_POST['dt']) . ' ' . $time_back;
}
$new_product = addslashes($_POST['new_product']);
$new_product = trim($new_product);
$group_pr = $_POST['group_pr'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if ($group_pr != '' && $new_product != '') {
    $ath1 = mysql_query("INSERT INTO product(`SKOD`,`NAIM`,`GROUP`) VALUES('$skod','$new_product','$group_pr');");
    if (!$ath1) {
        echo "Запис не внесений до БД";
    }
    $product = mysql_insert_id();

    if ($skod == '') {
        $skod = '2' . str_pad($product, 11, "0", STR_PAD_LEFT);
        $skod .= GetCheckDigit($skod);
    }
    $ath1 = mysql_query("UPDATE product SET SKOD='$skod' WHERE product.ID='$product'");
}

switch ($stat) {
    case 1:
        $ath1 = mysql_query("INSERT INTO store (SKOD,invoice,PROVIDER,PRODUCT,NUMBER,OPT,SUM,DT,STATUS) 
    VALUES('$skod','$invoice','$provider','$product','$klprod','$smopt','$smprod','$dt','1');");
        if (!$ath1) {
            echo "Запис не внесений до БД";
        }
        $costprice = str_replace(",", ".", $_POST['costprice']);
        $ath=mysql_query("UPDATE `product` SET `cost`=IF('$costprice'>'$smprod','$costprice','$smprod') WHERE product.ID='$product' AND product.DL='1'");
       // $ath = mysql_query("UPDATE `product` SET `cost`='$costprice' WHERE product.ID='$product' AND product.DL='1'");
        break;

    case 2:
        $ath1 = mysql_query("INSERT INTO store (SKOD,PROVIDER,PRODUCT,NUMBER,SUM,DT,STATUS) 
    VALUES('$skod','$provider','$product','$klprod','$smprod','$dt','2');");
        if (!$ath1) {
            echo "Запис не внесений до БД";
        }
        break;

    case 3:
        $ath1 = mysql_query("INSERT INTO store (SKOD,PROVIDER,PRODUCT,NUMBER,SUM,DT,STATUS) 
    VALUES('$skod','$provider','$product','$klprod','$smprod','$dt','3');");
        if (!$ath1) {
            echo "Запис не внесений до БД";
        }
        break;

    case 4:
        $ath1 = mysql_query("INSERT INTO store (SKOD,PROVIDER,PRODUCT,NUMBER,SUM,DT,STATUS) 
    VALUES('$skod','$provider','$product','$klprod','$smpover','$dt_back','4');");
        if (!$ath1) {
            echo "Запис не внесений до БД";
        }
        break;
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
if ($stat == '1') {
    header("location: store.php?filter=product_to_sklad&stat=1&invoice=" . $invoice . "&message=" . $smopt);
} else {
    header("location: store.php?filter=fon");
}
?>