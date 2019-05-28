<?php
include_once "function.php";

//$p='
//<table class="zmview">
//<tr>
//<th>Готівка розахунок</th>
//<th>Термінал розахунок</th>
//<th>Готівка фактична</th>
//<th>Термінал фактично</th>
//<th>Дата та час закриття</th>
//</tr>';
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Готівка розахунок</th>
        <th scope="col">Термінал розахунок</th>
        <th scope="col">Готівка фактична</th>
        <th scope="col">Термінал фактично</th>
        <th scope="col">Дата та час закриття</th>
    </tr>
    <thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM earnings ORDER BY `DT` DESC";
    //echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {

//$p.='<tr>
//    <td align="right">'.$aut["NAL"].'</td>
//    <td align="right">'.$aut["TERM"].'</td>
//    <td align="right">'.$aut["NAL_FACT"].'</td>
//    <td align="right">'.$aut["TERM_FACT"].'</td>
//    <td align="right">'.$aut["DT"].'</td>
//    </tr>';
        ?>
        <tr>
            <td><?= $aut["NAL"] ?></td>
            <td><?= $aut["TERM"] ?></td>
            <td><?= $aut["NAL_FACT"] ?></td>
            <td><?= $aut["TERM_FACT"] ?></td>
            <td><?= $aut["DT"] ?></td>
        </tr>
        <?php
    }
    mysql_free_result($atu);
    ?>
    </tbody>
</table>
<!--$p.='</table>';-->
<!--echo $p;-->
