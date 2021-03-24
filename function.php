<?php
function german_date($oldat)
{
    if ($oldat == "") $vdat = "-";
    else {
        $pos = strpos($oldat, ":");
        if ($pos === false) {
            $oldat1 = explode('-', $oldat);
            if ($oldat1[1] > 0) {
                $mdt = mktime(0, 0, 0, $oldat1[1], $oldat1[2], $oldat1[0]);
                $vdat = date("d.m.Y", $mdt);
            } else
                $vdat = "-";
        } else {
            $temp = explode(' ', $oldat);
            $oldat1 = explode('-', $temp[0]);
            $oldat2 = explode(':', $temp[1]);
            if ($oldat1[1] > 0) {
                $mdt = mktime($oldat2[0], $oldat2[1], $oldat2[2], $oldat1[1], $oldat1[2], $oldat1[0]);
                $vdat = date("d.m.Y H:i:s", $mdt);
            } else
                $vdat = "-";
        }
    }
    return $vdat;
}

function date_bd($oldat)
{
    $new_dat = substr($oldat, 6, 4) . "-" . substr($oldat, 3, 2) . "-" . substr($oldat, 0, 2);
    return $new_dat;
}

function procherk($chislo)
{
    if ($chislo == 0) $rez = '-';
    else $rez = $chislo;
    return $rez;
}

function p_buk($slovo)
{
    $bukva = substr($slovo, 0, 2);
    return $bukva;
}

function GetCheckDigit($barcode)
{
    //Compute the check digit
    $sum = 0;
    for ($i = 1; $i <= 11; $i += 2)
        $sum += 3 * $barcode[$i];
    for ($i = 0; $i <= 10; $i += 2)
        $sum += $barcode[$i];
    $r = $sum % 10;
    if ($r > 0)
        $r = 10 - $r;
    return $r;
}

function dva($ch, $mas1, $mas2, $mas3)
{
    $str_ch = (string)($ch);
    if ($str_ch{0} == 1 && $str_ch{1} == 0) $strok = $mas3[1];
    if ($str_ch{0} == 1 && $str_ch{1} != 0) $strok = $mas2[$str_ch{1}];
    if ($str_ch{0} > 1 && $str_ch{1} == 0) $strok = $mas3[$str_ch{0}];
    if ($str_ch{0} > 1 && $str_ch{1} != 0) $strok = $mas3[$str_ch{0}] . " " . $mas1[$str_ch{1}];
    return $strok;
}

function tri($ch, $mas1, $mas2, $mas3, $mas4)
{
    $str_ch = (string)($ch);
    $strok = $mas4[$str_ch{0}] . " ";
    if ($str_ch{1} == 0 && $str_ch{2} != 0) $strok .= $mas1[$str_ch{2}];
    $dv = substr($str_ch, 1, 2);
    $strok .= dva($dv, $mas1, $mas2, $mas3);
    return $strok;
}

function triada($ch, $mas1, $mas2, $mas3, $mas4)
{
    $len_do_z = (int)strlen($ch);
    switch ($len_do_z) {
        case 1:
            $strok = $mas1[$ch];
            break;
        case 2:
            $strok = dva($ch, $mas1, $mas2, $mas3);
            break;
        case 3:
            $strok = tri($ch, $mas1, $mas2, $mas3, $mas4);
            break;
    }
    return $strok;
}


