<?php
include "function.php";
$katalog=$_GET['katalog'];
$npr=german_date($_GET['npr']);
$kpr=german_date($_GET['kpr']);
$provider=$_GET['provider'];
if(is_dir ($katalog.'/')){
unlink($katalog.'/archive.tar.bz2');
exec('tar -cjvf '.$katalog.'/archive.tar.bz2 '.$katalog);
$zakachka=$katalog.'/archive.tar.bz2';

header("Content-type: application/x-download");
header("Content-Disposition: attachment; filename=archive.tar.bz2"/*.$zakachka*/);
$x = fread(fopen($zakachka, "rb"), filesize($zakachka)); 
echo $x; }
else header("location: store.php?filter=invoice_view&npr=".$npr."&kpr=".$kpr."&provider=".$provider);
?>