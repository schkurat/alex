<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$recipt=$_POST['recipt'];
$skod= trim($_POST['skod']);
$kol=str_replace(",",".",$_POST['kol']);
$money=$_POST['money'];
if(isset($_POST['kap'])) $kap='1';
else $kap='0';

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$result = mysql_query("SELECT * FROM product WHERE SKOD='$skod'");
$num_rows = mysql_num_rows($result);
if($num_rows == 0){
   $new_kod = '2'.str_pad($skod, 12, "0", STR_PAD_LEFT);
   $skod = $new_kod;
   }
   
$provider=0;

$sql = "SELECT store.*,product.cost FROM store,product WHERE store.SKOD='$skod' AND store.STATUS='1' AND store.DL='1' AND store.PRODUCT=product.ID ORDER BY DT DESC LIMIT 1";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
{  
    $provider=$aut["PROVIDER"];
    $product=$aut["PRODUCT"];
    if($aut["SUM"] > $aut["cost"]){
        $sum = $aut["SUM"];
    }
    else{
       $sum = $aut["cost"];
    }
}
mysql_free_result($atu);

if($provider!=0){
$ath1=mysql_query("INSERT INTO resipt_all(`ID_RESIPT`,`SKOD`,`PROVIDER`,`PRODUCT`,`NUMBER`,`SUM`,`DT`,`STATUS`,`KA`) "
        . "VALUES('$recipt','$skod','$provider','$product','$kol','$sum',NOW(),'2','$kap');");
if(!$ath1){echo "Запис не внесений до БД";} 
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