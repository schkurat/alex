<?php
include_once "function.php";

$skod=$_GET['skod'];

$p='<table class="zmview">
<tr>';
$ostatok = get_balance($skod);
$sql = "SELECT product.NAIM AS PRODUCT FROM product WHERE product.SKOD='$skod' AND product.DL='1'";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr>
	<th colspan="4">'.$skod.' '.$aut["PRODUCT"].'</th>
    </tr>';
}
mysql_free_result($atu);
$p.='<th style="width:120px;">Статус</th>
<th>Кількість</th>
<th>Дата</th>
<th>Вартість</th>
</tr>';

$sql2 = "SELECT `primary_balance`.`kl`,`primary_balance`.dt AS PR_BALANCE,`primary_balance`.sm AS VART FROM `primary_balance`,`product` "
            . "WHERE `primary_balance`.`id_product`=`product`.`ID` AND `product`.`SKOD`='".$skod."' "
            . "ORDER BY dt DESC LIMIT 1";
    $atu2 = mysql_query($sql2);
    while($aut2 = mysql_fetch_array($atu2))
    {
        $prim_bal = $aut2["kl"];
        $dt_bal = $aut2["PR_BALANCE"];
        $vart = $aut2["VART"];
    }
    mysql_free_result($atu2);
$p.='<td>Ревізія</td>
<td align="center">'.$prim_bal.'</td>
<td>'.german_date($dt_bal).'</td>
<td align="right">'.$vart.'</td>
</tr>';

$sql2 = "SELECT `NUMBER`,`STATUS`,`DT`,`SUM` FROM `store` WHERE `SKOD`='".$skod."' AND DT>='$dt_bal' AND DL='1'";
    $atu2 = mysql_query($sql2);
    while($aut2 = mysql_fetch_array($atu2))
    {
        if($aut2["STATUS"] == '1') $status = 'Прихід ';
        if($aut2["STATUS"] == '2') $status = 'Продажа ';
        if($aut2["STATUS"] == '3') $status = 'Списання ';
        if($aut2["STATUS"] == '4') $status = 'Повернення від клієнта ';
        
        $p.='<td>'.$status.'</td>
            <td align="center">'.$aut2["NUMBER"].'</td>
            <td>'.german_date($aut2["DT"]).'</td>
            <td align="right">'.$aut2["SUM"].'</td>
            </tr>';
        $last_sum = $aut2["SUM"];
    }
mysql_free_result($atu2);

$sql = "SELECT product.cost FROM product WHERE product.SKOD='$skod' AND product.DL='1'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
{  
    $price_sum = $aut["cost"];
}
mysql_free_result($atu);

if($last_sum >= $price_sum) $ost_sum = $last_sum;
else $ost_sum = $price_sum;

$p.='<th>Залишок</th>
<th>'.$ostatok.'</th>
<th colspan="2">'.$ost_sum.' грн.</th>
</tr>';
  
$p.='</table>';
echo $p;
?>