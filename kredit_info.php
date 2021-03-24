<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2" align="center">Кредити за період</th>
        </tr>
        <tr>
            <td>Період</td>
            <td>
                <input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/> -
                <input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="kredit_view"/>
            </td>
        </tr>
        <tr>
            <td>
                Робітник
            </td>
            <td>
                <select name="robitnuk">
                    <option value=""></option>
                    <?php
                    $p = '';
                    $sql = "SELECT ID,PR,IM,PB FROM users WHERE DL='1' AND ID>1 ORDER BY PR";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $p .= '<option value="' . $aut["ID"] . '">' . $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"] . '</option>';
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