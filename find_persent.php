<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
//header('Content-Type: text/html; charset=utf-8');

//include "function.php";
$pr=0;

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(magazin,$db))
  {echo("Не завантажена таблиця");
   exit();}
   
if(isset($_POST['kod'])){
$kod=$_POST['kod'];
if($kod!=""){
  $ath=mysql_query("SELECT PR FROM group_product WHERE ID='$kod'");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $pr=$aut['PR'];
   }
mysql_free_result($ath);}
}
} 
echo $pr;

 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   
?>