<!--
    Código por:         Raquel Alcázar
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Consultar el Stock de un Producto</title>
    <meta charset="utf-8" />
    <meta name="author" value="Raquel Alcázar" />
</head>
<body>

	<h1>Consulta el Stock de un Producto</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>
	
	<?php 
        include_once("funciones.php");
        $productos = obtenerProductos();
    ?>

	<form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label for="producto">Producto: </label>
        <select name="producto" required>
            <option disabled selected>Selecciona un Producto</option>
            <?php
                foreach($productos as $producto) {
                    echo "<option value='". $producto["ID_PRODUCTO"] ."'>[". $producto["ID_PRODUCTO"] ."]: ". $producto["NOMBRE"] ."</option>";
                }
            ?>
        </select><br />

		<input type='submit' value='Ver stock' name='stock'>
	</form>
	
	<?php		
		if (isset($_POST) && !empty($_POST)) {

			$id_producto = $_POST["producto"];
			$stock = consultarStock($id_producto);	

			if ($stock == null) {
				echo "<p>Parece que ninguno de nuestros almacenes tiene este producto en Stock...</p>";
			} else {
				verStock($stock);
			}

		}
				
	?>
			
</body>
<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Invertida la condición del IF, para evitar el ELSE innecesario
    # Añadido mensaje informativo, y se comprueba que el stock no sea NULL
    # Se elimina el TRY-CATCH, los errores los tratan las propias funciones
-->
</html>