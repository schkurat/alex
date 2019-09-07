<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2" align="center">Накладні за період</th>
        </tr>
        <tr>
            <td>Період</td>
            <td>
                <input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/> -
                <input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="invoice_view"/>
            </td>
        </tr>
        <tr>
            <td>Тип періоду</td>
            <td>
                <input id="r0" type="radio" name="typePeriod" value="0" checked/><label for="r0">Накладна</label>
                <input id="r1" type="radio" name="typePeriod" value="1"/><label for="r1">Оплата</label>
            </td>
        </tr>
        <tr>
            <td>
                Постачальник
            </td>
            <td>
                <select name="provider">
                    <option value=""></option>
                    <?php
                    $p = '';
                    $sql = "SELECT ID,NAIM FROM provider WHERE DL='1' ORDER BY NAIM";
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