<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$lg=$_POST['login'];
$ps=$_POST['parol'];

$pas=$ps;
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$pwd=md5($ps);

 $sql = "SELECT type FROM group_users WHERE log='$lg' and pas='$pwd' and dl='1'";
					
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $type=$aut["type"];
    }
mysql_free_result($atu); 


$_SESSION['LG'] = $lg;
$_SESSION['PAS'] = $pas;
$_SESSION['TYPE'] = $type;

//Zakrutie bazu--       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          } 
header("location: store.php");
?>