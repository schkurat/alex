<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_POST['kl'];
$dt=$_POST['dtmoney']; //date_bd($_POST['dtmoney']);
$smbal=str_replace(",",".",$_POST['smbal']);
$smcash=str_replace(",",".",$_POST['smcash']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO invoicespay (invoice,dt,sm_bal,sm_cash) VALUES('$kl','$dt','$smbal','$smcash');");
	if(!$ath1){echo "Запис не внесений до БД";} 

	
header("location: store.php?filter=invoice_view");

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