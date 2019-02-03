<style type="text/css">
td,th{
	border:1px solid lightgrey;
	padding:0px 5px;
}
</style>
<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "function.php";

$bdat=$_GET['npr'];
$edat=$_GET['kpr'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$p='<table border="1" style="border-collapse: collapse;font-size:13px; border:1px solid lightgrey;">
<tr><th colspan="7" align="left">Звіт за період: з '.german_date($bdat).' по '.german_date($edat).'</th></tr>
<tr>
<th align="center" rowspan="2">№<br>п.п.</th>
<th align="center" rowspan="2">Назва постачальника</th>
<th align="center" colspan="3">Оплата</th>
<th align="center" rowspan="2">Підпис<br>постачальника</th>
<th align="center"rowspan="2">Надійшло товару</th>
</tr>
<tr>
<th align="center">Всього</th>
<th align="center">із залишку</th>
<th align="center">з готівки</th>
</tr>
';

$s_all=0;
$s_bal=0;
$s_cash=0;
$s_got=0;
$sm_bl_cs=0;
$kk=0;

$sql1="SELECT invoices.*,provider.NAIM FROM invoices,provider
		WHERE invoices.DT>='$bdat' AND invoices.DT<='$edat'AND invoices.DL='1' 
			AND invoices.PROVIDER=provider.ID ORDER BY invoices.ID";		
//echo $sql1;			
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$kk++;
	$sm_bl_cs=$aut1["SM_BAL"]+$aut1["SM_CASH"];
	$p.='<tr>
	<td align="center">'.$kk.'</td>
	<td>'.$aut1["NAIM"].'</td>
	<td align="right">'.$sm_bl_cs.'</td>
	<td align="right">'.$aut1["SM_BAL"].'</td>
	<td align="right">'.$aut1["SM_CASH"].'</td>
	<td align="center"></td>
	<td align="right">'.$aut1["SM_GOT"].'</td>
	</tr>';
	
	$s_bal=$s_bal+$aut1["SM_BAL"];
	$s_cash=$s_cash+$aut1["SM_CASH"];
	$s_got=$s_got+$aut1["SM_GOT"];
	$s_all=$s_all+$sm_bl_cs;
	$sm_bl_cs=0;
 } 
mysql_free_result($atu1);  

$p.='<tr>
<th colspan="2" align="right">Всього:</th>
<th align="right">'.number_format($s_all, 2, '.', '').'</th>
<th align="right">'.number_format($s_bal, 2, '.', '').'</th>
<th align="right">'.number_format($s_cash, 2, '.', '').'</th>
<th></th>
<th align="right">'.number_format($s_got, 2, '.', '').'</th>
</tr>';

$p.='</table>';
echo $p;
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
?>