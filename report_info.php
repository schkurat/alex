<?php
include "scriptu.php";
?>
<form action="store.php" name="myform" method="get">
    <table align="center" class="table col-md-4">
        <thead>
        <tr class="table-primary">
            <th scope="col" colspan="2">Звіт за період</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Період</td>
            <td>
                <input id="date" class="datepicker" name="npr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/> -
                <input id="date1" class="datepicker" name="kpr" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="report_view"/>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <input name="Ok" type="submit" value="Пошук"/></td>
        </tr>
        </tbody>
    </table>
</form>