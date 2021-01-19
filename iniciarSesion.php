<?php
	session_start();
	include_once("funciones.php");
	
	if (isset($_POST) && !empty($_POST)) {

		$usuario = $_POST["usuario"];
		$clave = $_POST["clave"];

		$consulta = comprobarCliente($usuario, $clave);

		if($consulta != null){
			$_SESSION["usuario"] = $consulta["nif"];
			header("location: welcomeS.php"); 
		}	

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
	<form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">
		<label for="usuario">Usuario:</label>
		<input type="text" name="usuario" required/>

		<label for="clave">Clave:</label>
		<input type="text" name="clave" required/>

		<input type="submit" />
	</form>
</body>
</html>

