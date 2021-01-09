<!--
    Código por:         Edu Gutierrez
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Consultar el Stock de un Almacén</title>
    <meta charset="utf-8" />
    <meta name="author" value="Edu Gutierrez" />
</head>
<body>

	<h1>Consulta Productos Almacenes</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>

	<?php

		include_once("funciones.php");
		$almacenes = obtenerAlmacenes();
	
	?>

	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="almacen">Almacén: </label>
        <select name="almacen" required>
            <option disabled selected>Selecciona un Almacén</option>
            <?php
                foreach($almacenes as $almacen) {
                    echo "<option value='". $almacen["NUM_ALMACEN"] ."'>[". $almacen["NUM_ALMACEN"] ."]: ". $almacen["LOCALIDAD"] ."</option>";
                }
            ?>
        </select><br />

		<input type='submit' value='Consultar productos' name='consultar'>
	</form>

	<?php	

		if(isset($_POST) && !empty($_POST)){
            $num_almacen = $_POST["almacen"];
            // La propia función gestiona los posibles errores
			obtenerProductosAlmacenes($num_almacen);			
		}
			
	?>
			
</body>
<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Actualizado el nombre de la función (obtenerProdAlmacenes -> obtenerProdAlmacenes), y sus parámetros
    # Invertida la condición del IF, para evitar el ELSE innecesario
-->
</html>