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
<?php require_once('../Connections/laligastats.php'); ?>
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
    			Destacados de la semana
    		</h2>
    		<div class="form-player">
				<div class="main-info">
                	<div class="numero-en-forma"><p></p>
                    </div>
                    <div class="form-photo">
                        <img width="100%">
                    </div>
                    <div class="form-player-detail">
                        <h3 class="in-form-title">Jugador en forma</h3>
                        <h3 class="player-name"><a href="#"></a></h3>
                        <h2 class="players-team"><img width="100%"> <span></span></h2>
                        <h2 class="players-info"><i class="material-icons icon-info">info_outline</i><span> años. </span></h2>
                    </div>
                </div>
                <div class="stats-container">
                	<div class="table-player-index">
                      <div class="stats-table-row">
                        <div class="stats-table-cell match-title"><span class="test" data-toggle="tooltip">
                        	<img width="100%"> - <img width="100%"></span>
                        </div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Tiros">T</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Tiros a puerta">TP</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Goles">G</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Pases">P</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Asistencias">A</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Faltas cometidas">FC</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Faltas recibidas">FR</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Regates intentados">RI</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Regates completados">RC</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Centros completados">CC</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Tarjetas amarillas">TA</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Tarjetas rojas">TR</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Entradas realizadas">ER</span></div>
                        <div class="stats-table-cell"><span class="test" data-toggle="tooltip" title="Entradas exitosas">EE</span></div>
                      </div>
                      
                      <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

                      <div class="stats-table-row">
                        <div class="match-stats stats-value"> - </div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                        <div class="stats-table-cell stats-value"></div>
                      </div>
                    </div>

                </div>
			</div>
    	</div>
			
    </main>
</body>
</html>