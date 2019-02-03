<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$dt=date_bd($_POST['dt']);
$provider=$_POST['provider'];
$skod=$_POST['skod'];
$product=$_POST['product'];
$klprod=str_replace(",",".",$_POST['klprod']);
$smprod=str_replace(",",".",$_POST['smprod']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO store (SKOD,PROVIDER,PRODUCT,NUMBER,SUM,DT,STATUS) 
	VALUES('$skod','$provider','$product','$klprod','$smprod','$dt','3');");
	if(!$ath1){echo "Запис не внесений до БД";} 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }

header("location: store.php?filter=store_view");
?>