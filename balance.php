<?php
include_once "function.php";
$group = (empty($_GET['group'])) ? '' : $_GET['group'];

$p='
<script>
function showEdit(editableObj) {
    $(editableObj).css("background","#FFF");
} 

function saveToDatabase(editableObj,column,id) {
    $(editableObj).css("background","#FFF url(images/loaderIcon.gif) no-repeat right");
    $.ajax({
	url: "saveedit.php",
	type: "POST",
	data:`column=`+column+`&editval=`+editableObj.innerHTML+`&id=`+id,
	success: function(data){
            $(editableObj).css("background","yellow");
        }        
    });
}
</script>
<script language="JavaScript">
$(document).ready(function() {
    $("#skod").focus();
    $("#group").change(function(){
        let selectedGroup = $(this).children("option:selected").val();
        window.location.replace("/store.php?filter=balance&group=" + selectedGroup);
   });
});
</script>
<form action="add_revision.php" name="myform" method="post">
<table class="zmview">
<tr>
<th><a href="balance_print.php"><img src="images/print.png" border="0"></a></th>
<th colspan="7">Ревізія</th>
</tr>
<tr>
<td colspan="2">Штрих-код <input type="text" id="skod" name="skod" value="" required /></td>
<td>Кількість <input type="text" name="kol" value="" size="7" required />
<input type="submit" id="submit" value="Додати"/>
</td>
<td colspan="5" align="center">
Група
<select name="group" id="group">
   <option value="">Всі</option>';
   $sql = "SELECT ID,NAIM FROM group_product WHERE DL='1' AND NAIM > '' ORDER BY NAIM";
   $atu = mysql_query($sql);
   while ($aut = mysql_fetch_array($atu)) {
       if($group == $aut["ID"]){
           $p .= '<option value="' . $aut["ID"] . '" selected>' . $aut["NAIM"] . '</option>';
       }else{
           $p .= '<option value="' . $aut["ID"] . '">' . $aut["NAIM"] . '</option>';
       }
   }
   mysql_free_result($atu);
   $p .= '</select>
</td>
</tr>
<tr>
<th>№</th>
<th>Штрих-код</th>
<th>Назва</th>
<th>Залишок</th>
<th>Сума залишка</th>
<th>Перевірено</th>
<th>Невистачає</th>
<th>Сума нодостачі</th>
</tr>';
   $flag = (empty($group)) ? '' : "AND product.GROUP='" . $group . "'";
$npp=0;
$sql = "SELECT balance.*,product.NAIM AS PRODUCT FROM balance,product 
	WHERE balance.id_product=product.ID AND product.DL='1' " . $flag . " AND (balance.kl + balance.rev)!=0 ORDER BY balance.dt_rev DESC";
//echo $sql; AND (balance.kl + balance.rev)!=0
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$npp++;
$id_bl=$aut["id"];
$kol=$aut["kl"];
$rev=$aut["rev"];
$rizn=$aut["kl"]-$aut["rev"];
if($kol!=$rev) $stl="bad_balance";
else $stl="good_balance";
$p.='<tr class="'.$stl.'">
<td align="center">'.$npp.'</td>	
<td align="center">'.$aut["skod"].'</td>	
<td>'.$aut["PRODUCT"].'</td>
<td contenteditable="true" align="center" onBlur="saveToDatabase(this,`kl`,'.$id_bl.')" onClick="showEdit(this);">'.$aut["kl"].'</td>
<td align="center">'.number_format($aut["sm"], 2, ',' , '').'</td>
<td contenteditable="true" align="center" onBlur="saveToDatabase(this,`rev`,'.$id_bl.')" onClick="showEdit(this);">'.number_format($aut["rev"], 2, ',' , '').'</td>
<td align="center">'.$rizn.'</td>
<td align="center">'.$rizn*$aut["sm"].'</td> 
</tr>';
$sum_rev += $aut["rev"]*$aut["sm"];
$sumrsum+=$rizn*$aut["sm"];
}
//$aut["rsm"]
mysql_free_result($atu);
$p.='<tr><td colspan="4" align="right">Cума залишку товару в магазині:</td><td align="right" colspan="2">'.$sum_rev.'</td><td>Нестача:</td><td>'.$sumrsum.' грн.</td></tr></table></form>';
echo $p;
?>