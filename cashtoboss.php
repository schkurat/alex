<?php
include "function.php";
include "scriptu.php";

$sql = "SELECT dt FROM earningstoboss ORDER BY dt DESC LIMIT 1";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $dl_last = $aut["dt"];
}
mysql_free_result($atu);

$sql = "SELECT SUM(NAL) AS nalik FROM earnings WHERE DT>'$dl_last'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $nal = $aut["nalik"];
}
mysql_free_result($atu);

//$sql = "SELECT SUM(sm) AS vuplatu FROM payments WHERE dt>'$dl_last'";
//$atu=mysql_query($sql);
//while($aut=mysql_fetch_array($atu))
//{	
//    $vuplatu = $aut["vuplatu"];
//}
//mysql_free_result($atu);

$sql = "SELECT SUM(`sm_bal`) AS vuplatu FROM invoicespay WHERE dt>'$dl_last'";
$atu = mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
    $vuplatu = $aut["vuplatu"];
}
mysql_free_result($atu);


$smboss = $nal - $vuplatu;
?>
<form action="add_cashtoboss.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Здача виручки</b></th></tr>
<tr>
<td>Дата:</td>
<td>
<input type="text" size="20" maxlength="20" name="dt" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly /></td>
</tr>
<tr>
<td>Зібрані каси: </td>
<td>
<input type="text" size="20" name="kasu" value="<?php echo $nal; ?>" readonly /></td>
</td>
</tr>
<tr>
<td>Виплати постачальникам: </td>
<td>
<input type="text" size="20" name="vuplatu" value="<?php echo $vuplatu; ?>" readonly /></td>
</td>
</tr>
<tr>
<td>Cума здачі:</td>
<td><input type="text" name="smboss" value="<?php echo $smboss; ?>" readonly/></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Видати">
</td>
</tr>
</table>
</form>
<?php
$p='
<table class="zmview">
<tr>
<th>Сума кас</th>
<th>Сума виплат</th>
<th>Сума здачі</th>
<th>Дата</th>
</tr>';

$sql = "SELECT * FROM earningstoboss  ORDER BY id DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	

$p.='<tr>
    <td align="right">'.$aut["kasa"].'</td>
    <td align="right">'.$aut["vuplatu"].'</td>
    <td align="right">'.$aut["smboss"].'</td>
    <td align="right">'.german_date($aut["dt"]).'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p;
?>