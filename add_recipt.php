<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$money=$_GET['money'];
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath1=mysql_query("INSERT INTO resipt(`DT`,`SELLER`,`MONEY`) VALUES(NOW(),'$lg','$money');");
if(!$ath1){echo "Запис не внесений до БД";} 
$lid=mysql_insert_id();

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }

header("location: store.php?filter=product_to_customer&recipt=".$lid."&money=".$money);
?>