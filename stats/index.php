<?php require_once('Connections/laligastats.php'); ?>
<?php require_once('Connections/laligastats.php'); ?>
<?php require_once('Connections/laligastats.php'); ?>
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

mysql_select_db($database_laligastats, $laligastats);
$query_jugador_en_forma = "SELECT jugadores.* , equipos.nombre_equipo , equipos.foto_equipo FROM equipos , jugadores WHERE equipos.id_equipo = jugadores.id_equipo AND jugadores.en_forma_jugador = 'y'";
$jugador_en_forma = mysql_query($query_jugador_en_forma, $laligastats) or die(mysql_error());
$row_jugador_en_forma = mysql_fetch_assoc($jugador_en_forma);
$totalRows_jugador_en_forma = mysql_num_rows($jugador_en_forma);

mysql_select_db($database_laligastats, $laligastats);
$query_equipo_en_forma = "SELECT * FROM equipos WHERE en_forma = 'y'";
$equipo_en_forma = mysql_query($query_equipo_en_forma, $laligastats) or die(mysql_error());
$row_equipo_en_forma = mysql_fetch_assoc($equipo_en_forma);
$totalRows_equipo_en_forma = mysql_num_rows($equipo_en_forma);

mysql_select_db($database_laligastats, $laligastats);
$query_estadisticas_jugador_en_forma = "SELECT jornada_jugador.* FROM jornada_jugador , jugadores WHERE jornada_jugador.id_jugador = jugadores.id_jugador AND jugadores.en_forma_jugador = 'y'";
$estadisticas_jugador_en_forma = mysql_query($query_estadisticas_jugador_en_forma, $laligastats) or die(mysql_error());
$row_estadisticas_jugador_en_forma = mysql_fetch_assoc($estadisticas_jugador_en_forma);
$totalRows_estadisticas_jugador_en_forma = mysql_num_rows($estadisticas_jugador_en_forma);

mysql_select_db($database_laligastats, $laligastats);
$query_equipos_jornada = "SELECT equipos.id_equipo , equipos.foto_equipo , equipos.nombre_equipo FROM equipos , jornada_jugador WHERE jornada_jugador.id_equipo_casa = equipos.id_equipo OR jornada_jugador.id_equipo_fuera = equipos.id_equipo";
$equipos_jornada = mysql_query($query_equipos_jornada, $laligastats) or die(mysql_error());
$row_equipos_jornada = mysql_fetch_assoc($equipos_jornada);
$totalRows_equipos_jornada = mysql_num_rows($equipos_jornada);

mysql_select_db($database_laligastats, $laligastats);
$query_estadisticas_equipo_en_forma = "SELECT id_jornada , SUM(tiros) , SUM(tiros_puerta) , SUM(goles) , SUM(asistencias) , SUM(pases) , SUM(faltas_cometidas) , SUM(faltas_recibidas) , SUM(regates_intentados) , SUM(regates_completados) , SUM(centros_completados) , SUM(tarjetas_amarillas) , SUM(tarjetas_rojas) , SUM(entradas_realizadas) , SUM(entradas_exitosas) FROM jornada_jugador , equipos , jugadores WHERE jugadores.id_equipo = equipos.id_equipo GROUP BY (jornada_jugador.id_jornada) ORDER BY jornada_jugador.id_jornada DESC";
$estadisticas_equipo_en_forma = mysql_query($query_estadisticas_equipo_en_forma, $laligastats) or die(mysql_error());
$row_estadisticas_equipo_en_forma = mysql_fetch_assoc($estadisticas_equipo_en_forma);
$totalRows_estadisticas_equipo_en_forma = mysql_num_rows($estadisticas_equipo_en_forma);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LaLiga Stats</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="img/favicon_160.png">
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Slabo+27px" rel="stylesheet">


  
</head>

<body>
<!--//BLOQUE COOKIES-->
<div id="barraaceptacion">
    <div class="inner">
        Solicitamos su permiso para obtener datos estadísticos de su navegación en esta web, en cumplimiento del Real 
        Decreto-ley 13/2012. Si continúa navegando consideramos que acepta el uso de cookies.
        <a href="javascript:void(0);" class="ok" onclick="PonerCookie();"><b>OK</b></a> | 
        <a href="http://politicadecookies.com" target="_blank" class="info">Más información</a>
    </div>
</div>
 
<script>
function getCookie(c_name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1){
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1){
        c_value = null;
    }else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1){
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}
 
function setCookie(c_name,value,exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}
 
