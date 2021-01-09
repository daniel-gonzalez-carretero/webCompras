<!---->
<!--
    Código por:         Raquel Alcázar
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Ver Historia de Compras</title>
    <meta charset="utf-8" />
    <meta name="author" value="Raquel Alcázar" />
</head>
<body>

	<h1>Ver el Historial de Compras</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>
	
	<?php 
		include_once("funciones.php");
		$clientes = obtenerClientes();
	?>

	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="cliente">Cliente: </label>
		<select name='cliente' required>
			<option selected disabled>Selecciona un Cliente</option>
			<?php
				foreach($clientes as $cliente) {
                    echo "<option value='". $cliente["NIF"] ."'>[". $cliente["NIF"] ."]: ". $cliente["NOMBRE"] ." ". $cliente["APELLIDO"] ."</option>";
                }
			?>
		</select><br>

		<label for="fecha_desde">Desde... </label>
		<input type='date' name='fecha_desde' required><br>

		<label for="fecha_hasta">Hasta... </label>
		<input type='date' name='fecha_hasta' required><br>

		<input type='submit' value='Ver compras' name='alta'>
	</form>
	
<?php		
		if (isset($_POST) && !empty($_POST)) {
			$nif = $_POST["cliente"];
			$fecha_desde = $_POST["fecha_desde"];
			$fecha_hasta = $_POST["fecha_hasta"];
			
			$comprasCliente = consultarCompras($nif, $fecha_desde, $fecha_hasta);		
			verCompras($comprasCliente); // La función ya trata los posibles errores
		}
?>
			
</body>
<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Invertida la condición del IF, para evitar el ELSE innecesario
    # Se elimina el TRY-CATCH, los errores los tratan las funciones
-->
</html>