<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_laligastats = "qxx687.academiacio.com";
$database_laligastats = "qxx687";
$username_laligastats = "qxx687";
$password_laligastats = "3830seF";
$laligastats = mysql_pconnect($hostname_laligastats, $username_laligastats, $password_laligastats) or trigger_error(mysql_error(),E_USER_ERROR); 
?>