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
	<h1>Compra</h1>
	<form name='compra' method='post'action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="productos">Producto:</label>
		<select name='productos'>
						<option selected='true' disabled>-</option>
						<?php
							foreach ($productos as $producto => $array) {
								echo "<option value='" .$array["ID_PRODUCTO"] ."'>" .$array["NOMBRE"] ."</option>";
						}
						?>
						</select><br><br>
		<label for="cantidad">Cantidad:</label>
		<input type="number" name="cantidad" min="0"></br></br>

		<input type='submit' value='Comprar' name='comprar'>
	</form>
	
<?php		
		}else{

			$id_producto = $_REQUEST["productos"];
			$cantidad = $_REQUEST["cantidad"];
			
			$stock = consultarStock($conexion, $id_producto);	

			validarCompraProd($conexion, $id_producto, $cantidad, $stock);
			
		}

	}catch(PDOException $e){

		echo "<p>Error: " . $e->getMessage() ."</p>";
	}
			
?>
			
	</body>
</html>
