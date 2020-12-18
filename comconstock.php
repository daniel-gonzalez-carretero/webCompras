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

			$productos = obtenerTodo($conexion, "producto");
		
?>
	<h1>Consulta de Stock</h1>
	<form name='consulStock' method='post'action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="productos">Productos:</label>
		<select name='productos'>
						<option selected='true' disabled>-</option>
						<?php
							foreach ($productos as $producto => $array) {
								echo "<option value='" .$array["ID_PRODUCTO"] ."'>" .$array["NOMBRE"] ."</option>";
						}
						?>
						</select><br><br>

		<input type='submit' value='Ver stock' name='stock'>
	</form>
	
<?php		
		}else{

			$id_producto = $_REQUEST["productos"];
			
			$stock = consultarStock($conexion, $id_producto);	

			verStock($stock);
	
		}

	}catch(PDOException $e){

		echo "<p>Error: " . $e->getMessage() ."</p>";
	}
			
?>
			
	</body>
</html>
