<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Виручка за період</th></tr>
<tr>
<td>Період</td>
<td>
<input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" /> - 
<input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="earnings_view" />
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" value="Пошук" /></td>
</tr>
</table>
</form>