<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2" align="center">Залишки груп за період</th>
        </tr>
        <tr>
            <td>Період</td>
            <td>
                <input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/> -
                <input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="control_view"/>
            </td>
        </tr>
        <tr>
            <td>
                Група
            </td>
            <td>
                <select name="group_product">
                    <option value=""></option>
                    <?php
                    $p = '';
                    $sql = "SELECT ID,NAIM FROM group_product WHERE DL='1' AND NAIM!='' ORDER BY NAIM";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $p .= '<option value="' . $aut["ID"] . '">' . $aut["NAIM"] . '</option>';
                    }
                    mysql_free_result($atu);
                    $p .= '</select>';
                    echo $p;
                    ?>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <input name="Ok" type="submit" value="Пошук"/></td>
        </tr>
    </table>
</form>