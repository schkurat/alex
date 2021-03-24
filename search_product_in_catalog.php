<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$p = '<table class="zmview">
    <tr>
        <th class="add_record" colspan="2"><a href="store.php?filter=new_product"><img src="images/add.png" border="0"></a>
        </th>
        <th>№</th>
        <th>Штрих-код</th>
        <th>Назва</th>
        <th>Ціна</th>
        <th>Група</th>
    </tr>';

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(magazin, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
$filter = '';
if (isset($_POST['code']) && !empty($_POST['code'])){
    $filter .= (empty($filter))? "LOCATE('" . trim($_POST['code']). "', product.SKOD)!=0": " AND LOCATE('" . trim($_POST['code']). "', product.SKOD)!=0";
}
if (isset($_POST['product']) && !empty($_POST['product'])){
    $filter .= (empty($filter))? "LOCATE('" . trim($_POST['product']). "', product.NAIM)!=0": " AND LOCATE('" . trim($_POST['product']). "', product.NAIM)!=0";
}
if (isset($_POST['group']) && !empty($_POST['group'])){
    $filter .= (empty($filter))? "LOCATE('" . trim($_POST['group']). "', group_product.NAIM)!=0": " AND LOCATE('" . trim($_POST['group']). "', group_product.NAIM)!=0";
}

if (!empty($filter)) {
    $sql = "SELECT product.ID,product.SKOD,product.NAIM AS PROD,product.cost,group_product.NAIM AS GR FROM product,group_product 
WHERE " . $filter . " AND product.DL='1' AND group_product.DL='1' AND product.GROUP=group_product.ID 
ORDER BY group_product.NAIM COLLATE utf8_unicode_ci,product.NAIM COLLATE utf8_unicode_ci";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $p .= '<tr>
            <td align="center"><a href="store.php?filter=edit_product&kl=' . $aut["ID"] . '"><img src="images/b_edit.png"
                                                                                                 border="0"></a></td>
            <td>
                <a href="print_kod.php?scd=' . $aut["SKOD"] . '&size=3"><img src="images/print.png"
                                                                            border="0">2x3</a><br>
                <a href="print_kod.php?scd=' . $aut["SKOD"] . '&size=4"><img src="images/print.png" border="0">2.5x4</a>
            </td>
            <td align="center">' . $aut["ID"] . '</td>
            <td>' . $aut["SKOD"] . '</td>
            <td>' . $aut["PROD"] . '</td>
            <td>' . $aut["cost"] . '</td>
            <td>' . $aut["GR"] . '</td>
        </tr>';
    }

    if (mysql_close($db)) {
    } else {
        echo("Не можливо виконати закриття бази");
    }
} else {
    $p .= '<tr><td colspan="6">Відсутній критерій пошуку</td></tr>';
}
$p .= '</table>';
echo $p;
