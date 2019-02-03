<?php
include_once "function.php";

$p='<table class="zmview">
<tr>
<th class="add_record"><a href="store.php?filter=new_product"><img src="images/add.png" border="0"></a></th>
<th>№</th>
<th>Штрих-код</th>
<th>Назва</th>
<th>Ціна</th>
<th>Група</th>
</tr>';

$sql = "SELECT product.ID,product.SKOD,product.NAIM AS PROD,product.cost,group_product.NAIM AS GR FROM product,group_product 
WHERE product.DL='1' AND group_product.DL='1' AND product.GROUP=group_product.ID 
ORDER BY group_product.NAIM COLLATE utf8_unicode_ci,product.NAIM COLLATE utf8_unicode_ci";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {		
$p.='<tr>    
<td align="center"><a href="store.php?filter=edit_product&kl='.$aut["ID"].'"><img src="images/b_edit.png" border="0"></a></td>	
<td align="center">'.$aut["ID"].'</td>
    <td>'.$aut["SKOD"].'</td>
    <td>'.$aut["PROD"].'</td>
    <td>'.$aut["cost"].'</td>
    <td>'.$aut["GR"].'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>