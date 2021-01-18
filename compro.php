<?php 

	if (isset($_POST) && !empty($_POST) && isset($_POST["agregarCesta"])) {
		// Si se quiere agregar el producto a la cesta

		if (isset($_COOKIE) && !empty($_COOKIE) && isset($_COOKIE["usuario"])) {
			// Se comprueba también el usuario, porque si no ha iniciado sesión, no debería poder hacer nada en esta página

			$cestaCompra = array();

			if (isset($_COOKIE["cesta"])) {

				$cestaCompra = unserialize($_COOKIE["cesta"]);
				setcookie("cesta", "eliminado", time() - (86400 * 30), "/"); // Se borra la cookie para evitar errores [NO FUNCIONA, NO SE BORRA]
			}

			$producto = $_POST["producto"];
			$cantidad = intval($_POST["cantidad"]);

			// Si el producto ya está en la cesta, se le suma la cantidad añadida a la que ya estaba añadida (no sé si tiene sentido lo que estoy escribiendo)
			// [ESTO TAMPOCO FUNCIONA, NO SE ACTUALIZA EL ARRAY]
			if (in_array($producto, $cestaCompra)) { echo "already: "; $cestaCompra[$producto] += $cantidad; var_dump($cestaCompra); }
			else { $cestaCompra[$producto] = $cantidad; } // Si es la primera vez que se añade, se crea el index con su cantidad

			setcookie("cesta", serialize($cestaCompra), time() + (86400 * 30), "/");	
		}


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

		if (!(isset($_COOKIE) && !empty($_COOKIE) && isset($_COOKIE["usuario"]))) {
			echo "<p>Parece que no has iniciado sesión aún... Haz click <a href=\"inicioSesion.php\">aquí para iniciar sesión</a>, o <a href=\"comaltacli.php\">aquí para registrarte</a> si aún no lo has hecho.</p>";
		} else {
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
		</select><br>

		<label for="cantidad">Cantidad:</label>
		<input type="number" name="cantidad" min="1" required></br><br>


		<input type='submit' value='Comprar todos los productos de la cesta' name='comprarTodo'><br>
		<input type='submit' value='Añadir a la cesta' name='agregarCesta'><br>
		<input type="reset" value="Borrar los datos">
	</form>
	<?php	
		}

		/*if (isset($_POST) && !empty($_POST)) {
			$id_producto = $_POST["producto"];
			$nif_cliente = $_POST["cliente"];
			$cantidad = $_POST["cantidad"];

			if ( realizarCompraProducto($nif_cliente, $id_producto, $cantidad) ) {
				echo "<p>La compra se ha realizado correctamente</p>";
			} // Si la función devuelve FALSE, es la propia función quien devuelve el mensaje de error
		}*/

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