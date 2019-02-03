<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$name=addslashes($_GET['name']);
$units=addslashes($_GET['units']);
$pr=$_GET['pr'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
	
$ath1=mysql_query("INSERT INTO group_product(NAIM,UNITS,PR) VALUES('$name','$units','$pr');");
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
		  
header("location: store.php?filter=group_product_view");
?>