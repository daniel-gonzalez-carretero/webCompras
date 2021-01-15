<!--
    Código por:         Daniel González Carretero 
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Dar de Alta un Cliente</title>
    <meta charset="utf-8" />
    <meta name="author" value="Daniel González Carretero" />
</head>
<body>
	<h1>Dar de Alta a un Cliente</h1>
	<p><a href="index.html">Volver al Menú</a></p><br><br>
	
	<form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">
		<label for="nif">NIF:</label>
		<input type="text" name="nif" required><br>

		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" required><br>

		<label for="apellido">Apellido/s: </label>
		<input type="text" name="apellido" required><br>

		<label for="cp">Código Postal</label>
		<input type="text" name="cp" required><br>

		<label for="direc">Dirección:</label>
		<input type="text" name="direc" required><br>

		<label for="ciudad">Ciudad</label>
		<input type="text" name="ciudad" required><br>

		<input type="submit" name="submit" value="Dar de Alta">
	</form>
	<?php 

		include_once("funciones.php");
		if (isset($_POST) && !empty($_POST)) {

			$nif = $_POST['nif'];
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$cp = $_POST['cp'];
			$direc = $_POST['direc'];
			$ciudad = $_POST['ciudad'];

			$puedeEjecutar = true; // ¿Puede ejecutarse el insertado de datos?

			// NIF no está vacío, y tiene 8 dígitos y una letra
			$puedeEjecutar = isset($nif) && (preg_match('/^(\d{8}[A-Z])$/i', $nif) == 1); // preg_match() es el RegExp de PHP

			// Se comprueba que NIF no está repetido
			$clientesMismoNif = obtenerClienteNIF($nif);
			$puedeEjecutar = $puedeEjecutar && $clientesMismoNif == null;

			if ($puedeEjecutar) {
			// Se ejecuta la inserción de los datos
				if ( insertarCliente($nif, $nombre, $apellido, $cp, $direc, $ciudad) ) {
					echo "<p>Se ha dado de alta al cliente correctamente.</p>";
					echo "<p>Sus credenciales son: </p>";
					echo "<ul>
							<li><strong>Usuario: </strong>". preg_replace('/\s+/', '', strtolower($nombre)) ."</li>
							<li><strong>Contraseña: [</strong><span style='color: white'>". strrev(preg_replace('/\s+/', '', strtolower($apellido))) ."</span>]</li>
							<li>Para ver la contraseña, haz doble click en el espacio entre los corchetes. Asegúrate de que nadie puede verla, únicamente tú.</li>
						</ul>";
				} // Si la función devuelve FALSE, es la propia función quien genera el mensaje de error

			} else {
				// Hay algún error
				echo "<p><strong>Parece que hay un error con el NIF introducido.</strong> Prueba lo siguiente:</p><ul><li>Comprueba que no lo hayas dejado en blanco</li><li>Comprueba que tiene exactamente 8 dígitos, y una letra al final</li><li>Asegurate que no has dado de alta a un mismo cliente con ese NIF</li></ul>";
				
				echo "<p><strong>Estos son los datos introducidos antes:</strong></p>
					  <blockquote>
						  <strong>NIF: </strong>". $nif . "</br>
						  <strong>Nombre: </strong>". $nombre . "</br>
						  <strong>Apellido/s: </strong>". $apellido . "</br>
						  <strong>Código Postal: </strong>". $cp . "</br>
						  <strong>Dirección: </strong>". $direc . "</br>
						  <strong>Ciudad: </strong>". $ciudad . "</br>
					  </blockquote>";
			}

		}

	?>

</body>

<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Se traspasa los bloques de código a funciones (obtenerClienteNIF, y insertarCliente)
    # Se cambia el atributo 'action', de la etiqueta <form>, para que sea igual que en el resto de archivos
    # Se usa como 'method' POST, en vez de GET
    # Editados los mensajes informativos
    # Se elimina el TRY-CATCH, las funciones tratan los errores
-->
</html>

<!-- Cambios 

	se usan las nuevas funciones
	se añade al formulario el atributo action, de la misma forma que en el resto de archivos
	se usa, como method, POST en vez de GET
	modificados los mensajes informativos
	se elimina el TRY-CATCH ya que ya no es necesario

-->
