<?php
include_once "function.php";

$kl = $_GET['kl'];
$provider = $_GET['provider'];
$kly = 0;

$p='<table class="zmview">
<tr><th colspan="5">'.$provider.'</th></tr>
<tr>
<th colspan="2">№</th>
<th>Дата<br>розрахуну</th>
<th>Оплата<br>із залишку</th>
<th>Оплата<br>з готівки</th>
</tr>';

$sql = "SELECT * FROM invoicespay WHERE invoice='$kl' AND dl='1' ORDER BY id";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$kly++;
$invoiceid = $aut["id"];

$p.='<tr>
<td align="center"><a href="store.php?filter=edit_pay&kl='.$invoiceid.'&provider='.$provider.'&ivoice='.$kl.'"><img src="images/b_edit.png" border="0"></a></td>	
<td align="center">'.$kly.'</td>	
        <td align="center">'.german_date($aut["dt"]).'</td>
	<td align="center">'.$aut["sm_bal"].'</td>
	<td align="center">'.$aut["sm_cash"].'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
if($kly>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Оплат не знайдено</b></th></tr></table>';
?>