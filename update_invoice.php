<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$kl=$_POST['kl'];
$dt=date_bd($_POST['dt']);
$dtmoney=date_bd($_POST['dtmoney']);
$provider=$_POST['provider'];
$smbal=str_replace(",",".",$_POST['smbal']);
$smcash=str_replace(",",".",$_POST['smcash']);
$smprov=str_replace(",",".",$_POST['smprov']);
$smgot=str_replace(",",".",$_POST['smgot']);
//$name=addslashes($_GET['name']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE invoices SET provider='$provider',sm_bal='$smbal',sm_cash='$smcash',sm_prov='$smprov',
		sm_got='$smgot',dt='$dt',dtmoney='$dtmoney' WHERE invoices.id='$kl' AND invoices.dl='1'");
	if(!$ath1){echo "Запис не скоригований";} 

//------------------------------------------------------------------------------------
if (isset($_FILES))
{
  //пролистываем весь массив изображений по одному $_FILES['file']['name'] as $k=>$v
  foreach ($_FILES['file']['name'] as $k=>$v)
  {
    //директория загрузки
    $uploaddir = "/home/sc_mg/$kl/";
    //новое имя изображения
	$poz=strrpos($_FILES["file"]["name"][$k],'.');
	$rez_obr=substr($_FILES["file"]["name"][$k],$poz);
    $apend=date('YmdHis').rand(100,1000).$rez_obr; //'.png';
    //путь к новому изображению
    $uploadfile = "$uploaddir$apend";
 
    //Проверка расширений загружаемых изображений
    if($_FILES['file']['type'][$k] == "image/gif" || $_FILES['file']['type'][$k] == "image/png" ||
    $_FILES['file']['type'][$k] == "image/jpg" || $_FILES['file']['type'][$k] == "image/jpeg" || 
	$_FILES['file']['type'][$k] == "application/pdf")
    {
      //черный список типов файлов
      $blacklist = array(".php", ".phtml", ".php3", ".php4");
      foreach ($blacklist as $item)
      {
        if(preg_match("/$item\$/i", $_FILES['file']['name'][$k]))
        {
          echo "Нельзя загружать скрипты.";
          exit;
        }
      }
      //перемещаем файл из временного хранилища
	  mkdir("/home/sc_mg/$kl");
      if (move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile))
      {
        //получаем размеры файла
        $size = getimagesize($uploadfile);
      }
      else
        echo "<center><br>Файл не загружен, вернитесь и попробуйте еще раз.</center>";
    }
    else
      echo "<center><br>Можно загружать только изображения в форматах jpg, jpeg, gif, pdf и png.</center>";
  }
}
//-------------------------------------------------------------------------	

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: store.php?filter=invoice_view");
?>