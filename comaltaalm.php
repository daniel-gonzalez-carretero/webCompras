<html>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Raquel Alcázar">
		<title>Web Compras</title>
	</head>
		<body>
<?php

	include_once("funciones.php");
	include_once("conexion.php");

	try{

		if(!isset($_POST) || empty($_POST)){
		
?>
	<h1>Alta de almacenes</h1>
	<form name='altaAlm' method='post'action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		Localidad: <input type='text' name='localidad'><br><br>

		<input type='submit' value='A&#241;adir almacen' name='alta'>
	</form>
	
<?php		
		}else{

			$num_almacen = obtenerCodAlmacen($conexion);
			$localidad = $_REQUEST["localidad"];
			
			insertarAlmacen($conexion, $num_almacen, $localidad);			
	
		}

	}catch(PDOException $e){

		echo "<p>Error: " . $e->getMessage() ."</p>";
	}
			
?>
			
	</body>
</html>
