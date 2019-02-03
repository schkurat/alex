<?php
include_once "function.php";

$p='<table class="zmview">
<tr>
<th class="add_record"><a href="store.php?filter=new_group_product"><img src="images/add.png" border="0"></a></th>
<!--<th>№</th>-->
<th>Назва</th>
<th>Од.<br>виміру</th>
<th>Відсоток<br>надбавки</th>
</tr>';

$sql = "SELECT * FROM group_product WHERE group_product.DL='1' ORDER BY NAIM COLLATE utf8_unicode_ci";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {		
$p.='<tr>    
<td align="center"><a href="store.php?filter=edit_group_product&kl='.$aut["ID"].'"><img src="images/b_edit.png" border="0"></a></td>	
<!--	<td align="center">'.$aut["ID"].'</td> -->
      <td>'.$aut["NAIM"].'</td>
	<td>'.$aut["UNITS"].'</td>
        <td align="right">'.$aut["PR"].'%</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>