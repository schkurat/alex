<?php
include "function.php";
include "scriptu.php";
?>
<body>
<form action="add_payments.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Нова виплата</b></th></tr>
<tr>
<td>Дата:</td>
<td>
<input type="text" size="20" maxlength="20" name="dt" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly /></td>
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
<td>Cума:</td>
<td><input type="text" name="sm_payments" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Створити">
</td>
</tr>
</table>
</form>
<?php
$p='
<table class="zmview">
<tr>
<th>Виплата</th>
<th>Сума</th>
<th>Дата та час</th>
</tr>';

$sql = "SELECT payments.*,provider.NAIM FROM payments,provider WHERE payments.provider=provider.ID ORDER BY payments.`dt` DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	

$p.='<tr>
    <td align="right">'.$aut["NAIM"].'</td>
    <td align="right">'.$aut["sm"].'</td>
    <td align="right">'.$aut["dt"].'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p;
?>