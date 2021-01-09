<!--
    Código por:         Raquel Alcázar 
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Dar de Alta un Almacén</title>
    <meta charset="utf-8" />
    <meta name="author" value="Raquel Alcázar" />
</head>
<body>
	<h1>Alta de Almacenes</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>
	
	<form method='post' action='<?php echo htmlentities($_SERVER["PHP_SELF"]);?>'>
		<label for="localidad">Localidad: </label>
		<input type="text" name="localidad" required> <br/>

		<input type='submit' value='Añadir almacen'>
	</form>

	<?php

		include_once("funciones.php");
		if (isset($_POST) && !empty($_POST)) {
			$num_almacen = obtenerCodigoAlmacen();
			$localidad = $_POST["localidad"];
			if ( insertarAlmacen($num_almacen, $localidad) ) {
				echo "<p>Se ha insertado el almacén, situado en <strong>'". $localidad ."'</strong> correctamente.</p>";
			} // Si la función devuelve FALSE, es la propia función quien devuelve el mensaje de error

		}
			
	?>
		
</body>

<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Actualizado el nombre de la función (obtenerCodAlmacen -> obtenerCodigoAlmacen), y sus parámetros
    # Se elimina el TRY-CATCH, la función trata los errores
    # Añadido mensaje informativo, si todo funciona como se esperaba
-->
</html>