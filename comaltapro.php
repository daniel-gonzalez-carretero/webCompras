<!--
    Código por:         Raquel Alcázar 
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Dar de Alta un Producto</title>
    <meta charset="utf-8" />
    <meta name="author" value="Raquel Alcázar" />
</head>
<body>
	<?php
		include_once("funciones.php");
		$categorias = obtenerCategorias();
	?>
	<h1>Alta de productos</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>

	<form method='post' action='<?php echo htmlentities($_SERVER["PHP_SELF"]);?>'>
		<label for="nombre">Nombre: </label>
		<input type='text' name='nombre'><br />

		<label for="precio">Precio: </label>
		<input type='number' name='precio'><br />

		<label>Categoría: </label> 
		<select name='categoria'>
			<option selected='true' disabled>Selecciona una Categoría</option>
			<?php
				foreach ($categorias as $categoria => $filas) {
					echo "<option value='". $filas["ID_CATEGORIA"] ."'>". $filas["ID_CATEGORIA"] ."</option>";
				}
			?>
		</select><br><br>

		<input type='submit' value='Añadir producto' name='alta'>
	</form>

	<?php		
		if (isset($_POST) && !empty($_POST)) {
			$id_prod = obtenerCodigoProducto();
			$nombre = $_REQUEST["nombre"];
			$precio = $_REQUEST["precio"];
			$id_cat = $_REQUEST["categoria"];

			if ( insertarProducto($id_prod, $nombre, $precio, $id_cat) ) {
				echo "<p>Se ha insertado el producto <strong>'". $nombre ."'</strong> correctamente.</p>";
			} // Si la función devuelve FALSE, el mensaje de error lo genera la propia función
		}
	?>

</body>

<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Actualizado el nombre de la función (obtenerCodProd -> obtenerCodigoProducto), y sus parámetros, al igual que los parámetros de 'obtenerTodo' y 'insertarProducto'
    # Eliminado el Try-Catch, ya que no era necesario
    # Actualizado la forma en que se muestra la página, para mostrar el mismo formulario aún habiendo insertado un producto previamente, agilizando el proceso
	# Cambios menores en el HTML (añadidas etiquetas <label>, ordenado de la etiqueta <head>, etc)
-->
</html>
