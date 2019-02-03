<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_GET['kl'];
$recipt=$_GET['recipt'];
$money=$_GET['money'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE resipt_all SET DL='0' WHERE resipt_all.ID='$kl'");
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
		  
header("location: store.php?filter=product_to_customer&recipt=".$recipt."&money=".$money);
?>