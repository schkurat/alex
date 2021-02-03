<?php
include_once "function.php";

//$money=$_GET['money'];
//$cash='';
//$card='';
//if($money=='Готівка') $cash='checked';
//else $card='checked';
if(isset($_GET['recipt'])) $recipt=$_GET['recipt'];
else{
$ath1=mysql_query("INSERT INTO resipt(`DT`,`SELLER`,`MONEY`) VALUES(NOW(),'$lg','$money');");
if(!$ath1){echo "Запис не внесений до БД";} 
$recipt=mysql_insert_id();}
$sm_recipt = 0;

$p='
<script language="JavaScript">
$(document).ready(function() {
$("#skod").focus();
$("input[ name=money]").change(radio_click);
$("#kl_money").keyup(rozrahunok);

$("a.go").click( function(event){
    event.preventDefault(); 
    $("#overlay").fadeIn(400,function(){ 
        $("#modal_form") 
        .css("display", "block") 
        .animate({opacity: 1, top: "50%"}, 200); 
    });
    var znach = $(this).children().val();
    $("#modal_del").val(znach);
});
	
$("#modal_close, #overlay").click( function(){ 
$("#modal_form")
.animate({opacity: 0, top: "45%"}, 200,  
function(){
$(this).css("display", "none"); 
$("#overlay").fadeOut(400); 
}
);
});


});
function radio_click(){
if($("input[name=money]:checked").val()=="Готівка") {
$("#man").val("Готівка");
}
else {
$("#man").val("Карта");			
}
}
function roundPlus(x,n){
    if(isNaN(x) || isNaN(n)) return false;
    var m=Math.pow(10,n);
    return Math.round(x*m)/m;
}
function rozrahunok(eventObj){
    var kl_gr=$("#kl_money").val();
    var sm_rc=$("#sm_rc").val();
    var sdacha=kl_gr-sm_rc;
    sdacha=roundPlus(sdacha,2);
    $("#reshta").val(sdacha);	
}    
</script>
<script>
$("html").keydown(function(eventObject){ 
  if (eventObject.keyCode == 32) { 
    document.getElementById("addroz").click();
  }
  if (eventObject.keyCode == 17) { 
    document.getElementById("kap").click();
  }
});
</script>
<form action="add_product_to_recipt.php" name="myform" method="post">
<table class="zmview">
<tr>
<th colspan="8" style="font-size: 26px;">Реалізація товару</th>
</tr>
<tr>
<td colspan="2">Штрих-код <input type="text" id="skod" name="skod" value="" required /></td>
<td>Кількість <input type="text" name="kol" value="1" size="7" required />
<input type="hidden" name="recipt" value="'.$recipt.'" size="7"/>
</td>
<td colspan="2">
<input id="r1" type="radio" name="money" value="Готівка" checked/><label for="r1">Готівка</label><br>
<input id="r2" type="radio" name="money" value="Карта" /><label for="r2">Карта</label><br>
</td>
<td align="center">Кас.ап.<br><input type="checkbox" id="kap" name="kap" value="1"></td>
<td align="center" colspan="2"><input type="submit" id="submit" value="Додати"/></td>
</tr>
<tr>
<th>№</th>
<th>Штрих-код</th>
<th>Назва</th>
<th>Вартість</th>
<th>Кількість</th>
<th>Всього</th>
<th>Видал.</th>
<th>Кас.ап.</th>
</tr>';
$npp=0;
$sql = "SELECT resipt_all.`ID`,resipt_all.`ID_RESIPT`,resipt_all.`SKOD`,resipt_all.`PRODUCT` AS ID_PROD,resipt_all.`KA`,
resipt_all.`PROVIDER`,product.NAIM AS PRODUCT,SUM(resipt_all.`NUMBER`) AS NUMBER,resipt_all.`SUM`,
resipt_all.`DT`,resipt_all.`STATUS` FROM resipt_all,product 
WHERE resipt_all.ID_RESIPT='$recipt' AND resipt_all.PRODUCT=product.ID AND product.DL='1' AND resipt_all.DL='1' 
GROUP BY resipt_all.SKOD ORDER BY resipt_all.ID DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$npp++;
if($aut["KA"] == '1') $pr_kap = 'так';
else $pr_kap = 'ні';
//---------------------------------
//$prihod = 0;
//$rashod = 0;
//$ostatok = 0;
//
//$sql2="SELECT `kl`,dt AS PR_BALANCE FROM `primary_balance` WHERE `id_product`='".$aut["ID_PROD"]."' ORDER BY dt DESC LIMIT 1";
//$atu2=mysql_query($sql2);
//  while($aut2=mysql_fetch_array($atu2))
//{
//    $prim_bal = $aut2["kl"];
//    $dt_bal = $aut2["PR_BALANCE"];
//}
//mysql_free_result($atu2);
//
//$sql2="SELECT SUM(`NUMBER`) AS PRIHOD FROM `store` WHERE `SKOD`='".$aut["SKOD"]."' AND DT>='$dt_bal' AND (`STATUS`='1' OR `STATUS`='4')";
//$atu2=mysql_query($sql2);
//  while($aut2=mysql_fetch_array($atu2))
// {
//      $prihod=(int)$aut2["PRIHOD"];
//}
//mysql_free_result($atu2);
//$sql2="SELECT SUM(`NUMBER`) AS RASHOD FROM `store` WHERE `SKOD`='".$aut["SKOD"]."' AND DT>='$dt_bal' AND (`STATUS`='2' OR `STATUS`='3')";
//$atu2=mysql_query($sql2);
//  while($aut2=mysql_fetch_array($atu2))
// {
//      $rashod=(int)$aut2["RASHOD"];
//}
//mysql_free_result($atu2);
//$ostatok = ($prim_bal + $prihod) - $rashod;
//---------------------------------

