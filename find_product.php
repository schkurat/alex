<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "function.php";
$naim="";
$id="";
$gr="";
$pr=0;
$cost=0;

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(magazin,$db))
  {echo("Не завантажена таблиця");
   exit();}
   
if(isset($_POST['kod'])){
$skod=$_POST['kod'];
if($skod!=""){
  $ath=mysql_query("SELECT product.*,group_product.PR FROM product,group_product WHERE product.SKOD=$skod "
          . "AND product.GROUP=group_product.ID;");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $naim=$aut['NAIM'];
   $id=$aut['ID'];
   $gr=$aut['GROUP'];
   $pr=$aut['PR'];
   $cost = $aut['cost'];
   }
mysql_free_result($ath);}
}
else{
$ath=mysql_query("SELECT product.GROUP FROM product,store "
        . "WHERE store.DL='1' AND store.STATUS='1' AND store.PRODUCT=product.ID AND product.DL='1' "
        . "ORDER BY store.ID DESC LIMIT 1;");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
  // $naim=$aut['NAIM'];
  // $id=$aut['ID'];
   $gr=$aut['GROUP'];
  // $pr=$aut['PR'];
   }
mysql_free_result($ath);}
}
} 
echo $id.':'.$naim.':'.$gr.':'.$pr.':'.$cost;

 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   
?>