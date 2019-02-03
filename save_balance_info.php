<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
    <table align="center" class="zmview">
    <tr>
        <th colspan="2" align="center">Збереження поточних залишків</th>
    </tr>
    <tr>
        <td>Група:</td>
        <td>
            <select name="group_product" id="group_pr" required>
                <option value="">Оберіть групу</option>
                <?php
                $sql = "SELECT ID,NAIM FROM group_product WHERE DL=1 ORDER BY NAIM";
                $atu=mysql_query($sql);
                while($aut=mysql_fetch_array($atu)){
                    echo '<option value="'.$aut["ID"].'">'.$aut["NAIM"].'</option>';
                }
                mysql_free_result($atu);
                ?>
            </select>
            <input name="filter" type="hidden" value="revision_save"/>
        </td>
    </tr>
    <!--<tr>
    <td>Дата перевірки:</td>
    <td>
    <input id="date" class="datepicker" name="dt_rev" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" />
    </td>
    </tr>
    <tr>
    <td>Час перевірки:</td>
    <td>
    <input id="time1" name="time1" type="text" size="8" maxlength="8" value="<?php echo date("H:i:s");?>" />
    </td>
    </tr>-->
    <tr>
        <td align="center" colspan="2">
            <input name="Ok" type="submit" value="Зберегти" />
        </td>
    </tr>
    </table>
</form>