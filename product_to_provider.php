<?php
include "function.php";
include "scriptu.php";
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#skod').bind('blur', net_fokusa);
        //$('#number_invoice').bind('blur', search_invoice);
    });

    function net_fokusa(eventObj) {
        $.ajax({
            type: "POST",
            url: "find_product.php",
            data: 'kod=' + $("#skod").val(),
            dataType: "html",
            success: function (html) {
                var reply = html.split(":", 3);
                if (reply[0] != '') {
                    $("#name_product").val(reply[1]);
                    $("#product").val(reply[0]);
                    $("#number_invoice").focus();
                }
            },
            error: function (html) {
                alert(html.error);
            }
        });
    }

    // function search_invoice(eventObj) {
    //     $.ajax({
    //         type: "POST",
    //         url: "search_product_in_invoice.php",
    //         data: 'kod=' + $("#skod").val() + '&inv=' + $("#number_invoice").val(),
    //         dataType: "html",
    //         success: function (html) {
    //             let reply = html.split(":", 2);
    //             $("#cost_product").val(reply[0] + ' грн.');
    //             $("#provider").val(reply[1]);
    //             $("#klprod").focus();
    //         },
    //         error: function (html) {
    //             alert(html.error);
    //         }
    //     });
    // }
</script>
<form action="add_sklad.php" name="myform" method="post">
    <table align="" class="zmview">
        <tr>
            <th colspan="2" style="font-size: 35px;"><b>Повернення постачальниу</b></th>
        </tr>
        <tr>
            <td>Дата:</td>
            <td>
                <input type="text" class="datepicker" size="10" maxlength="10" name="dt"
                       value="<?php echo date("d.m.Y"); ?>"/>
                Час: <input type="text" size="8" maxlength="8" name="time_back" value="<?php echo date("H:i:s"); ?>"/>
            </td>
        </tr>
        <tr>
            <td>Штрих-код:</td>
            <td><input type="text" id="skod" name="skod" value=""/></td>
        </tr>
        <tr>
            <td>Товар:</td>
            <td>
                <input type="text" id="name_product" value="" readonly>
<!--                <input type="text" id="cost_product" name="cost_product" value="" readonly style="border: none;">-->
            </td>
        </tr>
<!--        <tr>-->
<!--            <td>Номер нашої накладної:</td>-->
<!--            <td>-->
<!--                <input id="number_invoice" type="text" name="number_invoice" value="" required/>-->
<!--            </td>-->
<!--        </tr>-->
        <tr>
            <td>Кількість товару:</td>
            <td>
                <input id="klprod" type="text" name="klprod" value=""/>
                <input type="hidden" id="product" name="product">
                <input type="hidden" id="provider" name="provider">
                <input type="hidden" name="stat" value="5"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" id="submit" value="Повернути постачальнику">
            </td>
        </tr>
    </table>
</form>