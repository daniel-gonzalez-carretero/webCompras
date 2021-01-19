<?php 
	include_once("funciones.php");

	//setcookie("cesta", "eliminado", time() - (86400 * 30), "/"); // Para borrar la Cookie, cuando se intente probar (para empezar sin productos, vaya)
	if (isset($_POST) && !empty($_POST) && isset($_POST["agregarCesta"]) && isset($_POST["producto"]) ) {
		// Si se quiere agregar el producto a la cesta

		if (isset($_COOKIE) && !empty($_COOKIE) && isset($_COOKIE["usuario"])) {
			// Se comprueba también el usuario, porque si no ha iniciado sesión, no debería poder hacer nada en esta página

			$idProducto = $_POST["producto"];  # ID del producto a añadir
			$cantidadSumar = intval($_POST["cantidad"]); # Cantidad de ese producto a añadir
			$stockTotal = consultarStockTotal($idProducto)["cantidadProducto"]; # Cantidad total que hay en los almacenes
			
			if (isset($_COOKIE["cesta"])) {
	
				$cestaString = $_COOKIE["cesta"];

				if (strpos($cestaString, $idProducto) != false) { # Si el producto ESTÁ ya añadido a la cesta
					$stringBuscar = '"' . $idProducto . '";i:'; # String a buscar en la cesta serializada
					$cantidadActual = intval(substr($cestaString, strpos($cestaString, $stringBuscar) + strlen($stringBuscar), 10)); # Se obtiene, de la cesta serializada, la cantidad actual de ese producto en la cesta

					
					if ($stockTotal != null && $stockTotal >= ($cantidadActual + $cantidadSumar)) {

						// Se buscan los extremos del String de la cesta (omitiendo la parte central, que correspondería al producto que se está 'añadiendo')
						$izq  = substr($cestaString, 0, strpos($cestaString, $stringBuscar));
						$dcha = substr($cestaString, strpos($cestaString, $stringBuscar) + strlen($stringBuscar) + strlen(strval($cantidadActual)), strlen($cestaString));

						// Se añade la nueva información a la cookie
						setcookie("cesta", $izq . $stringBuscar . ($cantidadActual + $cantidadSumar) . $dcha , time() + (86400 * 30), "/");
					} else {
						echo "<p style='font-weight: bold;'>¡Oops! No hay tanta cantidad de ese producto en nuestros almacenes...</p>";
					}
				} else {
					// Si el producto aún no está en la cesta, se añade sin más
						
					if ($stockTotal != null && $stockTotal >= $cantidadSumar) {
						$numArray = intval(substr($cestaString, 2, 1)) + 1;
						$cestaString = substr($cestaString, 3, strlen($cestaString) - 4);
						$cestaString = $cestaString . "s:". strlen($idProducto) . ':"'. $idProducto .'";i:'. $cantidadSumar .";}";
						setcookie("cesta", "a:" . $numArray . $cestaString , time() + (86400 * 30), "/");
					} else {
						echo "<p style='font-weight: bold;'>¡Oops! No hay tanta cantidad de ese producto en nuestros almacenes...</p>";
					}
				}

			} else {
				setcookie("cesta", serialize(array($idProducto => $cantidadSumar)), time() + (86400 * 30), "/");
			}
		} // NO SE HA INICIADO SESIÓN
	} // NO SE HA ENVIADO UNA PETICION POST

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
