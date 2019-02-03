<?php
$kl=$_GET['kl'];

$sql = "SELECT * FROM product WHERE product.ID='$kl' AND product.DL='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
?>
<form action="update_product.php" name="myform" method="get">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="2" align="center">Редагування інформації про товар</th></tr>
<tr>
<td>Штрих-код: </td>
<td><input type="text" id="skod" name="skod" value="<?php echo $aut["SKOD"]; ?>"/></td>
</tr>
<tr>
<td>Група:</td>
<td>
<select name="group_product" required>
<option value="">Оберіть групу</option>
<?php
$sql2 = "SELECT ID,NAIM FROM group_product WHERE DL=1 ORDER BY NAIM";
 $atu2=mysql_query($sql2);
 while($aut2=mysql_fetch_array($atu2))
 {
	if($aut["GROUP"]==$aut2["ID"]) echo '<option value="'.$aut2["ID"].'" selected>'.$aut2["NAIM"].'</option>';
	else echo '<option value="'.$aut2["ID"].'">'.$aut2["NAIM"].'</option>';
 }
mysql_free_result($atu2);
?>
</select>
</td>
</tr>
<tr>
<td>Назва:</td>
<td>
<input name="name" type="text" size="60" value="<?php echo htmlspecialchars($aut["NAIM"],ENT_QUOTES); ?>"/>
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td>Ціна:</td>
<td>
<input name="cost" type="text" size="60" value="<?php echo $aut["cost"]; ?>"/>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Змінити" /></td>
</tr>
</table>
</form>
<?php
 }
 mysql_free_result($atu);
?>