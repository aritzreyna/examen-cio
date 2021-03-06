<?php require_once('../Connections/laligastats.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "mod-player")) {
  $updateSQL = sprintf("UPDATE jugadores SET nombre_jugador=%s, nombre_completo_jugador=%s, edad=%s, posicion=%s, id_equipo=%s, numero=%s, foto_jugador=%s, en_forma_jugador=%s WHERE id_jugador=%s",
                       GetSQLValueString($_POST['nombre_jugador'], "text"),
                       GetSQLValueString($_POST['nombre_completo_jugador'], "text"),
                       GetSQLValueString($_POST['edad'], "int"),
                       GetSQLValueString($_POST['posicion'], "text"),
                       GetSQLValueString($_POST['id_equipo'], "int"),
                       GetSQLValueString($_POST['numero'], "int"),
                       GetSQLValueString($_POST['foto_jugador'], "text"),
                       GetSQLValueString($_POST['en_forma_jugador'], "text"),
                       GetSQLValueString($_POST['id_jugador'], "int"));

  mysql_select_db($database_laligastats, $laligastats);
  $Result1 = mysql_query($updateSQL, $laligastats) or die(mysql_error());

  $updateGoTo = "list-players.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_laligastats, $laligastats);
$query_modificar_stats_jugador = "SELECT jornada_jugador.* FROM jornada_jugador , jugadores WHERE jornada_jugador.id_jugador = jugadores.id_jugador";
$modificar_stats_jugador = mysql_query($query_modificar_stats_jugador, $laligastats) or die(mysql_error());
$row_modificar_stats_jugador = mysql_fetch_assoc($modificar_stats_jugador);
$totalRows_modificar_stats_jugador = mysql_num_rows($modificar_stats_jugador);

$colname_jugador = "-1";
if (isset($_GET['id_jugador'])) {
  $colname_jugador = $_GET['id_jugador'];
}
mysql_select_db($database_laligastats, $laligastats);
$query_jugador = sprintf("SELECT * FROM jugadores WHERE id_jugador = %s", GetSQLValueString($colname_jugador, "int"));
$jugador = mysql_query($query_jugador, $laligastats) or die(mysql_error());
$row_jugador = mysql_fetch_assoc($jugador);
$totalRows_jugador = mysql_num_rows($jugador);
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
    			Actualizar jugador
    		</h2>
              <form method="post" name="mod-player" action="<?php echo $editFormAction; ?>">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap align="right">Nombre / Apodo:</td>
                    <td><input type="text" name="nombre_jugador" value="<?php echo htmlentities($row_jugador['nombre_jugador'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Nombre completo:</td>
                    <td><input type="text" name="nombre_completo_jugador" value="<?php echo htmlentities($row_jugador['nombre_completo_jugador'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Edad:</td>
                    <td><input type="text" name="edad" value="<?php echo htmlentities($row_jugador['edad'], ENT_COMPAT, 'utf-8'); ?>" size="2" maxlength="2"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Posición:</td>
                    <td><select name="en_forma_jugador">
                    	<option value="Portero" selected>Portero</option>
                        <option value="Defensa">Defensa</option>
                        <option value="Centrocampista">Centrocampista</option>
                        <option value="Delantero">Delantero</option>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Número:</td>
                    <td><input type="text" name="numero" value="<?php echo htmlentities($row_jugador['numero'], ENT_COMPAT, 'utf-8'); ?>" size="2" maxlength="2"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Foto:</td>
                    <td><input type="file" name="foto_jugador" value="../img/<?php echo htmlentities($row_jugador['foto_jugador'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Destacado:</td>
                    
                  </tr>
                  <tr valign="baseline">
                    <td><label>
                          <input type="radio" name="en_forma_jugador" value="y" id="en_forma_jugador_0">
                          Sí</label></td>
                      </tr>
                      <tr>
                        <td><label>
                          <input type="radio" name="en_forma_jugador" value="n" id="en_forma_jugador_1" checked>
                          No</label></td>
                          </tr>
                    <td><input type="submit" value="Actualizar jugador"></td>
                  </tr>
                </table>
                <input type="hidden" name="id_jugador" value="<?php echo $row_jugador['id_jugador']; ?>">
                <input type="hidden" name="id_equipo" value="<?php echo htmlentities($row_jugador['id_equipo'], ENT_COMPAT, 'utf-8'); ?>">
                <input type="hidden" name="MM_update" value="mod-player">
                <input type="hidden" name="id_jugador" value="<?php echo $row_jugador['id_jugador']; ?>">
              </form>
    	</div>
			
    </main>
</body>
</html>
<?php
mysql_free_result($modificar_stats_jugador);

mysql_free_result($jugador);
?>
