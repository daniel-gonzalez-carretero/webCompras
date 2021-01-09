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

			$clientes = obtenerTodo($conexion, "cliente");
		
?>
	<h1>Consulta de compras</h1>
	<form name='consCompras' method='post'action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="nif">NIF</label>
		<select name='nif'>
			<option selected='true' disabled>-</option>
			<?php
				foreach ($clientes as $cliente => $datos) {
					echo "<option value='" .$datos["NIF"] ."'>" .$datos["NIF"] ."</option>";
				}
			?>
		</select><br><br>

		<label for="fecha_desde">Desde </label>
		<input type='date' name='fecha_desde'><br><br>

		<label for="fecha_hasta">Hasta </label>
		<input type='date' name='fecha_hasta'><br><br>

		<input type='submit' value='Ver compras' name='alta'>
	</form>
	
<?php		
		}else{

			$nif = $_REQUEST["nif"];
			$fecha_desde = $_REQUEST["fecha_desde"];
			$fecha_hasta = $_REQUEST["fecha_hasta"];
			
			$comprasCliente = consultarCompras($conexion, $nif, $fecha_desde, $fecha_hasta);		

			verCompras($comprasCliente);	
	
		}

	}catch(PDOException $e){

		echo "<p>Error: " . $e->getMessage() ."</p>";
	}
			
?>
			
	</body>
</html>