function in_str($sum)
{
    $mas_m = array("", "один", "два", "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять");
    $mas1 = array("", "одна", "дві", "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять");
    $mas2 = array("", "одинадцять", "дванадцять", "тринадцять", "чотирнадцять", "п'ятнадцять",
        "шістнадцять", "сімнадцять", "вісімнадцять", "дев'ятнадцять");
    $mas3 = array("", "десять", "двадцять", "тридцять", "сорок", "п'ятдесят", "шістдесят",
        "сімдесят", "вісімдесят", "дев'яносто");
    $mas4 = array("", "сто", "двісті", "триста", "чотириста", "п'ятсот", "шістсот", "сімсот",
        "вісімсот", "дев'ятсот");
    $mas5 = array("тисяч", "тисяча", "тисячі", "тисячі", "тисячі", "тисяч", "тисяч", "тисяч", "тисяч", "тисяч");
    $mas6 = array("мільйонів", "мільйон", "мільйона", "мільйона", "мільйона", "мільйонів", "мільйонів", "мільйонів", "мільйонів", "мільйонів");

    $do_z = (int)$sum;
    $len_do_z = (int)strlen($do_z);
    if ($len_do_z <= 3) $tr1 = triada($do_z, $mas1, $mas2, $mas3, $mas4);
    if ($len_do_z > 3 && $len_do_z <= 6) {
        $ch1 = substr($do_z, -3, 3);
        $ch2 = substr($do_z, -6, $len_do_z - 3);
        $tr2 = triada($ch1, $mas1, $mas2, $mas3, $mas4);
        if (strlen($ch2) == 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2] . " ";
        if (strlen($ch2) == 2 && $ch2{0} == 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 2 && $ch2{0} != 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{1}] . " ";
        if (strlen($ch2) == 3 && $ch2{1} == 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 3 && $ch2{1} != 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{2}] . " ";
//$strok=$tr1.$tr2;
    }

    if ($len_do_z > 6 && $len_do_z <= 9) {
        $ch1 = substr($do_z, -3, 3);
        $ch2 = substr($do_z, -6, 3);
        $ch3 = substr($do_z, -9, $len_do_z - 6);
        $tr3 = triada($ch1, $mas1, $mas2, $mas3, $mas4);
        if (strlen($ch2) == 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2] . " ";
        if (strlen($ch2) == 2 && $ch2{0} == 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 2 && $ch2{0} != 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{1}] . " ";
        if (strlen($ch2) == 3 && $ch2{1} == 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 3 && $ch2{1} != 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{2}] . " ";

        if (strlen($ch3) == 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[$ch3] . " ";
        if (strlen($ch3) == 2 && $ch3{0} == 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[5] . " ";
        if (strlen($ch3) == 2 && $ch3{0} != 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[$ch3{1}] . " ";
        if (strlen($ch3) == 3 && $ch3{1} == 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[5] . " ";
        if (strlen($ch3) == 3 && $ch3{1} != 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[$ch3{2}] . " ";

//$strok=$tr1.$tr2.$tr3;
    }
    $strok = $tr1 . $tr2 . $tr3;
    return $strok;
}

function fract($nm /*  = 0  */)
{
//if(!is_double($nm)) return 0;
    $ot = explode('.', $nm);
    return $ot[1];
}

function work_date($v_date, $kl)
{
    $d_temp = $v_date;
    $k = 0;
    while ($k < $kl) {
        $date_mas = explode('-', (string)$d_temp);
        $d_temp = date("Y-m-d", mktime(0, 0, 0, $date_mas[1], $date_mas[2] + 1, $date_mas[0]));
        $hd = "";
        $sql = "SELECT HOLIDAY FROM holiday WHERE HOLIDAY='$d_temp'";
        $atu = mysql_query($sql);
        if ($atu)
            while ($aut = mysql_fetch_array($atu)) {
                $hd = $aut["HOLIDAY"];
            }
        mysql_free_result($atu);
        if ($hd == "") {
            $k++;
        }
    }
    $result = german_date($d_temp);
    return $result;
}

function mis_term($v_date, $kl)
{
    $d_temp = $v_date;
    $date_mas = explode('-', (string)$d_temp);
    $date_mas[1] = $date_mas[1] + $kl;
    $k = 0;
    $i = 0;
    while ($k == 0) {
        $d_temp = date("Y-m-d", mktime(0, 0, 0, $date_mas[1], $date_mas[2] + $i, $date_mas[0]));
        $hd = "";
        $sql = "SELECT HOLIDAY FROM holiday WHERE HOLIDAY='$d_temp'";
        $atu = mysql_query($sql);
        if ($atu)
            while ($aut = mysql_fetch_array($atu)) {
                $hd = $aut["HOLIDAY"];
            }
        mysql_free_result($atu);
        if ($hd == "") $k++;
        else $i++;
    }
    $result = german_date($d_temp);
    return $result;
}

function objekt_ner($obj, $bud, $kv)
{
    $result = '';
    switch ($obj) {
        case 0:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 1:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 2:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 3:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 4:
            if ($bud != "") $budd = " Гараж № " . $bud; else $budd = " Гараж №";
            if ($kv != "") $kvarr = $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 5:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кім. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 6:
            if ($bud != "") $budd = $bud . " (ЦМК)"; else $budd = "";
            $result = $budd;
            break;
        case 7:
            if ($bud != "") $budd = $bud . " (нежитл. прим.)"; else $budd = "";
            $result = $budd;
            break;
        case 8:
            if ($bud != "") $budd = $bud . " (нежитл. будівля)"; else $budd = "";
            $result = $budd;
            break;
    }
    return $result;
}

function get_balance($skod)
{
    $prihod = 0;
    $rashod = 0;
    $ostatok = 0;

    $sql2 = "SELECT `primary_balance`.`kl`,`primary_balance`.dt AS PR_BALANCE FROM `primary_balance`,`product` "
        . "WHERE `primary_balance`.`id_product`=`product`.`ID` AND `product`.`SKOD`='" . $skod . "' "
        . "ORDER BY dt DESC LIMIT 1";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $prim_bal = $aut2["kl"];
        $dt_bal = $aut2["PR_BALANCE"];
    }
    mysql_free_result($atu2);

    $sql2 = "SELECT SUM(`NUMBER`) AS PRIHOD FROM `store` WHERE `SKOD`='" . $skod . "' AND DT>='$dt_bal' AND (`STATUS`='1' OR `STATUS`='4')";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $prihod = (int)$aut2["PRIHOD"];
    }
    mysql_free_result($atu2);

    $sql2 = "SELECT SUM(`NUMBER`) AS RASHOD FROM `store` WHERE `SKOD`='" . $skod . "' AND DT>='$dt_bal' AND (`STATUS`='2' OR `STATUS`='3' OR `STATUS`='5')";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $rashod = (int)$aut2["RASHOD"];
    }
    mysql_free_result($atu2);

    $ostatok = ($prim_bal + $prihod) - $rashod;
    return $ostatok;
}

function getSum($skod)
{
    $sm_pr = 0;
    $sm_price = 0;
    $sql2 = "SELECT `SUM` FROM `store` WHERE `store`.`SKOD` = '" . $skod . "' AND `store`.`DL`='1' AND `store`.`STATUS`='1' ORDER BY DT DESC LIMIT 1";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $sm_pr = $aut2["SUM"];
    }
    mysql_free_result($atu2);

    $sql2 = "SELECT `cost` FROM `product` WHERE `product`.`SKOD` = '" . $skod . "' AND `product`.`DL`='1' ORDER BY ID DESC LIMIT 1";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $sm_price = $aut2["cost"];
    }
    mysql_free_result($atu2);
    if ($sm_pr >= $sm_price) {
        return $sm_pr;
    } else return $sm_price;
}

