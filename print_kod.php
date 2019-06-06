<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include_once "function.php";

if (isset($_GET['npr'])) $npr = $_GET['npr']; else $npr = '';
if (isset($_GET['kpr'])) $kpr = $_GET['kpr']; else $kpr = '';
if (isset($_GET['time1'])) {
    $time1 = $_GET['time1'];
    if (isset($_GET['time2'])) {
        $time2 = $_GET['time2'];
    }
}
if ($npr != "" and $kpr != "" and $time1 != "" and $time2 != "") {
    $flag = "store.DT>='" . $npr . " " . $time1 . "' AND store.DT<='" . $kpr . " " . $time2 . "'";
}
if (isset($_GET['provider'])) $provider = $_GET['provider']; else $provider = '';
if (isset($_GET['stat'])) $stat = $_GET['stat']; else $stat = 0;
if (isset($_GET['scd'])) $scd = $_GET['scd']; else $scd = '';
if ($provider != '') $flag .= " AND  store.PROVIDER='$provider'";
if ($stat != 0) {
    $flag .= " AND store.STATUS='" . $stat . "'";
}
if (isset($_GET['invoice'])) {
    $invoice = $_GET['invoice'];
    $flag .= "store.invoice='$invoice'";
}
if ($scd != '') $flag .= " AND  store.SKOD='$scd'";
$size = $_GET['size'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

require('tfpdf/ean13.php');

$pdf = new PDF_EAN13();
$pdf->AddFont('dejavu', '', 'DejaVuSans.ttf', true);

$sql = "SELECT store.*,product.NAIM AS PROD FROM store,product 
	WHERE " . $flag . " AND store.STATUS='1' AND store.DL='1' AND store.PRODUCT=product.ID 
	AND product.DL='1' ORDER BY store.ID DESC";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $product = $aut["PROD"];
    $skod = $aut["SKOD"];
    $kl = $aut["NUMBER"];
    $kprod = $aut["PRODUCT"];

    if (fract($kl) != 0) $kl = 1;

    for ($i = 1; $i <= $kl; $i++) {
        if($size == '3') {
            $pdf->AddPage('P', [30, 20]);
        }
        else{
            $pdf->AddPage('P', [40, 25]);
        }
        $xx = 2;
        $yy = 3;

        $pdf->SetTopMargin(0);
        $pdf->SetLeftMargin(0);


       if($size == '3'){
           $pdf->SetFont('dejavu', '', 6);
           $pdf->Text($xx, $yy, $product);
           $pdf->EAN13($xx, $yy + 1, $skod);
       } else{
           $pdf->SetFont('dejavu', '', 8);
           $pdf->SetXY(0,0.1);
           $pdf->MultiCell(38,2.4,$product,0,'L');
           $xx = $pdf->GetX();
           $yy = $pdf->GetY();
           $pdf->EAN13($xx+2, $yy + 2, $skod, 10, .38);
       }

    }


}
mysql_free_result($atu);

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

$pdf->Output('kod.pdf', 'I');
?>
