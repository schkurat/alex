<?php
include "function.php";
include "scriptu.php";

$kl=$_GET['kl'];
$provider = $_GET['provider'];

?>
<form action="add_pay.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Додати розрахунок</b></th></tr>
<tr>
<td>Дата розрахунку:</td>
<td>
<input id="date" class="datepicker" name="dtmoney" type="text" size="10" maxlength="10" value="" />
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td>Постачальник: </td>
<td>
<input type="text" name="provider" value="<?php echo $provider; ?>"/>
</td>
</tr>
<tr>
<td>Із залишку: </td>
<td><input type="text" name="smbal" value=""/></td>
</tr>
<tr>
<td>З готівки</td>
<td><input type="text" name="smcash" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Додати">
</td>
</tr>
</table>
</form>