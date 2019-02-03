<?php
$kl=$_GET['kl'];

$sql = "SELECT * FROM provider WHERE provider.ID='$kl' AND provider.DL='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
?>
<form action="update_provider.php" name="myform" method="get">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="2" align="center">Редагування інформації про постачальника</th></tr>
<tr>
<td>Назва:</td>
<td>
<input name="name" type="text" size="60" value="<?php echo htmlspecialchars($aut["NAIM"],ENT_QUOTES); ?>"/>
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td>Відсоток:</td>
<td><input name="persent" type="text" size="10" value="<?php echo $aut["PR"];?>" required maxlength="3"/></td>
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