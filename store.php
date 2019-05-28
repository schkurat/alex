<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$type=$_SESSION['TYPE'];

header('Content-Type: text/html; charset=utf-8');
$dseg=date("d.m.Y");
?>
<html>
<head>
<title>
Магазин - Автоматизована система
</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<!--<script type="text/javascript" src="../js/autozap.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>
<link rel="stylesheet" type="text/css" href="../js/autozap.css" />-->
<link rel="stylesheet" type="text/css" href="my.css" />
<link rel="stylesheet" type="text/css" href="menu.css" />
<script src="datp/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="datp/jquery-ui.css" />
<script type="text/javascript" src="js/scriptbreaker-multiple-accordion-1.js"></script>
<script language="JavaScript">
$(document).ready(function() {
	$(".topnav").accordion({
		accordion:true,
		speed: 500,
		closedSign: '►',
		openedSign: '▼'
	});
});
$(function() {
	$( ".datepicker" ).datepicker();
	$( ".datepicker" ).datepicker( "option", "dateFormat", "dd.mm.yy" );
	$( ".datepicker" ).datepicker( "option", "monthNames", ["Січень","Лютий","Березень","Квітень","Травень","Червень","Липень","Серпень","Вересень","Жовтень","Листопад","Грудень"]);
	$( ".datepicker" ).datepicker( "option", "dayNamesMin", [ "Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ] );
	$( ".datepicker" ).datepicker( "option", "firstDay", 1 );
	$(".datepicker").datepicker("setDate", "<?php echo $dseg; ?>");
	});
</script>
</head>
<body>

<table width="100%" border="0" cellspacing=0>
<tr><td class=men>
<?php
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
if($type == 'Продавці') {
    $pruhid = 'style="display: none;"';
    $prodaj = '';
    $bil = 'style="display: none;"';
    $spis = 'style="display: none;"';
    $vorvrat = 'style="display: none;"';
    $view = 'style="display: none;"';
    $balance = '';
    $payments  = 'style="display: none;"';
    $kasa = 'style="display: none;"';
    $revision = 'style="display: none;"';
    $dovidnuku = 'style="display: none;"';
    $nakladni = 'style="display: none;"';
    $vuruchka = 'style="display: none;"';
}
if($type == 'Адміністратор') {
    $pruhid = '';
    $prodaj = '';
    $bil = '';
    $spis = '';
    $vorvrat = '';
    $view = '';
    $balance = '';
    $payments = '';
    $kasa = '';
    $revision = 'style="display: none;"';
    $dovidnuku = '';
    $nakladni = '';
    $vuruchka = 'style="display: none;"';
}
if($type == 'Директор' or $type == 'Програміст') {
    $pruhid = '';
    $prodaj = '';
    $bil = '';
    $spis = '';
    $vorvrat = '';
    $view = '';
    $balance = '';
    $payments = '';
    $kasa = '';
    $revision = '';
    $dovidnuku = '';
    $nakladni = '';
    $vuruchka = '';
}
?>
<ul class="topnav">
	<li><a href="#">Склад</a>
		<ul>
			<li <?php echo $pruhid; ?>><a href="store.php?filter=new_invoice">Прихід товару</a></li><!--product_to_sklad&stat=1-->
                        <li <?php echo $prodaj; ?>><a href="store.php?filter=product_to_customer">Реалізація товару</a></li>
                        <li <?php echo $bil; ?>><a href="store.php?filter=chek_info">Чеки</a></li>
                        <li <?php echo $spis; ?>><a href="store.php?filter=product_to_spis">Списання товару</a></li>
                        <li <?php echo $vorvrat; ?>><a href="store.php?filter=product_to_backstore">Повернення від клієнта</a></li>
			<li <?php echo $view; ?>><a href="store.php?filter=store_info">Перегляд</a></li>
                        <li <?php echo $balance; ?>><a href="store.php?filter=sklad_info">Залишки</a></li>
		</ul>
	</li>
        <li><a href="#">Виручка</a>
		<ul>
			<!--<li><a href="store.php?filter=new_earnings">Додати</a></li>
			<li><a href="store.php?filter=seach_earnings">Перегляд</a></li>-->
                        <!--<li <?php echo $payments; ?>><a href="store.php?filter=payments_info">Касові виплати</a></li>-->
                        <li><a href="store.php?filter=inkasator_info">Інкасація каси</a></li>
                        <li <?php echo $kasa; ?>><a href="store.php?filter=kasa_view">Перегляд каси</a></li>
                        <li <?php echo $vuruchka; ?>><a href="store.php?filter=cashtoboss">Здача каси</a></li>
		</ul>
	</li>
        <li <?php echo $revision; ?>><a href="#">Ревізія</a>
		<ul>
			<li><a href="store.php?filter=formuvannya_info">Формування даних</a></li>
                        <li><a href="store.php?filter=balance">Контроль залишків</a></li>
                        <li><a href="store.php?filter=save_balance_info">Збереження залишків</a></li>
                        <li><a href="store.php?filter=clean_balance_info">Видалення таблиці</a></li>
		</ul>
	</li>
	<li <?php echo $dovidnuku; ?>><a href="#">Довідники</a>
		<ul>
			<li><a href="#">Групи товарів</a>
				<ul>
					<li><a href="store.php?filter=new_group_product">Додати</a></li>
					<li><a href="store.php?filter=group_product_view">Перегляд</a></li>  
				</ul>
			</li> 
			<li><a href="#">Товар</a>
				<ul>
					<li><a href="store.php?filter=new_product">Додати</a></li>
					<li><a href="store.php?filter=product_view">Перегляд</a></li>  
				</ul>
			</li> 
			<li><a href="#">Постачальники</a>
				<ul>
					<li><a href="store.php?filter=new_provider">Додати</a></li>
					<li><a href="store.php?filter=provider_view">Перегляд</a></li>  
				</ul>
			</li>
		</ul>
	</li>
	
	<li <?php echo $nakladni; ?>><a href="#">Накладні</a>
		<ul>
			<li><a href="store.php?filter=new_invoice">Додати</a></li>
			<li><a href="store.php?filter=seach_invoices">Перегляд</a></li>
		</ul>
	</li>
<li><a href="close_ses.php">Вихід</a></li>
</ul>

</td>
<td  class=fn>
<div class="gran">
<hr>
<?php
$temp=$_GET['filter'];
if($temp=="")
{$temp="fon.php";
	require($temp);}
 else{
	require($temp.".php");}
?>
<hr></div>
</td></tr>
</table>
<?php
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>
</body>
</html>