<?php
include "function.php";
include "scriptu.php";
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#skod').bind('blur', net_fokusa);
            $('#smopt').keyup(natsenka);
            $("#persent").keyup(natsenka);
//    $("#smprod").keyup(optovaya);
            $("#skod").focus();
            $("#group_pr").change(persent);
            $("#new_product").keyup(function () {
                var box = $(this).val();
                var main = box.length * 100;
                var value = (main / 20);
                var count = 20 - box.length;
                if (box.length <= 20) {
                    $('#count').html(count);
                    $('#bar').animate({"width": value + '%',}, 1);
                } else {
                    //  alert('Назва товару перевищує 20 символів!');
                }
                return false;
            });
        });

        function roundPlus(x, n) {
            if (isNaN(x) || isNaN(n)) return false;
            var m = Math.pow(10, n);
            var z = Math.round(x * m) / m;
            return z.toFixed(2);
        }

        function persent(eventObj) {
            $.ajax({
                type: "POST",
                url: "find_persent.php",
                data: 'kod=' + $("#group_pr").val(),
                dataType: "html",
                success: function (html) {
                    var reply = html;
                    $("#persent").val(html);
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }

        function natsenka(eventObj) {
            var smopt = $("#smopt").val();
            var pers = $("#persent").val();
            var nats = smopt * ((pers / 100) + 1);
            nats = roundPlus(nats, 1);
            $("#smprod").val(nats);
        }

        //function optovaya(eventObj){
        //    var postav = $("#provider").val();
        //    if(postav == 36){
        //        var sm_prod = $("#smprod").val()*100;
        //        var prots = parseInt($("#persent").val())+100;
        //        var sm_opt = sm_prod/prots;
        //        sm_opt = roundPlus(sm_opt,2);
        //	$("#smopt").val(sm_opt);
        //    }
        //}
        function net_fokusa(eventObj) {
            $.ajax({
                type: "POST",
                url: "find_product.php",
                data: 'kod=' + $("#skod").val(),
                dataType: "html",
                success: function (html) {
                    var reply = html.split(":", 5);
                    if (reply[0] != '') {
                        $("#new_pr").fadeOut();
                        $("#old_pr").fadeIn(1500);
                        $("#sprod").val(reply[0]);
                        $("#group_pr").val(reply[2]);
                        $("#persent").val(reply[3]);
                        $("#costprice").val(reply[4]);
                        $("#group_pr").change(function () {
                            adjustProduct();
                        }).change();
                        $("#provider").focus();
                    } else {
                        $("#old_pr").fadeOut();
                        $("#new_pr").fadeIn(1500);
                        $("#group_pr").val(reply[2]);
                        $("#costprice").val(reply[4]);
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }
    </script>
<?php
$stat = $_GET['stat'];
switch ($stat) {
    case 1:
        $title = 'Надходження товару на склад';
        $name_fild = 'Надійшло товару:';
        $name_button = 'Додати';
        $invoice = $_GET['invoice'];
        if (isset($_GET['message'])) echo '<h1>Товар з оптовою ціною ' . $_GET['message'] . 'грн. успішно занесений до бази!</h1>';
        break;
    /*case 2:
    $title='Реалізація товару';
    $name_fild='Продано товару:';
    $name_button='Продати';
    break;*/
    case 3:
        $title = 'Списання товару';
        $name_fild = 'Списано товару:';
        $name_button = 'Списати';
        $bl_hid = 'style="display: none;"';
        break;
}
?>
    <div style="display: block;float: left;">
        <form action="add_sklad.php" name="myform" method="post">
            <table align="" class="zmview">
                <tr>
                    <th colspan="2" style="font-size: 35px;"><b><?php echo $title ?></b></th>
                </tr>
                <tr>
                    <td>Дата:</td>
                    <td>
                        <input type="text" class="datepicker" size="10" maxlength="10" name="dt"
                               value="<?php echo date("d.m.Y"); ?>"/>
                    </td>
                </tr>
                <tr <?php echo $bl_hid; ?>>
                    <td>Накладна</td>
                    <td>
                        <input type="text" id="invoice" name="invoice" size="5" value="<?php echo $invoice; ?>"
                               readonly/>
                    </td>
                </tr>
                <tr>
                    <td>Штрих-код:</td>
                    <td><input type="text" id="skod" name="skod" value=""/></td>
                </tr>
                <tr>
                    <td>Постачальник:</td>
                    <td>
                        <select name="provider" id="provider" class="sel_ad" required>
                            <option value="">Оберіть постачальника</option>
                            <?php
                            $sql = "SELECT PROVIDER FROM store WHERE DL=1 AND STATUS='1' ORDER BY ID DESC LIMIT 1";
                            $atu = mysql_query($sql);
                            while ($aut = mysql_fetch_array($atu)) {
                                $last_provider = $aut["PROVIDER"];
                            }
                            mysql_free_result($atu);

                            $sql = "SELECT ID,NAIM FROM provider WHERE DL=1 ORDER BY NAIM";
                            $atu = mysql_query($sql);
                            while ($aut = mysql_fetch_array($atu)) {
                                if ($aut["ID"] == $last_provider) echo '<option selected value="' . $aut["ID"] . '">' . $aut["NAIM"] . '</option>';
                                else echo '<option value="' . $aut["ID"] . '">' . $aut["NAIM"] . '</option>';
                            }
                            mysql_free_result($atu);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Група товара:</td>
                    <td>
                        <select name="group_pr" id="group_pr" class="sel_ad" required>
                            <option value="">Оберіть групу</option>
                            <?php
                            $sql = "SELECT ID,NAIM FROM group_product WHERE DL=1 ORDER BY NAIM";
                            $atu = mysql_query($sql);
                            while ($aut = mysql_fetch_array($atu)) {
                                echo '<option value="' . $aut["ID"] . '">' . $aut["NAIM"] . '</option>';
                            }
                            mysql_free_result($atu);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Товар:</td>
                    <td>
                        <div id="old_pr">
                            <input type="hidden" name="sprod" id="sprod" value=""/>
                            <select id="product" name="product" class="sel_ad" disabled="disabled"></select>
                        </div>
                        <div id="new_pr" style="display: none; width: 300px;">
                            <input type="text" name="new_product" id="new_product" value=""/>
                            <div id="barbox">
                                <div id="bar"></div>
                            </div>
                            <div id="count">20</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $name_fild; ?></td>
                    <td><input type="text" name="klprod" value="" required/></td>
                </tr>
                <tr <?php echo $bl_hid; ?>>
                    <td>Відсоток націнки</td>
                    <td>
                        <input type="text" id="persent" name="persent" size="2" value="0" readonly disabled/>
                    </td>
                </tr>
                <tr <?php echo $bl_hid; ?>>
                    <td>Ціна за одиницю (опт.):</td>
                    <td>
                        <input type="text" id="smopt" name="smopt" value="" required/>
                    </td>
                </tr>
                <tr <?php echo $bl_hid; ?>>
                    <td>Ціна за одиницю (розд.):</td>
                    <td>
                        <input type="text" id="smprod" name="smprod" value="" required/>
                        Ціна в каталозі
                        <input style="background-color: yellow;" type="text" id="costprice" name="costprice" size="6"
                               value="" required/>
                        <input type="hidden" name="stat" value="<?php echo $stat; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" id="submit" value="<?php echo $name_button; ?>">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div style="display: block;float: right;margin-top: 50px;">
        <form enctype="multipart/form-data" action="add_scan_nacl.php" name="myform" method="post">
            <div>
                <?php
                $katalog = '/home/sc_mg/' . $invoice;
                if (is_dir($katalog . '/')) echo '<p style="color: #176806">Накладна присутня!</p>';
                else echo '<p style="color: #900000">Накладна відсутня!</p>';
                ?>
            </div>
            <div>
                <label for="cof_file">Копія накладної:</label>
                <input id="cof_file" type="file" name="file[]" multiple='true'/><br>
                <input type="hidden" name="invoice" value="<?= $invoice ?>">
                <label style="color: black; font-size:12px;">Тільки для файлів jpg, jpeg, gif та png</label><br>
                <input type="submit" value="Додати">
            </div>
        </form>
    </div>
<?php
if ($stat == 1) {
    $pr = '
    <table class="zmview">
        <tr>
        <th class="add_record" colspan="3">#</th>
        <th>Штрих-код</th>
        <th>Постачальник</th>
        <th>Назва</th>
        <th>Кількість</th>
        <th>Ціна опт од.<br>(всього)</th>
        <th>Ціна роздріб од.<br>(всього)</th>
    </tr>';

    $kl_prod = 0;
    $sopt = 0;
    $ssum = 0;
    $num_line = 0;
    $sql = "SELECT store.*,provider.NAIM AS PROVIDER,product.NAIM AS PRODUCT FROM store,provider,product 
            WHERE store.invoice='$invoice' AND store.DL='1' AND store.PROVIDER=provider.ID AND provider.DL='1' AND store.PRODUCT=product.ID 
            AND product.DL='1' AND store.STATUS='1' ORDER BY store.ID DESC";
    //echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $num_line++;
        $pr .= '<tr>
            <td align="center"><a href="store.php?filter=edit_sklad&kl=' . $aut["ID"] . '&invoice=' . $invoice . '"><img src="images/b_edit.png" border="0"></a></td>
            <td>' . $num_line . '</td>
            <td>
            <a href="print_kod.php?invoice=' . $invoice . '&scd=' . $aut["SKOD"] . '&size=3"><img src="images/print.png" border="0">2x3</a><br>
            <a href="print_kod.php?invoice=' . $invoice . '&scd=' . $aut["SKOD"] . '&size=4"><img src="images/print.png" border="0">2.5x4</a>
            </td>	
            <td align="center">' . $aut["SKOD"] . '</td>	
            <td>' . $aut["PROVIDER"] . '</td>
            <td align="center">' . $aut["PRODUCT"] . '</td>
            <td align="center">' . $aut["NUMBER"] . '</td>
            <td align="center">' . $aut["OPT"] . '<br>(<span style="color:green;">' . number_format($aut["OPT"] * $aut["NUMBER"], 2) . '</span>)</td>
            <td align="center">' . $aut["SUM"] . '<br>(<span style="color:green;">' . number_format($aut["SUM"] * $aut["NUMBER"], 2) . '</span>)</td>
        </tr>';

        $kl_prod += $aut["NUMBER"];
        $sopt += $aut["OPT"] * $aut["NUMBER"];
        $ssum += $aut["SUM"] * $aut["NUMBER"];
    }
    mysql_free_result($atu);

    $kl_prod = number_format($kl_prod, 2);
    $sopt = number_format($sopt, 2);
    $ssum = number_format($ssum, 2);

    $pr .= '<tr><td colspan="6">Всього:</td><td align="right">' . $kl_prod . '</td><td align="right">' . $sopt . '</td><td align="right">' . $ssum . '</td></tr></table>';
    echo $pr;
}
?>