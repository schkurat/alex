<?php
include_once "function.php";
$kl=$_GET['kl'];
$npr=german_date($_GET['npr']);
$kpr=german_date($_GET['kpr']);
$type=$_GET['type'];

$p='
<table class="zmview">
<tr>
<th class="add_record"><a href="store.php?filter=chek_view&npr='.$npr.'&kpr='.$kpr.'&type='.$type.'"><img src="images/s_loggoff.png" border="0"></a></th>
<th colspan="6">Перегляд чеку</th>
</tr>
<tr>
<th>№</th>
<th>Штрих-код</th>
<th>Назва</th>
<th>Вартість</th>
<th>Кількість</th>
<th>Всього</th>
<th>Видалений</th>
</tr>';
$npp=0;
$sql = "SELECT resipt_all.`ID_RESIPT`,resipt_all.`SKOD`,resipt_all.`PROVIDER`,users.pr,users.im, 
product.NAIM AS PRODUCT,SUM(resipt_all.`NUMBER`) AS NUMBER,resipt_all.`SUM`,resipt_all.`DL`, 
resipt_all.`DT`,resipt_all.`STATUS` FROM product,resipt_all LEFT JOIN users ON resipt_all.user=users.id 
WHERE resipt_all.ID_RESIPT='$kl' AND resipt_all.PRODUCT=product.ID  
    AND product.DL='1'  
GROUP BY resipt_all.SKOD ORDER BY resipt_all.ID DESC";
//AND resipt_all.DL='1'
//echo $sql;

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$npp++;

$p.='<tr">
<td align="center">'.$npp.'</td>	
<td align="center">'.$aut["SKOD"].'</td>	
<td>'.$aut["PRODUCT"].'</td>
<td align="right">'.$aut["SUM"].'</td>
<td align="right">'.$aut["NUMBER"].'</td>
<td align="right">'.$aut["SUM"] * $aut["NUMBER"].'</td>
<td align="right">'.$aut["pr"].' '.$aut["im"].'</td>
</tr>';

if($aut["DL"] == '1'){
$sm_recipt+=number_format(($aut["SUM"] * $aut["NUMBER"]),2);}

}
mysql_free_result($atu);
$p.='<tr><th colspan="5" align="right">Всього по чеку:</th><th align="right">'.$sm_recipt.' грн.</th><th>-</th></tr></table>';
echo $p;
?>