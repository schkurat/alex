<?php
include "scriptu.php";
?>
<form action="add_recipt.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Оберіть вид розрахунку</th></tr>
<tr>
<td>Зробіть вибір</td>
<td>
<input id="r1" type="radio" name="money" value="Готівка" checked/><label for="r1">Готівка</label><br>
<input id="r2" type="radio" name="money" value="Карта" /><label for="r2">Карта</label><br>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" value="Обрати" /></td>
</tr>
</table>
</form>