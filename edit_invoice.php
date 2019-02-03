<?php
include "function.php";
include "scriptu.php";

$kl=$_GET['kl'];

$sql = "SELECT * FROM invoices WHERE invoices.id='$kl' AND invoices.dl='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
  if($aut["dtmoney"] != '0000-00-00') $dtmoney = german_date ($aut["dtmoney"]); else $dtmoney = '';
?>
<script language="JavaScript">
$(function() {
	$(".datepicker").datepicker("setDate", "<?php echo $dtmoney; ?>");
	});
</script>
<form enctype="multipart/form-data" action="update_invoice.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Редагування накладної</b></th></tr>
<tr>
<td>Дата:</td>
<td>
<input type="text" name="dt" value="<?php echo german_date($aut["dt"]); ?>" readonly />
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td>Постачальник: </td>
<td>
<select name="provider" required>
<option value="">Оберіть постачальника</option>
<?php
$sql1 = "SELECT ID,NAIM FROM provider WHERE DL=1 ORDER BY NAIM";
 $atu1=mysql_query($sql1);
 while($aut1=mysql_fetch_array($atu1))
 {
	if($aut1["ID"]==$aut["provider"]) echo '<option selected value="'.$aut1["ID"].'">'.$aut1["NAIM"].'</option>';
	else echo '<option value="'.$aut1["ID"].'">'.$aut1["NAIM"].'</option>';
 }
mysql_free_result($atu1);
?>
</select>
</td>
</tr>
<tr>
<td>Із залишку: </td>
<td><input type="text" name="smbal" value="<?php echo $aut["sm_bal"]; ?>"/></td>
</tr>
<tr>
<td>З готівки</td>
<td><input type="text" name="smcash" value="<?php echo $aut["sm_cash"]; ?>"/></td>
</tr>
<tr>
    <td>Дата розрахунку:</td>
    <td><input id="date" class="datepicker" name="dtmoney" type="text" size="10" maxlength="10" value="<?php echo german_date($aut["dtmoney"]); ?>" /></td>
</tr>
<tr>
<td>Сума постачальника</td>
<td><input type="text" name="smprov" value="<?php echo $aut["sm_prov"]; ?>"/></td>
</tr>
<tr>
<td>Надійшло товару</td>
<td><input type="text" name="smgot" value="<?php echo $aut["sm_got"]; ?>"/></td>
</tr>
<tr>
<td>Копія накладної:</td>
<td><input type="file" name="file[]" multiple='true' /><br>
<label style="color: black; font-size:12px;">Тільки для файлів jpg, jpeg, gif та png</label>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Змінити">
</td>
</tr>
</table>
</form>
<?php
}
mysql_free_result($atu);
?>