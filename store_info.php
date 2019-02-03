<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Склад</th></tr>
<tr>
<td>Період</td>
<td>
<input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" /> - 
<input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="store_view" />
</td>
</tr>
<tr>
<td>Час</td>
<td>
<input id="time1" name="time1" type="text" size="8" maxlength="8" value="00:00:00" /> - 
<input id="time2" name="time2" type="text" size="8" maxlength="8" value="23:59:59"/>
</td>
</tr>
<tr><td>
Постачальник
</td>
<td>
<select name="provider">
<option value=""></option>
<?php
$p='';
$sql = "SELECT ID,NAIM FROM provider WHERE DL='1' ORDER BY NAIM";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	$p.='<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';}
mysql_free_result($atu);
$p.='</select>';
echo $p;
?>
</td>
</tr>
<tr>
<td>Штрих-код товару</td>
<td>
<input name="skod" type="text" value="" />
</td>
</tr>
<tr><td>
Статус
</td>
<td>
<input id="r0" type="radio" name="stat" value="0" checked/><label for="r0">Весь</label><br>
<input id="r1" type="radio" name="stat" value="1" /><label for="r1">Надійшло</label><br>
<input id="r2" type="radio" name="stat" value="2" /><label for="r2">Продано</label><br>
<input id="r3" type="radio" name="stat" value="3" /><label for="r3">Списано</label><br>
<input id="r4" type="radio" name="stat" value="4" /><label for="r4">Повернуто від клієнта</label>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" value="Пошук" /></td>
</tr>
</table>
</form>