<?php
include "function.php";
include "scriptu.php";

$kl=$_GET['kl'];

$sql = "SELECT * FROM earnings WHERE earnings.ID='$kl'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
?>
<form action="update_earnings.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="4" style="font-size: 35px;"><b>Редагування виручки</b></th></tr>
<tr>
<td>Дата:</td>
<td colspan="3">
<input type="text" size="10" maxlength="10" name="dt" value="<?php echo german_date($aut["DT"]); ?>" readonly />
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<th colspan="2">День</th>
<th colspan="2">Ніч</th>
</tr>
<tr>
<td>Готівка:</td>
<td><input type="text" name="nal_d" value="<?php echo $aut["NAL_D"]; ?>"/></td>
<td>Готівка:</td>
<td><input type="text" name="nal_n" value="<?php echo $aut["NAL_N"]; ?>"/></td>
</tr>
<tr>
<td>Термінал:</td>
<td><input type="text" name="term_d" value="<?php echo $aut["TERM_D"]; ?>"/></td>
<td>Термінал:</td>
<td><input type="text" name="term_n" value="<?php echo $aut["TERM_N"]; ?>"/></td>
</tr>
<tr>
<td colspan="4" align="center">
<input type="submit" id="submit" value="Змінити">
</td>
</tr>
</table>
</form>
<?php
}
mysql_free_result($atu);
?>