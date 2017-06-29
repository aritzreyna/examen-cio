<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_laligastats = "localhost";
$database_laligastats = "laligastats";
$username_laligastats = "root";
$password_laligastats = "";
$laligastats = mysql_pconnect($hostname_laligastats, $username_laligastats, $password_laligastats) or trigger_error(mysql_error(),E_USER_ERROR); 
?>