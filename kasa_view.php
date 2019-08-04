<?php
include_once "function.php";
$npr = date_bd($_GET['npr']) . ' 00:00:00';
$kpr = date_bd($_GET['kpr']) . ' 23:59:59';
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Готівка розахунок</th>
        <th scope="col">Термінал розахунок</th>
        <th scope="col">Готівка фактична</th>
        <th scope="col">Термінал фактично</th>
        <th scope="col">Всього</th>
        <th scope="col">Вал</th>
        <th scope="col">Зарплата</th>
        <th scope="col">Дата та час закриття</th>
    </tr>
    <thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM earnings WHERE DT>='$npr' AND DT<='$kpr' ORDER BY `DT` DESC";
    //echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {

        ?>
        <tr>
            <td><?= $aut["NAL"] ?></td>
            <td><?= $aut["TERM"] ?></td>
            <td><?= $aut["NAL_FACT"] ?></td>
            <td><?= $aut["TERM_FACT"] ?></td>
            <td><?= round(($aut["NAL_FACT"] + $aut["TERM_FACT"]) - ($aut["NAL"] + $aut["TERM"]), 2) ?></td>
            <td><?= $aut["SM_SALARY"] ?></td>
            <td><?= $aut["SALARY"] ?></td>
            <td><?= $aut["DT"] ?></td>
        </tr>
        <?php
    }
    mysql_free_result($atu);
    ?>
    </tbody>
</table>
