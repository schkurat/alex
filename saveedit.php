<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$editval = str_replace(",",".",$_POST["editval"]);
$ath=mysql_query("UPDATE `balance` SET " . $_POST["column"] . " = '".$editval."' WHERE id=".$_POST["id"]);
   
////Zakrutie bazu       
//       if(mysql_close($db))
//        {
//        // echo("Закриття бази даних");
//         }
//         else
//         {
//          echo("Не можливо виконати закриття бази"); 
//          }

//header("location: store.php?filter=balance");
?>