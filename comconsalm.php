<html>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Edu Gutierrez">
		<title>Web Compras</title>
	</head>
		<body>
<?php

	include_once("funciones.php");
	include_once("conexion.php");

	try{

		if(!isset($_POST) || empty($_POST)){
			
			$almacenes = obtenerAlmacenes($conexion);
?>
	<h1>Consulta Productos Almacenes</h1>
	<form name='consultaProd' method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		Almacenes: <select name='almacen'>
						<option selected='true' disabled>-</option>
						<?php
							foreach ($almacenes as $almacen => $array) {
                                echo "<option value='" .$array["NUM_ALMACEN"] ."'>" .$array["LOCALIDAD"] ."</option>";
						}
						?>
						</select><br><br>

		<input type='submit' value='Consultar productos' name='consultar'>
	</form>
<?php		
		}else {
            $num_almacen = $_REQUEST["almacen"];
			obtenerProdAlmacenes($conexion,$num_almacen);			
		}

	}catch(PDOException $e){

		echo "<p>Error: " . $e->getMessage() ."</p>";
	}
			
?>
			
	</body>
</html>
