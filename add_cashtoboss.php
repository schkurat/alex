<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$dt = $_POST['dt'];
$kasu = str_replace(",",".",$_POST['kasu']);
$vuplatu = str_replace(",",".",$_POST['vuplatu']);
$smboss = str_replace(",",".",$_POST['smboss']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO earningstoboss (kasa,vuplatu,smboss,dt) VALUES('$kasu','$vuplatu','$smboss','$dt');");
if(!$ath1){echo "Запис не внесений до БД";} 
	
header("location: store.php?filter=cashtoboss");

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