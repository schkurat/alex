<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$dt = $_POST['dt'];
$provider = $_POST['provider'];
$sm_payments = str_replace(",",".",$_POST['sm_payments']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO payments (provider,sm,dt) VALUES('$provider','$sm_payments','$dt');");
if(!$ath1){echo "Запис не внесений до БД";} 
	
header("location: store.php?filter=payments_info");

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>