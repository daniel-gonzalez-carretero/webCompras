<!--
    Código por:         Raquel Alcázar 
    Refactorizado por:  Daniel González Carretero
-->
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
		<label for="cliente">Cliente:</label>
		<select name='cliente' required>
			<option selected disabled>Selecciona un Cliente</option>
			<?php
				foreach($clientes as $cliente) {
                    echo "<option value='". $cliente["NIF"] ."'>[". $cliente["NIF"] ."]: ". $cliente["NOMBRE"] ." ". $cliente["APELLIDO"] ."</option>";
                }
			?>
		</select><br>

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
		<input type="number" name="cantidad" min="1" required></br>

		<input type='submit' value='Comprar' name='comprar'>
	</form>
	<?php	

		if (isset($_POST) && !empty($_POST)) {
			$id_producto = $_POST["producto"];
			$nif_cliente = $_POST["cliente"];
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