<?php
include "function.php";
include "scriptu.php";
?>
<body>
<form action="add_trash.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Списання товару</b></th></tr>
<tr>
<td>Дата:</td>
<td>
<input type="text" class="datepicker" size="10" maxlength="10" name="dt" value="<?php echo date("d.m.Y"); ?>" /></td>
</tr>
<tr>
<td>Штрих-код: </td>
<td><input type="text" name="skod" value=""/></td>
</tr>
<tr>
<td>Товар:</td>
<td>
<select name="product" required>
<option value="">Оберіть товар</option>
<?php
$sql = "SELECT ID,NAIM FROM product WHERE DL=1 ORDER BY NAIM";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr>
<td>Постачальник: </td>
<td>
<select name="provider" required>
<option value="">Оберіть постачальника</option>
<?php
$sql = "SELECT ID,NAIM FROM provider WHERE DL=1 ORDER BY NAIM";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr>
<td>Списано товару:</td>
<td><input type="text" name="klprod" value=""/></td>
</tr>
<tr>
<td>Ціна за одиницю:</td>
<td><input type="text" name="smprod" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Додати">
</td>
</tr>
</table>
</form>