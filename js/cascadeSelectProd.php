<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    
	$db=mysql_connect("localhost",$lg,$pas);
	if(!$db) echo "Не вiдбулося зєднання з базою даних";
	
	if(!@mysql_select_db(magazin,$db))
	{
	echo("Не завантажена таблиця");
	exit(); 
	}
   $pr1='[';
   $pr2='';  //{"value":"","text":"Виберiть товар"}
   $pr3='';
   $pr4=']';

   $gr=$_GET['group'];
   if(isset($_GET['tov'])) {
       $tv=$_GET['tov'];
       if($tv=='') $pr2='{"value":"","text":"Виберiть товар"}';
   }
   else {$tv=0; $pr2='{"value":"","text":"Виберiть товар"}';}
   
   if($gr!=""){
	$ath=mysql_query("SELECT `ID`,`NAIM` FROM product WHERE `GROUP`='$gr' AND `DL`='1' ORDER BY `NAIM`");
	if($ath)
	{
            while($aut=mysql_fetch_array($ath))
            {
            if($aut['ID']!=$tv)
            $pr3.=',{"value":"'.$aut['ID'].'","text":"'.htmlspecialchars($aut['NAIM'], ENT_QUOTES).'"}';
            else 
            $pr2.='{"value":"'.$aut['ID'].'","text":"'.htmlspecialchars($aut['NAIM'], ENT_QUOTES).'"}';
            }
	}	
	print $pr1.$pr2.$pr3.$pr4;
        mysql_free_result($ath);
    }
    else{
	print $pr1.$pr2.$pr4;
	}
    if(mysql_close($db))
        {
        //  echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази");
          }   
}
?>