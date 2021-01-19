<!--
    Código por:         Raquel Alcázar 
    Refactorizado por:  Daniel González Carretero
-->
<?php
	session_start();
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
		<input type="number" name="cantidad" min="1" ></br></br>

		<input type="submit" value="Comprar" name="comprar">
		<input type="submit" value="Agregar a la Cesta" name="agregar">
		<input type="submit" value="Limpiar la Cesta" name="limpiar">
	</form>
	<?php	
		include_once("funciones.php");
		if (isset($_POST) && !empty($_POST)){
	  	// AGREGAR A LA CESTA DE LA COMPRA
		if (isset($_POST["agregar"]) && !empty($_POST["agregar"])) {

			if(isset($_POST["producto"])){
				if($_POST["cantidad"]!=null){

					$codigoProducto = $_POST["producto"];
					$cantidadAgregar = $_POST["cantidad"];
					$stock = consultarStockTotal($codigoProducto);

		 			if (!isset($_SESSION["cesta"])){

		 				if ($stock["cantidadProducto"]!=null && $stock["cantidadProducto"]>=$_POST["cantidad"]){

		 					$cesta[$codigoProducto]=$cantidadAgregar;
						  	$_SESSION["cesta"]=$cesta;
		 				}else{
		 					echo "<p>Lo sentimos, no hay stock suficiente..<p>";
		 				}

		 			}else{
						$cesta=$_SESSION["cesta"];

						if(array_key_exists($codigoProducto, $cesta)){

							if($stock["cantidadProducto"]>=($cesta[$codigoProducto]+$cantidadAgregar)){
								$cesta[$codigoProducto]+=$cantidadAgregar;
							}else{
								echo "<p>Lo sentimos, no se pueden añadir más unidades de ese producto...<p>";
							}
							
						}else{

							if($stock["cantidadProducto"]>=($cesta[$codigoProducto]+$cantidadAgregar)){
								$cesta[$codigoProducto]=$cantidadAgregar;
							}else{
								echo "<p>Lo sentimos, no hay stock suficiente...<p>";
							}
						}

						$_SESSION["cesta"]=$cesta;

		 			}
				}else{
					echo "<p>Debes indicar una cantidad.</p>";
				}
			}else{
				echo "<p>Debes seleccionar un producto.</p>";
			}
	
		}else if(isset($_POST["comprar"]) && !empty($_POST["comprar"])){

			if(isset($_SESSION["cesta"])){
				$compraCorrecta=realizarCompra($_SESSION["cesta"], $_SESSION["usuario"]);

				if($compraCorrecta){
					$_SESSION["cesta"]=null;
				}
			}else{
				echo "<p>Añade los productos que quieras comprar a la cesta.</p>";
			}
			

		}else if(isset($_POST["limpiar"]) && !empty($_POST["limpiar"])){

			$_SESSION["cesta"]=null;

		}
		
		print_r($_SESSION["cesta"]);
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
