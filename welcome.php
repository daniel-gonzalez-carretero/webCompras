<?php
	include_once("funciones.php");

	if (isset($_COOKIE) && !empty($_COOKIE) && isset($_COOKIE["usuario"])) {
		// Si el usuario ha iniciado sesión

		if (isset($_GET) && !empty($_GET) && isset($_GET["cerrarSesion"]) && $_GET["cerrarSesion"] == "true") {
			// ... pero quiere cerrar sesión...
			setcookie("usuario", "eliminado", time() - (86400 * 365), "/"); // Se borra la cookie
			header("location: iniciarSesion.php"); // Y se le manda a 'iniciarSesión.php'
		}

		// Si ha iniciado sesión, y no se indica que se cierre la sesión:
		$nif = $_COOKIE["usuario"];
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
	<a href="welcome.php?cerrarSesion=true">Cerrar sesión</a>
	<a href="compro.php">Comprar productos</a>
	<a href="comconscom.php">Consultar compras</a>
</body>
</html>
