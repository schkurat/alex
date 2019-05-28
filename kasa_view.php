<?php
include_once "function.php";

$p='
<table class="zmview">
<tr>
<th>Готівка розахунок</th>
<th>Термінал розахунок</th>
<th>Готівка фактична</th>
<th>Термінал фактично</th>
<th>Дата та час закриття</th>
</tr>';

$sql = "SELECT * FROM earnings ORDER BY `DT` DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	

$p.='<tr>
    <td align="right">'.$aut["NAL"].'</td>
    <td align="right">'.$aut["TERM"].'</td>
    <td align="right">'.$aut["NAL_FACT"].'</td>
    <td align="right">'.$aut["TERM_FACT"].'</td>
    <td align="right">'.$aut["DT"].'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p;

?>