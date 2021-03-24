<?php
include_once "function.php";
?>
<br>
<div>
    Штрих код: <input type="text" name="search_code" id="search_code" value="">
    Назва: <input type="text" name="search_product" id="search_product" value="">
    Група: <input type="text" name="search_group" id="search_group" value="">
</div><br>
<div id="search_result">

</div>
<script type="text/javascript">
    $(document).ready(
        function () {
            let code = $('#search_code');
            let product = $('#search_product');
            let group = $('#search_group');
            let search_result = $('#search_result');

            code.keyup(function (){
                if(code.val().length > 8){
                    net_fokusa();
                }
            });
            product.keyup(function (){
                if(product.val().length > 3){
                    net_fokusa();
                }
            });
            group.keyup(function (){
                if(group.val().length > 3){
                    net_fokusa();
                }
            });

            function net_fokusa(eventObj) {
                $.ajax({
                    type: "POST",
                    url: "search_product_in_catalog.php",
                    data: 'code=' + code.val() + '&product=' + product.val() + '&group=' + group.val(),
                    dataType: "html",
                    success: function (html) {
                        var reply = html;
                        search_result.empty();
                        search_result.append(reply);
                    },
                    error: function (html) {
                        alert(html.error);
                    }
                });
            }
        }
    );
</script>