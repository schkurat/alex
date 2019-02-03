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
                    var reply=html.split(":",4);
                    if(reply[0]!=''){
		$("#group_pr [value='"+reply[2]+"']").attr("selected",true);
                $("#namepr").val(reply[1]);	
                    }
		},
		error: function(html){alert(html.error);}
	});								
}             
</script>





<form action="add_product.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Внесення нового товару</th></tr>
<tr>
<td>Штрих-код: </td>
<td><input type="text" id="skod" name="skod" value=""/></td>
</tr>
<tr>
<td>Група:</td>
<td>
<select name="group_product" id="group_pr" required>
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
<td>Назва:</td>
<td><input id="namepr" name="name" type="text" size="50" value="" required /></td>
</tr>
<tr>
<td>Ціна:</td>
<td><input id="cost" name="cost" type="text" value="" required/></td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Додати" /></td>
</tr>
</table>
</form>