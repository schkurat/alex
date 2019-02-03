<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$pasw = $_GET['pasw'];
$modal_del = $_GET['modal_del'];

$perem = explode("&", $modal_del);
$mskl = explode("=", $perem[0]);
$kl = $mskl[1];
$msres = explode("=", $perem[1]);
$recipt = $msres[1];
$msmon = explode("=", $perem[2]);
$money = $msmon[1];

//echo 'kl = '.$kl.'<br>';
//echo 'recipt = '.$recipt.'<br>';
//echo 'money = '.$money.'<br>';
//$kl=$_GET['kl'];
//$recipt=$_GET['recipt'];
//$money=$_GET['money'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

   $user = 0;

$sql="SELECT `id` FROM `users` WHERE `pas`='$pasw'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
{
    $user = $aut["id"];
}
mysql_free_result($atu);

if($user != 0){
    $ath1=mysql_query("UPDATE resipt_all SET DL='0',user='$user' WHERE resipt_all.ID='$kl'");
    if(!$ath1){echo "Запис не скоригований";} 
}
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: store.php?filter=product_to_customer&recipt=".$recipt."&money=".$money);
?>