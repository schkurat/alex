<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Ревізія</th></tr>
<tr>
<td>Група:</td>
<td>
<select name="group_product" id="group_pr" required>
<option value="">Оберіть групу</option>
<?php
$sql = "SELECT ID,NAIM FROM group_product WHERE DL=1 ORDER BY NAIM";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
<input name="filter" type="hidden" value="formuvannya"/>
</td>
</tr>
<!--<tr>
<td>Період:</td>
<td>
<input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" /> - 
<input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr>
<td>Час</td>
<td>
<input id="time1" name="time1" type="text" size="8" maxlength="8" value="00:00:00" /> - 
<input id="time2" name="time2" type="text" size="8" maxlength="8" value="23:59:59"/>
</td>
</tr>-->
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" value="Формувати" /></td>
</tr>
</table>
</form>