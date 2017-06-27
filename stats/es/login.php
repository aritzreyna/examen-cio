<?php require_once('../Connections/laligastats.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "intranet.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_laligastats, $laligastats);
  
  $LoginRS__query=sprintf("SELECT email, password FROM `admin` WHERE email=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $laligastats) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php require_once('../Connections/laligastats.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LaLiga Stats</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="../img/favicon_160.png">
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Slabo+27px" rel="stylesheet">


  
</head>

<body>
	<!--<div class="alice">a
    </div>
	<div class="blue1">b
    </div>
	<div class="blue2">c
    </div>
	<div class="blue3">d
    </div>
	<div class="green">e
    </div>
	<div class="venus">f
    </div>
    <div class="ath">g
    </div>
    <div class="ath2">h
    </div>
    <div class="ath3">i
    </div>-->
    <header>
    	<div class="logo-div">
        	<h1 class="title-h1" alt="LaLiga Stats">
            	<a href="../index.php"><img src="../img/favicon_160.png" width="100%"><span>LaLiga Stats</span></a>
            </h1>
        </div>
        <nav class="menu">
        	<ul class="menu-ul">
            	<li class="menu-li"><a class="menu-a menu-a-no" href="../index.php">Inicio</a></li>
                <li class="menu-li"><a class="menu-a menu-a-no" href="equipos.php">Equipos</a></li>
                <li class="menu-li"><a class="menu-a menu-a-no" href="jugadores.php">Jugadores</a></li>
                <li class="menu-li"><a class="menu-a menu-a-no" href="nosotros.php">Nosotros</a></li>
                <li id="admin-menu" class="menu-li"><a class="menu-a menu-a-active" href="intranet.php">Intranet</a></li>
            </ul>
        </nav>
    </header>
    <main>
    	<div class="in-form">
    		<h2 class="title-index">
    			LOGIN
    		</h2>
            <div login-box>
            	<form id="login" action="<?php echo $loginFormAction; ?>" method="POST" name="login" lang="es">
                    <input name="email" type="email" maxlength="50" placeholder="Email">
                    <input name="password" type="password" maxlength="50" placeholder="Contraseña">
                    <input name="submit" type="submit" value="Entrar">
                </form>
            </div>
    	</div>
			
    </main>
</body>
</html>