$p.='<tr">
<td align="center">'.$npp.'</td>	
<td align="center">'.$aut["SKOD"].'</td>	
<td>'.$aut["PRODUCT"].'</td>
<td align="right">'.$aut["SUM"].'</td>
<td align="right">'.$aut["NUMBER"].'</td>
<td align="right">'.number_format($aut["SUM"] * $aut["NUMBER"],2,'.', '').'</td>
<td><a href="#" class="go">
<input type="hidden" name="modal'.$aut["ID"].'" value="kl='.$aut["ID"].'&recipt='.$recipt.'&money='.$money.'"/>    
<img src="images/b_drop.png" border="0"></a></td>
<td align="center">'.$pr_kap.'</td>
</tr>';

$sm_recipt+=$aut["SUM"] * $aut["NUMBER"];

}
mysql_free_result($atu);
$sm_recipt=number_format($sm_recipt,2);
$p.='</form><tr class="vsogo"><th colspan="5" align="right">Всього по чеку:</th><th align="left" colspan="3"><input type="text" id="sm_rc" name="sm_rc" value="'.$sm_recipt.'" size="7" readonly/> грн.</th></tr>'
        . '<tr class="green"><th colspan="5" align="right">Гроші покупця:</th><th align="left" colspan="3"><input type="text" id="kl_money" name="kl_money" size="7" /> грн.</th></tr>'
        . '<tr class="yellow"><th colspan="5" align="right">Решта:</th><th align="left" colspan="3"><input type="text" id="reshta" name="reshta" size="7" readonly/> грн.</th></tr>'
        . '<tr><td colspan="8" align="center">'
        . '<form action="add_recipt_to_sklad.php" name="twoform" method="get">'
        . '<input type="hidden" name="recipt" value="'.$recipt.'"/>'
        . '<input type="hidden" id="man" name="man" value="'.$money.'"/>'
        . '<input style="font-size: 22px;" type="submit" id="addroz" value="Розрахувати"/>'
        . '</form>'
        . '</td></tr></table>';

$p .= '
<div id="modal_form"><!-- Сaмo oкнo --> 
<span id="modal_close">X</span> <!-- Кнoпкa зaкрыть --> 
<form action="del_product_recipt.php" method="get">
<h3>Підтвердіть видалення</h3>
<input type="hidden" id="modal_del" name="modal_del" value=""/>
Пароль: <input type="password" id="pasw" name="pasw" size="7" required />&nbsp&nbsp&nbsp
<input type="submit" value="Видалити"/>
</form>
</div>
<div id="overlay"></div><!-- Пoдлoжкa -->';
echo $p;
//. '<a href="add_recipt_to_sklad.php?recipt='.$recipt.'&money='.$money.'">'</a>
?>