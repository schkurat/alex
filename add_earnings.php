<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$dt=date_bd($_POST['dt']);
$nal_d=str_replace(",",".",$_POST['nal_d']);
$nal_n=str_replace(",",".",$_POST['nal_n']);
$term_d=str_replace(",",".",$_POST['term_d']);
$term_n=str_replace(",",".",$_POST['term_n']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO earnings (NAL_D,TERM_D,NAL_N,TERM_N,DT) 
		VALUES('$nal_d','$term_d','$nal_n','$term_n','$dt');");
	if(!$ath1){echo "Запис не внесений до БД";} 
$id_inv=mysql_insert_id();
	
header("location: store.php?filter=earnings_view");

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