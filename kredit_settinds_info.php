<?php
$sql = "SELECT * FROM kredit_settings";
$persent = 0;
$sum_bill = 0;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $persent = $aut["persent"];
    $sum_bill = $aut["sum_bill"];
}
mysql_free_result($atu);
?>
<form action="update_kredit_settings.php" name="myform" method="post">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2" align="center">Налаштуваня кредитів</th>
        </tr>
        <tr>
            <td>Відсоток від прибутку:</td>
            <td><input name="pr_kred" type="text" size="2" value="<?= $persent ?>"/></td>
        </tr>
        <tr>
            <td>Сума чеку:</td>
            <td><input name="sum_kred" type="text" size="10" value="<?= $sum_bill ?>"/></td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <input name="Ok" type="submit" style="width:80px" value="Зберегти"/>
            </td>
        </tr>
    </table>
</form>