<?php
include "function.php";
include "scriptu.php";
?>
<body>
<script language="JavaScript">
$(function() {
	$(".datepicker").datepicker("setDate", "");
	});
</script>
<form enctype="multipart/form-data" action="add_invoice.php" name="myform" method="post">
<table align="" class="zmview">
    <tr>
        <th colspan="2" style="font-size: 35px;"><b>Нова накладна</b></th>
    </tr>
    <tr>
        <td>Дата накладної:</td>
        <td><input type="text" size="10" maxlength="10" name="dt" value="<?php echo date("d.m.Y"); ?>" readonly /></td>
    </tr>
    <tr>
        <td>Номер накладної: </td>
        <td><input type="text" name="num_invoice" value=""/></td>
    </tr>
    <tr>
        <td>Постачальник: </td>
        <td>
            <select name="provider" required>
                <option value="">Оберіть постачальника</option>
                <?php
                $sql = "SELECT ID,NAIM FROM provider WHERE DL=1 ORDER BY NAIM";
                $atu = mysql_query($sql);
                while($aut = mysql_fetch_array($atu)){
                    echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
                }
                mysql_free_result($atu);
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Із залишку: </td>
        <td><input type="text" name="smbal" value=""/></td>
    </tr>
    <tr>
        <td>З готівки:</td>
        <td><input type="text" name="smcash" value=""/></td>
    </tr>
    <tr>
        <td>Дата розрахунку:</td>
        <td><input id="date" class="datepicker" name="dtmoney" type="text" size="10" maxlength="10" value="" /></td>
    </tr>
    <tr>
        <td>Cума постачальника:</td>
        <td><input type="text" name="smprov" value=""/></td>
    </tr>
    <!--<tr>
    <td>Надійшло товару:</td>
    <td><input type="text" name="smgot" value=""/></td>
    </tr>-->
    <tr>
        <td>Копія накладної:</td>
        <td>
            <input type="file" name="file[]" multiple='true' /><br>
            <label style="color: black; font-size:12px;">Тільки для файлів jpg, jpeg, gif та png</label>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" id="submit" value="Створити"></td>
    </tr>
</table>
</form>