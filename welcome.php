<?php
	include_once("funciones.php");

	$nif = $_COOKIE["usuario"];
	$datos = obtenerNombre($nif);
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
	<a href="iniciarSesion.php">Cerrar sesión</a>
	<a href="comproC.php">Comprar productos</a>
	<a href="comconscom.php">Consultar compras</a>
</body>
</html>
