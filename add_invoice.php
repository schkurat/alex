<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("function.php");

$dt=date_bd($_POST['dt']);
$dtmoney=date_bd($_POST['dtmoney']);
$num_invoice=addslashes($_POST['num_invoice']);
$provider=$_POST['provider'];
$smbal=str_replace(",",".",$_POST['smbal']);
$smcash=str_replace(",",".",$_POST['smcash']);
$smprov=str_replace(",",".",$_POST['smprov']);
//$smgot=str_replace(",",".",$_POST['smgot']);
$dt_pay = $dt.date(" H:i:s");
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(magazin,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO invoices (num_invoice,provider,sm_prov,dt) VALUES('$num_invoice','$provider','$smprov','$dt');");
	if(!$ath1){echo "Запис не внесений до БД";} 
$id_inv=mysql_insert_id();

$ath1=mysql_query("INSERT INTO invoicespay (invoice,dt,sm_bal,sm_cash) VALUES('$id_inv','$dt_pay','$smbal','$smcash');");
	if(!$ath1){echo "Запис не внесений до БД";} 
//------------------------------------------------------------------------------------
if (isset($_FILES))
{
  //пролистываем весь массив изображений по одному $_FILES['file']['name'] as $k=>$v
  foreach ($_FILES['file']['name'] as $k=>$v)
  {
    //директория загрузки
    $uploaddir = "/home/sc_mg/$id_inv/";
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
	  mkdir("/home/sc_mg/$id_inv");
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
	
header("location: store.php?filter=product_to_sklad&stat=1&invoice=".$id_inv);

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