function get_user($pas)
{
    $resp = null;
    if ($pas) {
        $sql2 = "SELECT id,pr,im,pb FROM `users` WHERE `users`.`pas` = '" . $pas . "' AND `users`.`DL`='1'";
        $atu2 = mysql_query($sql2);
        while ($aut2 = mysql_fetch_array($atu2)) {
            $resp = $aut2;
        }
        mysql_free_result($atu2);
    }
    return $resp;
}

function get_kredit_settings()
{
    $resp = null;
    $sql2 = "SELECT * FROM `kredit_settings` WHERE `kredit_settings`.`id` = 1";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $resp = $aut2;
    }
    mysql_free_result($atu2);
    return $resp;
}

function get_sm_kredit_today($customer)
{
    $sql2 = "SELECT SUM(SUM_BONUS) AS SMB FROM `resipt_all` LEFT JOIN `store` ON `resipt_all`.`SKOD`=`store`.`SKOD` AND `resipt_all`.`ID_RESIPT`=`store`.`RECEIPT` 
                WHERE DATE(`resipt_all`.`DT`)=CURRENT_DATE() AND `resipt_all`.`CUSTOMER`='$customer' AND `resipt_all`.`DL`='1' AND `store`.`DL`=1";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $resp = $aut2["SMB"];
    }
    mysql_free_result($atu2);
    if(!$resp) $resp = 0;
    return $resp;
}