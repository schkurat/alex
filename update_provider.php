<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_GET['kl'];
$name=addslashes($_GET['name']);
$persent=$_GET['persent'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE provider SET NAIM='$name',PR='$persent' WHERE provider.ID='$kl' AND provider.DL='1'");
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
		  
header("location: store.php?filter=provider_view");
?>