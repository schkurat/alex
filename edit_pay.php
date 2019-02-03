<?php
include "function.php";
include "scriptu.php";

$kl = $_GET['kl'];
$provider = $_GET['provider'];
$ivoice = $_GET['ivoice'];

$sql = "SELECT * FROM invoicespay WHERE id='$kl' AND dl='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
  if($aut["dt"] != '0000-00-00') $dtmoney = german_date ($aut["dt"]); else $dtmoney = '';
?>
<script language="JavaScript">
$(function() {
	$(".datepicker").datepicker("setDate", "<?php echo $dtmoney; ?>");
	});
</script>
<form action="update_pay.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Редагування виплати постачальнику</b></th></tr>
<tr>
    <td>Дата розрахунку:</td>
    <td>
        <input id="date" class="datepicker" name="dtmoney" type="text" size="10" maxlength="10" value="<?php echo german_date($aut["dtmoney"]); ?>" />
        <input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
        <input name="ivoice" type="hidden" value="<?php echo $ivoice; ?>"/>
    </td>
</tr>
<tr>
<td>Постачальник: </td>
<td>
    <input type="text" name="provider" value="<?php echo $provider; ?>" readonly/>
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