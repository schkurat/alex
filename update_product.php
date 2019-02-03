<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_GET['kl'];
$name=addslashes($_GET['name']);
$group=$_GET['group_product'];
$skod=$_GET['skod'];
$cost=str_replace(",",".",$_GET['cost']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE product SET `SKOD`='$skod',`NAIM`='$name',`GROUP`='$group',`cost`='$cost' WHERE product.ID='$kl' AND product.DL='1'");
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
		  
header("location: store.php?filter=product_view");
?>