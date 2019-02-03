<?php
include "function.php";
include "scriptu.php";
?>
<body>
<form action="add_earnings.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="4" style="font-size: 35px;"><b>Додати виручку</b></th></tr>
<tr>
<td>Дата:</td>
<td colspan="3">
<input type="text" size="10" maxlength="10" name="dt" value="<?php echo date("d.m.Y"); ?>" readonly /></td>
</tr>
<tr>
<th colspan="2">День</th>
<th colspan="2">Ніч</th>
</tr>
<tr>
<td>Готівка:</td>
<td><input type="text" name="nal_d" value=""/></td>
<td>Готівка:</td>
<td><input type="text" name="nal_n" value=""/></td>
</tr>
<tr>
<td>Термінал:</td>
<td><input type="text" name="term_d" value=""/></td>
<td>Термінал:</td>
<td><input type="text" name="term_n" value=""/></td>
</tr>
<tr>
<td colspan="4" align="center">
<input type="submit" id="submit" value="Додати">
</td>
</tr>
</table>
</form>