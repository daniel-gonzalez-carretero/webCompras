<?php 
	// Si el usuario ya ha iniciado sesión, se le manda directamente a 'welcome.php'
	if (isset($_COOKIE) && !empty($_COOKIE) && isset($_COOKIE["usuario"])) {
		header("location: welcome.php"); 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ejercicio 11</title>
	<meta charset="utf-8" />
	<meta name="author" value="Silvia Ranera" />
</head>
<body>
	<h1>Iniciar Sesión</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>

	<form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">
		<label for="usuario">Usuario:</label>
		<input type="text" name="usuario" required/>

		<label for="clave">Clave:</label>
		<input type="password" name="clave" required/>

		<input type="submit" />
	</form>
</body>
</html>
<?php	
	include_once("funciones.php");

	if (isset($_POST) && !empty($_POST)) {

		$usuario = $_POST["usuario"];
		$clave = $_POST["clave"];

		$consulta = comprobarCliente($usuario, $clave);

		if($consulta != null){
			setcookie("usuario", $consulta["nif"], time() + (86400 * 30), "/");
			header("location: welcome.php"); 
		} else {
			echo "<p>Usuario y/o la contraseña no es correcta.</p>";
		}

	}
				
?>
