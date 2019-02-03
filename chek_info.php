<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Чеки за період</th></tr>
<tr>
<td>Період</td>
<td>
<input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" /> - 
<input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="chek_view" />
</td>
</tr>
<tr>
<td>Час</td>
<td>
<input id="time1" name="time1" type="text" size="8" maxlength="8" value="00:00:00" /> - 
<input id="time2" name="time2" type="text" size="8" maxlength="8" value="23:59:59"/>
</td>
</tr>
<tr>
<td>Тип</td>
<td>
<input id="r0" type="radio" name="type" value="1" checked/><label for="r0">Всі</label>
<input id="r1" type="radio" name="type" value="0" /><label for="r1">З видаленими</label><br>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" value="Пошук" /></td>
</tr>
</table>
</form>