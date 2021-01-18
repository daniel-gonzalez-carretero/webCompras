<!--
    Código por:         Raquel Alcázar 
    Refactorizado por:  Daniel González Carretero
-->
<?php
	if (isset($_POST) && !empty($_POST)){
	  // AGREGAR A LA CESTA DE LA COMPRA
		if (isset($_POST["agregar"]) && !empty($_POST["agregar"])) {

		    if (!isset($_COOKIE["cesta"])) {
		    	$cesta[$_POST["producto"]]=$_POST["cantidad"];
			  	$_COOKIE["cesta"]=$cesta;
			  	echo "hola";
			}else{
				$cesta=$_COOKIE["cesta"];
				$cesta[$_POST["producto"]]=$_POST["cantidad"];
				$_COOKIE["cesta"]=$cesta;
				echo "adios";
			}
		    	
		}
		
		print_r($_COOKIE["cesta"]);

	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Realizar una compra</title>
    <meta charset="utf-8" />
    <meta name="author" value="Raquel Alcázar" />
</head>
		<body>

	<h1>Realizar una compra</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>

	<?php 
		include_once("funciones.php");
		$productos = obtenerProductos();
		$clientes = obtenerClientes();
	?>
	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="producto">Producto:</label>
		<select name='producto' required>
			<option selected disabled>Selecciona un Producto</option>
			<?php
				foreach($productos as $producto) {
                    echo "<option value='". $producto["ID_PRODUCTO"] ."'>[". $producto["ID_PRODUCTO"] ."]: ". $producto["NOMBRE"] ."</option>";
                }
			?>
		</select><br><br>

		<label for="cantidad">Cantidad:</label>
		<input type="number" name="cantidad" min="1" required></br></br>

		<input type="submit" value="Comprar" name="comprar">
		<input type="submit" value="Agregar a la Cesta" name="agregar">
		<input type="submit" value="Limpiar la Cesta" name="limpiar">
	</form>
	<?php	

		if (isset($_POST) && !empty($_POST)) {
			$id_producto = $_POST["producto"];
			$nif_cliente = $_COOKIE["usuario"];
			$cantidad = $_POST["cantidad"];

			if ( realizarCompraProducto($nif_cliente, $id_producto, $cantidad) ) {
				echo "<p>La compra se ha realizado correctamente</p>";
			} // Si la función devuelve FALSE, es la propia función quien devuelve el mensaje de error
		}

	?>	
</body>
<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Actualizado el nombre de la función (validarCompraProd -> realizarCompraProducto), y sus parámetros
    # Invertida la condición del IF, para evitar el ELSE innecesario
    # Añadido mensaje informativo, si todo funciona como se esperaba
    # Eliminado el TRY-CATCH, los errores los tratan las funciones
    # Se añade un <select> para seleccionar qué usuario hace la compra. Obligatorio para actualizar la tabla 'compra'
-->
</html>
