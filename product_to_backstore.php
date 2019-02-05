<?php
include "function.php";
include "scriptu.php";
?>
<script type="text/javascript">
$(document).ready(function(){
		$('#skod').bind('blur',net_fokusa);
		}); 
function net_fokusa(eventObj){
	$.ajax({
		type: "POST",
		url: "find_product.php",
		data: 'kod='+ $("#skod").val(),
		dataType: "html",
		success: function(html){
                    var reply=html.split(":",3);
                    if(reply[0]!=''){
                    $("#new_pr").fadeOut();
                    $("#old_pr").fadeIn(1500);
                    $("#sprod").val(reply[0]);
                    $("#group_pr").val(reply[2]);
                    $("#group_pr").change(function(){adjustProduct();}).change();
                    $("#provider").focus();}
                    else{
                        $("#old_pr").fadeOut();
                        $("#new_pr").fadeIn(1500);
                    }
		},
		error: function(html){alert(html.error);}
	});								
}             
</script>
<form action="add_sklad.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="2" style="font-size: 35px;"><b>Повернення товару від клієнта</b></th></tr>
<tr>
<td>Дата:</td>
<td>
<input type="text" class="datepicker" size="10" maxlength="10" name="dt" value="<?php echo date("d.m.Y"); ?>" />
Час: <input type="text" size="8" maxlength="8" name="time_back" value="<?php echo date("H:i:s"); ?>" />
</td>
</tr>
<tr>
<td>Штрих-код: </td>
<td><input type="text" id="skod" name="skod" value=""/></td>
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
 echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
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
        <select id="product" name="product" class="sel_ad" disabled="disabled"></select>
    </div>
 <!--   <div id="new_pr" style="display: none;">
        <input type="text" name="new_product" id="sprod" value=""/>  
    </div>-->
</td>
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
 echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr>
<td>Кількість товару:</td>
<td>
    <input type="text" name="klprod" value=""/>
<input type="hidden" name="stat" value="4"/>
</td>
</tr>
<tr>
<td>Сума повернення:</td>
<td>
    <input type="text" name="smpover" value=""/>
</td>
</tr>
<tr>
<td colspan="2" align="center">
    <input type="submit" id="submit" value="Забрати у клієнта">
</td>
</tr>
</table>
</form>