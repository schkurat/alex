<?php
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Магазин - Автоматизована система
</title>
</head>
<body>
<table align="center" border="0">
<tr><td align="center"><img src="images/korz.png"/></td></tr>
</table> 
<form action="identy.php" name="myform" method="post">  
   <table align="center" border="0" style="padding: 10px;">
   <tr>
   <td><input type="text" size="15" maxlength="15" name="login"
    style="text-align:center;" VALUE="Логiн" onfocus="if (this.value=='Логiн') this.value=''"/></td>
   <td><input type="password" size="15" maxlength="15" name="parol" 
    style="text-align:center;" VALUE="Пароль" onfocus="if (this.value=='Пароль') this.value=''"/></td>
   <td><input type="submit" name="vhid" style="width:60px;height:25px" value="Вхiд"></td>
   </tr>
   <tr><td COLSPAN="2" align="center">Введiть <b>Логiн та Пароль</b></td></tr>
  </table>
<table align="center" border="0">
<tr><td>
<img src="images/fon.png">
</td>
</tr>
</table>
</form>
</body>
</html>