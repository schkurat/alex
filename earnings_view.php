<?php
include_once "function.php";

$dt_now=date("Y-m-d");
if(isset($_GET['npr'])){ 
$npr=date_bd($_GET['npr']);
if(isset($_GET['kpr'])){
$kpr=date_bd($_GET['kpr']);
}
}
if($npr!="" and $kpr!=""){
	$flag="earnings.DT>='".$npr."' AND earnings.DT<='".$kpr."'";
}
else{
	$flag="earnings.DT='".$dt_now."'";
	$npr=$dt_now;
	$kpr=$dt_now;
}
$p='<table class="zmview">
<tr>
<th>#<!--<a href="print_invoice.php?npr='.$npr.'&kpr='.$kpr.'"><img src="images/print.png" border="0"></a>--></th>
<th>№</th>
<th>Готівка<br>день</th>
<th>Термінал<br>день</th>
<th>Готівка<br>ніч</th>
<th>Термінал<br>ніч</th>
<th>Дата</th>
</tr>';

$sql = "SELECT earnings.* FROM earnings WHERE ".$flag." ORDER BY earnings.ID";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$kly++;

/* $katalog='/home/sc_mg/'.$aut["ID"];
if(is_dir ($katalog.'/')) $skrepka='<a href="download_sc.php?katalog=/home/sc_mg/'.$aut["ID"].'&npr='.$npr.'&kpr='.$kpr.'&provider='.$provider.'"><img src="images/skrepka.png" border="0"></a>';
else $skrepka=''; */

$p.='<tr>
<td align="center"><a href="store.php?filter=edit_earnings&kl='.$aut["ID"].'"><img src="images/b_edit.png" border="0"></a></td>	
<td align="center">'.$kly.'</td>	
    <td align="right">'.$aut["NAL_D"].'</td>
	<td align="right">'.$aut["TERM_D"].'</td>
	<td align="right">'.$aut["NAL_N"].'</td>
	<td align="right">'.$aut["TERM_N"].'</td>
	<td align="right">'.german_date($aut["DT"]).'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
if($kly>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Виручки не знайдено</b></th></tr></table>';
?>