if(getCookie('tiendaaviso')!="1"){
    document.getElementById("barraaceptacion").style.display="block";
}
function PonerCookie(){
    setCookie('tiendaaviso','1',365);
    document.getElementById("barraaceptacion").style.display="none";
}
</script>
<!--//FIN BLOQUE COOKIES-->
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
            	<a href="index.php"><img src="img/favicon_160.png" width="100%"><span>LaLiga Stats</span></a>
            </h1>
        </div>
        <nav class="menu">
        	<ul class="menu-ul">
            	<li class="menu-li"><a class="menu-a menu-a-active" href="index.php">Inicio</a></li>
                <li class="menu-li"><a class="menu-a menu-a-no" href="es/equipos.php">Equipos</a></li>
                <li class="menu-li"><a class="menu-a menu-a-no" href="es/jugadores.php">Jugadores</a></li>
                <li class="menu-li"><a class="menu-a menu-a-no" href="es/nosotros.php">Nosotros</a></li>
                <li id="admin-menu" class="menu-li"><a class="menu-a menu-a-no" href="es/intranet.php">Intranet</a></li>
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
                	<div class="numero-en-forma"><p><?php echo $row_jugador_en_forma['numero']; ?></p>
                    </div>
                    <div class="form-photo">
                        <img src="img/<?php echo $row_jugador_en_forma['foto_jugador']; ?>" alt="<?php echo $row_jugador_en_forma['nombre_completo_jugador']; ?>" width="100%">
                    </div>
                    <div class="form-player-detail">
                        <h3 class="in-form-title">Jugador en forma</h3>
                        <h3 class="player-name"><a href="#"><?php echo $row_jugador_en_forma['nombre_completo_jugador']; ?></a></h3>
                        <h2 class="players-team"><img src="img/<?php echo $row_jugador_en_forma['foto_equipo']; ?>" width="100%"> <span><?php echo $row_jugador_en_forma['nombre_equipo']; ?></span></h2>
                        <h2 class="players-info"><i class="material-icons icon-info">info_outline</i><span> <?php echo $row_jugador_en_forma['edad']; ?> años. <?php echo $row_jugador_en_forma['posicion']; ?></span></h2>
                    </div>
                </div>
                <div class="stats-container">
                	<div class="table-player-index">
                      <div class="stats-table-row">
                        <div class="stats-table-cell match-title"><span class="test" data-toggle="tooltip" title="<?php echo $row_equipos_jornada['nombre_equipo']; ?> - <?php echo $row_equipos_jornada['nombre_equipo']; ?>">
                        	<img src="img/<?php echo $row_equipos_jornada['foto_equipo']; ?>" width="100%"> - <img src="img/<?php echo $row_equipos_jornada['foto_equipo']; ?>" width="100%"></span>
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
                        <div class="match-stats stats-value"><?php echo $row_estadisticas_jugador_en_forma['marcador_casa']; ?> - <?php echo $row_estadisticas_jugador_en_forma['marcador_fuera']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['tiros']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['tiros_puerta']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['goles']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['pases']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['asistencias']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['faltas_cometidas']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['faltas_recibidas']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['regates_intentados']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['regates_completados']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['centros_completados']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['tarjetas_amarillas']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['tarjetas_rojas']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['entradas_realizadas']; ?></div>
                        <div class="stats-table-cell stats-value"><?php echo $row_estadisticas_jugador_en_forma['entradas_exitosas']; ?></div>
                      </div>
                    </div>

                </div>
			</div>
			<div class="form-team">
				<div class="main-info">
                   <div class="form-team-photo-container">
                        <img class="form-team-photo" src="img/<?php echo $row_equipo_en_forma['foto_equipo']; ?>" alt="Athletic Club" width="100%">
                   </div>
                    <div class="form-player-detail">
                        <h3 class="in-form-title">Equipo en forma</h3>
                        <h3 class="player-name"><a href="#"><?php echo $row_equipo_en_forma['nombre_equipo']; ?></a></h3>
                        <h2 class="players-team"><i class="material-icons icon-info">place</i><span><?php echo $row_equipo_en_forma['localidad']; ?></span></h2>
                        <h2 class="players-info"><i class="material-icons icon-info">info_outline</i><span> Fundado en <?php echo $row_equipo_en_forma['fundacion']; ?></span></h2>
                    </div>
                </div>
                <div class="stats-container stats-container-right">
                	<div class="table-player-index">
                      <div class="stats-table-row">
                        <div class="stats-table-cell match-title"><span class="test" data-toggle="tooltip" title="Athletic Club - Real Sociedad">
                        	<img src="img/athletic_logo.svg" width="100%"> - <img src="img/Real_Sociedad_logo.svg" width="100%"></span>
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
                        <div class="match-stats stats-value">3 - 1</div>
                        <div class="stats-table-cell stats-value">5</div>
                        <div class="stats-table-cell stats-value">3</div>
                        <div class="stats-table-cell stats-value">1</div>
                        <div class="stats-table-cell stats-value">3</div>
                        <div class="stats-table-cell stats-value">5</div>
                        <div class="stats-table-cell stats-value">1</div>
                        <div class="stats-table-cell stats-value">0</div>
                        <div class="stats-table-cell stats-value">10</div>
                        <div class="stats-table-cell stats-value">7</div>
                        <div class="stats-table-cell stats-value">1</div>
                        <div class="stats-table-cell stats-value">10</div>
                        <div class="stats-table-cell stats-value">5</div>
                        <div class="stats-table-cell stats-value">3</div>
                        <div class="stats-table-cell stats-value">1</div>
                      </div>
                    </div>

                </div>
			</div>
    	</div>
			
    </main>
</body>
</html>
<?php
mysql_free_result($jugador_en_forma);

mysql_free_result($equipo_en_forma);

mysql_free_result($estadisticas_jugador_en_forma);

mysql_free_result($equipos_jornada);

mysql_free_result($estadisticas_equipo_en_forma);
?>
