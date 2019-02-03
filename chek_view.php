<?php
include_once "function.php";

$dt_now=date("Y-m-d");
if(isset($_GET['npr'])){ 
$npr=date_bd($_GET['npr']);
if(isset($_GET['kpr'])){
$kpr=date_bd($_GET['kpr']);
}
}
if(isset($_GET['time1'])){
    $time1 = $_GET['time1'];
    if(isset($_GET['time2'])){
        $time2 = $_GET['time2'];
    }
}
if($npr!="" and $kpr!="" and $time1 != "" and $time2 != ""){
	$flag="resipt.DT>='".$npr." ".$time1."' AND resipt.DT<='".$kpr." ".$time2."'";
}
else{
	$flag="resipt.DT>='".$dt_now." 00:00:00' AND resipt.DT<='".$dt_now." 23:59:59'";
	$npr=$dt_now;
	$kpr=$dt_now;
} 

$type = $_GET['type'];

$p='<table class="zmview">
<tr>
<th class="add_record">#<!--<a href="store.php?filter=product_to_sklad&stat=1"><img src="images/add.png" border="0"></a>--></th>
<th>Дата</th>
<th>Продавець</th>
<th>Розрахунок</th>
<th>Сума карти</th>
<th>Сума готівки</th>
<th>і</th>
</tr>';

$ssum=0;
if($type == '1'){
    $sql = "SELECT resipt.* FROM resipt WHERE ".$flag." ORDER BY resipt.DT DESC";
}
else{
    $sql = "SELECT resipt.* FROM resipt,resipt_all "
            . "WHERE ".$flag." AND resipt_all.`ID_RESIPT`=resipt.ID AND resipt_all.`DL`='0' "
            . "GROUP BY resipt_all.`ID_RESIPT` ORDER BY resipt.DT DESC";
}
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
/*$n_stat='';
$status=$aut["STATUS"];
If($status=='1') $n_stat='надійшло';
If($status=='2') $n_stat='продано';
If($status=='3') $n_stat='повернуто';
If($status=='4') $n_stat='списано';*/
if($aut["MONEY"] == 'Карта') $sm_karta = $aut["SUM"];
else $sm_cash = $aut["SUM"];
$p.='<tr>
<td align="center"><a href="print_chek.php?chk='.$aut["ID"].'">'.$aut["ID"].'</a></td>	
    <td>'.$aut["DT"].'</td>
	<td align="center">'.$aut["SELLER"].'</td>
	<td align="center">'.$aut["MONEY"].'</td>
        <td align="center">'.$sm_karta.'</td>	
        <td align="center">'.$sm_cash.'</td>	
<td align="center"><a href="store.php?filter=recipt_view&kl='.$aut["ID"].'&npr='.$npr.'&kpr='.$kpr.'&type='.$type.'"><img src="images/b_props.png" border="0"></a></td>    
    </tr>';
$ssum+=$aut["SUM"];
$suma_karta += $sm_karta;
$suma_cash += $sm_cash;
$sm_karta = 0;
$sm_cash = 0;
}
mysql_free_result($atu);
$ssum= number_format($ssum,2);

$p.='<tr><td colspan="3">Всього:</td><td align="right">'.$ssum.'</td>'
        . '<td align="right">'.$suma_karta.'</td>'
        . '<td align="right">'.$suma_cash.'</td><td align="center">-</td></tr></table>';
echo $p;
?>