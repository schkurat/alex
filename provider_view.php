<?php
include_once "function.php";
?>
<table class="zmview">
    <tr>
        <th class="add_record"><a href="store.php?filter=new_provider"><img src="images/add.png" border="0"></a></th>
        <th>Назва</th>
        <th>Відсоток</th>
        <th>Статус</th>
    </tr>
    <?php
    $sql = "SELECT * FROM provider ORDER BY NAIM COLLATE utf8_unicode_ci";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $status = ($aut["DL"] == '1') ? 'green' : 'red';
        ?>
        <tr>
            <td align="center"><a href="store.php?filter=edit_provider&kl=<?= $aut["ID"] ?>"><img
                            src="images/b_edit.png" border="0"></a></td>
            <td><?= htmlspecialchars($aut["NAIM"], ENT_QUOTES) ?></td>
            <td align="center"><?= $aut["PR"] ?>%</td>
            <td align="center">
                <a href="change_provider_status.php?kl=<?= $aut["ID"] ?>&st=<?= $aut["DL"] ?>">
                    <i class="fal fa-user" style="color: <?= $status ?>"></i>
                </a>
            </td>
        </tr>
        <?php
    }
    mysql_free_result($atu);
    ?>
</table>