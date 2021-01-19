<?php
	session_start();
	include_once("funciones.php");

	if (isset($_SESSION) && !empty($_SESSION) && isset($_SESSION["usuario"])) {
		// Si el usuario ha iniciado sesión

		if (isset($_GET) && !empty($_GET) && isset($_GET["cerrarSesion"]) && $_GET["cerrarSesion"] == "true") {
			// ... pero quiere cerrar sesión...
			session_unset();
			session_destroy();
			// Se borra la cookie
			header("location: iniciarSesion.php"); // Y se le manda a 'iniciarSesión.php'
		}

		// Si ha iniciado sesión, y no se indica que se cierre la sesión:
		$nif = $_SESSION["usuario"];
		$datos = obtenerNombre($nif);

	} else {
		// Si el usuario NO ha iniciado sesión
		header("location: iniciarSesion.php"); // Se le manda a 'iniciarSesión.php'
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Web Compras</title>
	<meta charset="utf-8" />
	<meta name="author" value="Raquel Alcázar" />
</head>
<body>
	<h1>Bienvenido <?php echo $datos["nombre"]; ?></h1>
	<li><a href="welcome.php?cerrarSesion=true">Cerrar sesión</a></li>
	<li><a href="compro.php">Comprar productos</a></li>
	<li><a href="comconscom.php">Consultar compras</a></li>
</body>
</html>
