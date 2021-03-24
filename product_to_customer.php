<?php
include_once "function.php";

//$money=$_GET['money'];
//$cash='';
//$card='';
//if($money=='Готівка') $cash='checked';
//else $card='checked';
if (isset($_GET['recipt'])) $recipt = $_GET['recipt'];
else {
    $ath1 = mysql_query("INSERT INTO resipt(`DT`,`SELLER`,`MONEY`) VALUES(NOW(),'$lg','$money');");
    if (!$ath1) {
        echo "Запис не внесений до БД";
    }
    $recipt = mysql_insert_id();
}
$sm_recipt = 0;
$seller = (isset($_GET['seller']) && !empty($_GET['seller']))? '<b>Продає:</b> ' . $_GET['seller']: '';
$customer = (isset($_GET['customer']) && !empty($_GET['customer']))? '<b>Купує:</b> ' . $_GET['customer']: '';

$p = '
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
<th colspan="9" style="font-size: 26px;">Реалізація товару</th>
</tr>
<tr>
<td colspan="2">Штрих-код <input type="text" id="skod" name="skod" value="" required /></td>
<td>Кількість <input type="text" name="kol" value="1" size="7" required />
<input type="hidden" name="recipt" value="' . $recipt . '" size="15"/>
</td>
<td colspan="3">
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
<th>Бонусна</th>
<th>Кількість</th>
<th>Всього</th>
<th>Видал.</th>
<th>Кас.ап.</th>
</tr>';
$npp = 0;
$sql = "SELECT resipt_all.`ID`,resipt_all.`ID_RESIPT`,resipt_all.`SKOD`,resipt_all.`PRODUCT` AS ID_PROD,resipt_all.`KA`,
resipt_all.`PROVIDER`,product.NAIM AS PRODUCT,SUM(resipt_all.`NUMBER`) AS NUMBER,resipt_all.`SUM`,resipt_all.`SUM_BONUS`,
resipt_all.`DT`,resipt_all.`STATUS` FROM resipt_all,product 
WHERE resipt_all.ID_RESIPT='$recipt' AND resipt_all.PRODUCT=product.ID AND product.DL='1' AND resipt_all.DL='1' 
GROUP BY resipt_all.SKOD ORDER BY resipt_all.ID DESC";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $npp++;
    if ($aut["KA"] == '1') $pr_kap = 'так';
    else $pr_kap = 'ні';

    $all_item = ($aut["SUM_BONUS"] > 0)? $aut["SUM_BONUS"] * $aut["NUMBER"]: $aut["SUM"] * $aut["NUMBER"];

    $p .= '<tr">
<td align="center">' . $npp . '</td>	
<td align="center">' . $aut["SKOD"] . '</td>	
<td>' . $aut["PRODUCT"] . '</td>
<td align="right">' . $aut["SUM"] . '</td>
<td align="right">' . $aut["SUM_BONUS"] . '</td>
<td align="right">' . $aut["NUMBER"] . '</td>
<td align="right">' . number_format($all_item, 2, '.', '') . '</td>
<td><a href="#" class="go">
<input type="hidden" name="modal' . $aut["ID"] . '" value="kl=' . $aut["ID"] . '&recipt=' . $recipt . '&money=' . $money . '"/>    
<img src="images/b_drop.png" border="0"></a></td>
<td align="center">' . $pr_kap . '</td>
</tr>';

    $sm_recipt += $all_item;

}
mysql_free_result($atu);
$sm_recipt = number_format($sm_recipt, 2);
$p .= '</form><tr class="vsogo"><th colspan="6" align="right">Всього по чеку:</th><th align="left" colspan="3"><input type="text" id="sm_rc" name="sm_rc" value="' . $sm_recipt . '" size="7" readonly/> грн.</th></tr>'
    . '<tr class="green"><th colspan="6" align="right">Гроші покупця:</th><th align="left" colspan="3"><input type="text" id="kl_money" name="kl_money" size="7" /> грн.</th></tr>'
    . '<tr class="yellow"><th colspan="6" align="right">Решта:</th><th align="left" colspan="3"><input type="text" id="reshta" name="reshta" size="7" readonly/> грн.</th></tr>'
    . '<tr><td colspan="9" align="center" style="background: orange;">Кредит</td></tr>'
    . '<tr><td colspan="9">'
    . '<form action="check_credit.php" name="myformnext" method="post" style="margin: 0;">'
    . 'Продав: <input type="password" name="kr_seller" size="10" value=""> '
    . 'Купив: <input type="password" name="kr_customer" size="10" value=""> <input type="hidden" name="receipt" value="' . $recipt . '" size="15"/>'
    . '<input id="check_kredit" type="submit" value="Застосувати"> <p id="kr_result" style="margin: auto;">'. $seller .' ' . $customer . '</p>'
    . '</form></td></tr>'
    . '<tr><td colspan="9" align="center">'
    . '<form action="add_recipt_to_sklad.php" name="twoform" method="get">'
    . '<input type="hidden" name="recipt" value="' . $recipt . '"/>'
    . '<input type="hidden" id="man" name="man" value="' . $money . '"/>'
    . '<input style="font-size: 22px;margin-top: 20px;" type="submit" id="addroz" value="Розрахувати"/>'
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
