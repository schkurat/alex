<?php
$kl=$_GET['kl'];

$sql = "SELECT * FROM group_product WHERE group_product.ID='$kl' AND group_product.DL='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
?>
<form action="update_group_product.php" name="myform" method="get">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="2" align="center">Редагування інформації про групу товару</th></tr>
<tr>
<td>Назва:</td>
<td>
<input name="name" type="text" size="60" value="<?php echo htmlspecialchars($aut["NAIM"],ENT_QUOTES); ?>"/>
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td>Одиниці виміру:</td>
<td>
<input name="units" type="text" value="<?php echo htmlspecialchars($aut["UNITS"],ENT_QUOTES); ?>"/>
</td>
</tr>
<tr>
<td>Відсоток:</td>
<td><input name="pr" type="text" value="<?php echo $aut["PR"]; ?>" required /></td>
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