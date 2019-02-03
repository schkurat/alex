<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_POST['kl'];
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
 
$ath1=mysql_query("UPDATE earnings SET NAL_D='$nal_d',TERM_D='$term_d',NAL_N='$nal_n',TERM_N='$term_n',DT='$dt' 
		WHERE earnings.ID='$kl'");
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
		  
header("location: store.php?filter=earnings_view");
?>