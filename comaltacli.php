<!DOCTYPE html>
<html>
<head>
	<title>Dar de Alta un Cliente</title>
	<meta charset="utf-8" />
	<!-- Daniel González Carretero -->
</head>
<body>

<?php 
	include 'conexion.php';
	if (!isset($_REQUEST) || empty($_REQUEST)) {
?>
<form method="get" action="#">
	<label>NIF:</label>
	<input type="text" name="nif" required><br>
	<label>Nombre:</label>
	<input type="text" name="nombre" required><br>
	<label>Apellido/s: </label>
	<input type="text" name="apellido"><br>
	<label>Código Postal</label>
	<input type="text" name="cp"><br>
	<label>Dirección:</label>
	<input type="text" name="direc"><br>
	<label>Ciudad</label>
	<input type="text" name="ciudad"><br>
	<input type="submit" name="submit" value="Dar de Alta">
</form>
<?php 
} else {
	try {
		$nif = $_REQUEST['nif'];
		$nombre = $_REQUEST['nombre'];
		$apellido = $_REQUEST['apellido'];
		$cp = $_REQUEST['cp'];
		$direc = $_REQUEST['direc'];
		$ciudad = $_REQUEST['ciudad'];


		$puedeEjecutar = true; // ¿Puede ejecutarse el insertado de datos?

		// NIF no está vacío, y tiene 8 dígitos y una letra
		$puedeEjecutar = isset($nif) && (preg_match('/^(\d{8}[A-Z])$/i', $nif) == 1); // preg_match() es el RegExp de PHP

		// Se comprueba que NIF no está repetido
		$consulta = $conexion->prepare("SELECT * FROM cliente WHERE nif = :nif");
		$consulta->bindParam(":nif", $nif);
		$consulta->execute();

		$consulta->setFetchMode(PDO::FETCH_ASSOC); 
		$clientesMismoNif = $consulta->fetchAll();

		$puedeEjecutar = $puedeEjecutar && !(count($clientesMismoNif) > 0);

		if ($puedeEjecutar) {
			// Se ejecuta la inserción de los datos

			$insertCliente = $conexion->prepare("INSERT INTO cliente (nif, nombre, apellido, cp, direccion, ciudad) VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad)");
			$insertCliente->bindParam(":nif", $nif);
			$insertCliente->bindParam(":nombre", $nombre);
			$insertCliente->bindParam(":apellido", $apellido);
			$insertCliente->bindParam(":cp", $cp);
			$insertCliente->bindParam(":direccion", $direc);
			$insertCliente->bindParam(":ciudad", $ciudad);

			$insertCliente->execute();

			echo "<h1>¡Genial!</h1><p>Parece que todo ha funcionado a la perfección</p>";


		} else {
			// Hay algún error
			echo "<h1>¡Vaya! Parece que hay un error con el NIF introducido</h1><p>Prueba lo siguiente:</p><ul><li>Comprueba que has introducido un NIF</li><li>Comprueba que tiene exactamente 8 dígitos, y una letra al final</li><li>Asegurate que no has dado de alta a un mismo cliente con ese NIF</li></ul>";
		}



	} catch(PDOException $ex) {
		echo "<h1 style='color: red'>Problemas: ". $ex->getMessage() . "</h1>";
	}
}

?>

</body>
</html>