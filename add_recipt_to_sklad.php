<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$recipt=$_GET['recipt'];
$money=$_GET['man'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$sql = "SELECT resipt_all.* FROM resipt_all WHERE resipt_all.ID_RESIPT='$recipt' AND resipt_all.DL='1'";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$skod=$aut["SKOD"];
$provider=$aut["PROVIDER"];
$product=$aut["PRODUCT"];
$klprod=$aut["NUMBER"];
$smprod=$aut["SUM"];
$dt=$aut["DT"];
$ka=$aut["KA"];
$sm_recipt+=$klprod*$smprod;
$ath1=mysql_query("INSERT INTO store (SKOD,PROVIDER,PRODUCT,NUMBER,SUM,DT,STATUS,KA) 
    VALUES('$skod','$provider','$product','$klprod','$smprod','$dt','2','$ka');");
    if(!$ath1){echo "Запис не внесений до БД";}    
 }
mysql_free_result($atu);

$ath1=mysql_query("UPDATE resipt SET SUM='$sm_recipt',DT=NOW(),MONEY='$money' WHERE resipt.ID='$recipt'");
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

header("location: print_chek.php?chk=".$recipt);          
//header("location: store.php?filter=product_to_customer");
?>