<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_POST['kl'];
$skod=$_POST['skod'];
$provider=$_POST['provider'];
$product=$_POST['product'];
$klprod=$_POST['klprod'];
//$persent=$_POST['persent'];
$smopt=$_POST['smopt'];
$smprod=$_POST['smprod'];
$invoice=$_POST['invoice'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE store SET SKOD='$skod',PROVIDER='$provider',PRODUCT='$product',NUMBER='$klprod',"
        . "OPT='$smopt',SUM='$smprod' WHERE store.ID='$kl'");
	if(!$ath1){echo "Запис не скоригований";} 
	
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
if($invoice != 0)
    header("location: store.php?filter=product_to_sklad&stat=1&invoice=".$invoice);
else
    header("location: store.php?filter=store_view");
?>