<html>
<head>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include_once "function.php";

if(isset($_GET['chk'])) $chk=$_GET['chk']; else $chk = '';


$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$pr = '<table style="border-collapse: collapse; width:55mm; font-size:12px;font-family: Courier New;">'
        . '<tr><th colspan="2" style="font-size: 16px;border-bottom: 1px solid black;padding:10px 0px;">'
        . 'МАГАЗИН ПРОДУКТИ</th></tr>';

$sql = "SELECT resipt.SUM,resipt.DT,SUM(resipt_all.NUMBER) AS KOL,resipt_all.SUM AS SM,product.NAIM AS NPROD 
    FROM resipt,resipt_all,product 
    WHERE resipt.ID='$chk' AND resipt.ID=resipt_all.ID_RESIPT AND resipt_all.PRODUCT=product.ID AND resipt_all.DL='1' 
    GROUP BY resipt_all.PRODUCT";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$chk_all_sum = $aut["SUM"];
$chk_dt = german_date($aut["DT"]);
$product = $aut["NPROD"];
$prod_kl = (float)$aut["KOL"];
$prod_cost = $aut["SM"];
$prod_cost_all = $prod_kl * $prod_cost;
$prod_cost_all = number_format($prod_cost_all, 2);

$pr2 .='<tr><td>'.$product.'</td><td align="right">'.$prod_kl.'*'.$prod_cost.' = '.$prod_cost_all.'</td></tr>';
//$yy +=5;
//    $pdf->Text($xx, $yy, $product.' '.$prod_kl.'*'.$prod_cost.'='.$prod_cost_all);

}
mysql_free_result($atu);
$pr1 = '<tr style="border-bottom: 1px solid black;"><th>ЧЕК №'.$chk.'</th><th>'.$chk_dt.'</th></tr>';
$pr3 = '<tr style="border-bottom: 1px solid black;border-top: 1px solid black;">'
        . '<td style="padding:5px 0px;">Разом</td><td align="right">'.$chk_all_sum.'</td></tr>';
$pr4 = '<tr><th colspan="2">ДЯКУЄМО ЗА ПОКУПКУ!</th></tr>';

$pr.=$pr1.$pr2.$pr3.$pr4.'</table>';

echo '<script>
$(document).ready(function() {
print();
$("html").keydown(function(eventObject){ 
  if (eventObject.keyCode == 13) { 
   // print();
   location.href = "store.php?filter=product_to_customer";
  }
//  if (eventObject.keyCode == 32) { 
//   location.href = "store.php?filter=product_to_customer";
//  }
});

});
</script>';

echo $pr;

/*echo '<a href="javascript:(print());">Распечатать</a>';*/
/*или
<a href="#print-this-document" onclick="print(); return false;">Распечатать</a>*/




//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
          
//$pdf->Output('bill.pdf','I');
?>
</body>
</html>