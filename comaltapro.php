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
			
			$categorias = obtenerCategorias($conexion);
?>
	<h1>Alta de productos</h1>
	<form name='altaProd' method='post'action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		Nombre: <input type='text' name='nombre'><br><br>
		Precio: <input type='number' name='precio'><br><br>
		Categor&#237;a: <select name='categorias'>
						<option selected='true' disabled>-</option>
						<?php
							foreach ($categorias as $categoria => $array) {
								echo "<option value='" .$array["ID_CATEGORIA"] ."'>" .$array["ID_CATEGORIA"] ."</option>";
						}
						?>
						</select><br><br>

		<input type='submit' value='A&#241;adir producto' name='alta'>
	</form>
	
<?php		
		}else{

			$id_prod = obtenerCodProd($conexion);
			$nombre = $_REQUEST["nombre"];
			$precio = $_REQUEST["precio"];
			$id_cat = $_REQUEST["categorias"];

			insertarProducto($conexion, $id_prod, $nombre, $precio, $id_cat);			

		}

	}catch(PDOException $e){

		echo "<p>Error: " . $e->getMessage() ."</p>";
	}
			
?>
			
	</body>
</html>
