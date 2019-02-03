<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
include "function.php";
require('tfpdf/tfpdf.php');
 // створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true',2);
$pdf->SetMargins(05,05,2);

$pdf-> AddFont('dejavu','','DejaVuSans.ttf',true); 
$pdf-> AddFont('dejavub','','DejaVuSans-Bold.ttf',true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Замовлення');

// задаємо шрифт та його колiр
$pdf-> SetFont('dejavu','',10);
$pdf->SetTextColor(50, 60, 100);
 
//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$pdf-> SetFont('dejavu','',12);
$pdf->SetXY(15, 05);
$pdf->MultiCell(15,8,'№',1,'C',0);
$pdf->SetXY(30, 05);
$pdf->MultiCell(35,8,'Штрих-код',1,'C',0);
$pdf->SetXY(65, 05);
$pdf->MultiCell(115,8,'Назва',1,'C',0);
$pdf->SetXY(180, 05);
$pdf->MultiCell(25,8,'Кількість',1,'C',0);


$npp=0;
$sql = "SELECT balance.*,product.NAIM AS PRODUCT FROM balance,product 
	WHERE balance.id_product=product.ID AND product.DL='1' ORDER BY product.GROUP,product.NAIM"; //balance.dt_rev DESC
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$npp++;

$it=$it+5;
if($it>275){
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);
$it=0;
}

$pdf-> SetFont('dejavu','',10);
$pdf->SetXY(15, 8+$it);
$pdf->MultiCell(15,5,$npp,1,'C',0);
$pdf->SetXY(30, 8+$it);
$pdf->MultiCell(35,5,$aut["skod"],1,'C',0);
$pdf->SetXY(65, 8+$it);
$pdf->MultiCell(115,5,$aut["PRODUCT"],1,'L',0);
$pdf->SetXY(180, 8+$it);
$pdf->MultiCell(25,5,'',1,'C',0);
}
mysql_free_result($atu);
 
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
//виводимо документ на екран
$pdf->Output('revisiya.pdf','I');
?>