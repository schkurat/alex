<?php
include "function.php";
include "scriptu.php";

$kl=$_GET['kl'];
if(isset($_GET['invoice'])) $invoice = $_GET['invoice']; else $invoice = 0;
$sql = "SELECT store.*,product.GROUP,group_product.PR FROM store,product,group_product "
        . "WHERE store.DL=1 and store.ID='$kl' AND store.PRODUCT=product.ID AND group_product.ID=product.GROUP";
$atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
    $skod=$aut["SKOD"];
    $provider=$aut["PROVIDER"];
    $group=$aut["GROUP"];
    $prod=$aut["PRODUCT"];
    $number=$aut["NUMBER"];
    $opt=$aut["OPT"];
    $sum=$aut["SUM"];
    $dt=german_date($aut["DT"]);
    $stat=$aut["STATUS"];
    $persent=$aut["PR"];
 }
mysql_free_result($atu);
?>
<script type="text/javascript">
$(document).ready(function(){
		$('#skod').bind('blur',net_fokusa);
                $('#smopt').keyup(natsenka);
                $("#persent").keyup(natsenka);
				$("#skod").focus();
               // $('#smopt').bind('blur',natsenka);
		}); 
function roundPlus(x,n){
    if(isNaN(x) || isNaN(n)) return false;
    var m=Math.pow(10,n);
    return Math.round(x*m)/m;
}
function natsenka(eventObj){
    var smopt=$("#smopt").val();
    var pers=$("#persent").val();
    var nats=smopt*((pers/100)+1);
    nats=roundPlus(nats,2);
	$("#smprod").val(nats);	
}               
function net_fokusa(eventObj){
	$.ajax({
		type: "POST",
		url: "find_product.php",
		data: 'kod='+ $("#skod").val(),
		dataType: "html",
		success: function(html){
                    var reply=html.split(":",4);
                    if(reply[0]!=''){
                    $("#new_pr").fadeOut();
                    $("#old_pr").fadeIn(1500);
                    $("#sprod").val(reply[0]);
                    $("#group_pr").val(reply[2]);
                    $("#persent").val(reply[3]);
                    $("#group_pr").change(function(){adjustProduct();}).change();
                    $("#provider").focus();}
                    else{
                        $("#old_pr").fadeOut();
                        $("#new_pr").fadeIn(1500);
						
						$("#group_pr").val(reply[2]);
                    }
		},
		error: function(html){alert(html.error);}
	});								
}             
</script>
<?php 
switch ($stat){
    case 1:
    $title='Надходження товару на склад';
    $name_fild='Надійшло товару:';
    $name_button='Редагувати';
    break;
    /*case 2:
    $title='Реалізація товару';
    $name_fild='Продано товару:';
    $name_button='Продати';
    break;*/
    case 3:
    $title='Списання товару';
    $name_fild='Списано товару:';
    $name_button='Списати';
    break;
}
?>
<form action="update_sklad.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b><?php echo $title ?></b></th></tr>
<!--<tr>
<td>Дата:</td>
<td>
<input type="text" class="datepicker" size="10" maxlength="10" name="dt" value="<?php echo date("d.m.Y"); ?>" /></td>
</tr>-->
<tr>
<td>Штрих-код: </td>
<td><input type="text" id="skod" name="skod" value="<?php echo $skod; ?>"/></td>
</tr>
<tr>
<td>Постачальник: </td>
<td>
<select name="provider" id="provider" class="sel_ad" required>
<option value="">Оберіть постачальника</option>
<?php
$sql = "SELECT ID,NAIM FROM provider WHERE DL=1 ORDER BY NAIM";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
    if($aut["ID"]==$provider){
        echo '<option selected value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
    }
    else{
        echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
    }
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr>
<td>Група товара:</td>
<td>
    <select name="group_pr" id="group_pr" class="sel_ad" required>
<option value="">Оберіть групу</option>
<?php
$sql = "SELECT ID,NAIM FROM group_product WHERE DL=1 ORDER BY NAIM"; 
$atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
    if($aut["ID"]==$group){
        echo '<option selected value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
    }
    else{
        echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
    }
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr>
<td>Товар:</td>
<td>
    <div id="old_pr">
    <input type="hidden" name="sprod" id="sprod" value=""/>    
    <select id="product" name="product" class="sel_ad">
    <option value="">Оберіть товар</option>
<?php
$sql = "SELECT ID,NAIM FROM product WHERE DL='1' AND `GROUP`='$group' ORDER BY NAIM";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
    if($prod==$aut["ID"]){
        echo '<option selected value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
    }
    else{
        echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
    }
 }
mysql_free_result($atu);
?>
    </select>
    </div>
    <div id="new_pr" style="display: none;">
        <input type="text" name="new_product" id="sprod" value=""/>  
    </div>
</td>
</tr>
<tr>
<td><?php echo $name_fild; ?></td>
<td><input type="text" name="klprod" value="<?php echo $number; ?>"/></td>
</tr>
<tr>
<td>Відсоток націнки</td>
<td>
    <input type="text" id="persent" name="persent" size="2" value="<?php echo $persent; ?>"/>
</td>
</tr>
<tr>
<td>Ціна за одиницю (опт.):</td>
<td>
    <input type="text" id="smopt" name="smopt" value="<?php echo $opt; ?>"/>
</td>
</tr>
<tr>
<td>Ціна за одиницю (розд.):</td>
<td>
    <input type="text" id="smprod" name="smprod" value="<?php echo $sum; ?>"/>
<!--    <input type="hidden" name="stat" value="<?php echo $stat; ?>"/>-->
    <input type="hidden" name="kl" value="<?php echo $kl; ?>"/>
    <input type="hidden" name="invoice" value="<?php echo $invoice; ?>"/>
</td>
</tr>
<tr>
<td colspan="2" align="center">
    <input type="submit" id="submit" value="<?php echo $name_button; ?>">
</td>
</tr>
</table>
</form>