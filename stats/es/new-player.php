<?php require_once('../Connections/laligastats.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new-player-form")) {
  $insertSQL = sprintf("INSERT INTO jugadores (id_jugador, nombre_jugador, nombre_completo_jugador, edad, posicion, id_equipo, numero, foto_jugador, en_forma_jugador) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_jugador'], "int"),
                       GetSQLValueString($_POST['nombre_jugador'], "text"),
                       GetSQLValueString($_POST['nombre_completo_jugador'], "text"),
                       GetSQLValueString($_POST['edad'], "int"),
                       GetSQLValueString($_POST['posicion'], "text"),
                       GetSQLValueString($_POST['id_equipo'], "int"),
                       GetSQLValueString($_POST['numero'], "int"),
                       GetSQLValueString($_POST['foto_jugador'], "text"),
                       GetSQLValueString($_POST['en_forma_jugador'], "text"));

  mysql_select_db($database_laligastats, $laligastats);
  $Result1 = mysql_query($insertSQL, $laligastats) or die(mysql_error());

  $insertGoTo = "list-players.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_laligastats, $laligastats);
$query_nuevo_jugador = "SELECT * FROM jugadores";
$nuevo_jugador = mysql_query($query_nuevo_jugador, $laligastats) or die(mysql_error());
$row_nuevo_jugador = mysql_fetch_assoc($nuevo_jugador);
$totalRows_nuevo_jugador = mysql_num_rows($nuevo_jugador);

mysql_select_db($database_laligastats, $laligastats);
$query_equipos = "SELECT * FROM equipos";
$equipos = mysql_query($query_equipos, $laligastats) or die(mysql_error());
$row_equipos = mysql_fetch_assoc($equipos);
$totalRows_equipos = mysql_num_rows($equipos);
?>

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
    			Nuevo jugador
    		</h2>
    		<div class="add-player">
              <form method="post" name="new-player-form" action="<?php echo $editFormAction; ?>">
              <div>
                <input type="text" name="nombre_jugador" value="" size="20" placeholder="Apodo">
                </div>
                <div>
                  <input type="text" name="nombre_completo_jugador" value="" size="100%" placeholder="Nombre completo">
                  </div>
                  <div>
                  <label for="edad">Edad:</label>
                    <input type="text" name="edad" value="" size="2" maxlength="2">
                    </div>
                    <div>
                 <label for="posicion">Posición:</label>
                    	<select name="posicion">
                      <?php
do {  
?>
                      <option value="<?php echo $row_nuevo_jugador['posicion']?>"><?php echo $row_nuevo_jugador['posicion']?></option>
                      <?php
} while ($row_nuevo_jugador = mysql_fetch_assoc($nuevo_jugador));
  $rows = mysql_num_rows($nuevo_jugador);
  if($rows > 0) {
      mysql_data_seek($nuevo_jugador, 0);
	  $row_nuevo_jugador = mysql_fetch_assoc($nuevo_jugador);
  }
?>
                    </select>
                    </div>
                    <div>
                 <label for="id_equipo">Equipo:</label>
                    	<select name="id_equipo">
                      <?php
do {  
?>
                      <option value="<?php echo $row_equipos['id_equipo']?>"><?php echo $row_equipos['nombre_equipo']?></option>
                      <?php
} while ($row_equipos = mysql_fetch_assoc($equipos));
  $rows = mysql_num_rows($equipos);
  if($rows > 0) {
      mysql_data_seek($equipos, 0);
	  $row_equipos = mysql_fetch_assoc($equipos);
  }
?>
                    </select>
                    </div>
                    <div>
                    <label for="numero">Número:</label>
                    <input type="text" name="numero" value="" size="2" maxlength="2">
                    </div>
                    <div>
                    <label for="foto_jugador">Foto del jugador:</label>
                    <input type="file" name="foto_jugador" value="" size="32">
                    </div>
                    <div>
                    <label for="en_forma_jugador">Destacado:</label>
                        <input type="radio" name="en_forma_jugador" value="y" >
                          <label>Sí</label> 
                        <input type="radio" name="en_forma_jugador" value="n" checked>
                          <label>No</label>
                 	</div>
                  <input type="submit" value="Añadir jugador">
                <input type="hidden" name="MM_insert" value="new-player-form">
              </form>
			</div>
    	</div>
			
    </main>
</body>
</html>
<?php
mysql_free_result($nuevo_jugador);

mysql_free_result($equipos);
?>
