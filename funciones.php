<?php

include_once 'conexion.php';

function altaCategoria($nombre, $descripcion) {
# Función 'altaCategoría'. 
# Parámetros: 
# 	- $nombre (nombre de la categoría, que será la Clave Primaria)
#	- $descripcion (descripción de la categoría)
#
# Funcionalidad:
# Inserta una nueva categoría en la tabla 'categoria'
#
# Retorna: TRUE / FALSE, en caso de que todo vaya bien o haya algún error
#
# Código por Marco Santiago
# Refactorizado por Daniel González Carretero

	global $conexion;
    try {
    	// Sentencia anterior:
    	//  insert into categoria (ID_CATEGORIA,NOMBRE)values('$categoria','$codigo')
    	$conexion->beginTransaction();

		$insertarCategoria = $conexion->prepare("INSERT INTO categoria (ID_CATEGORIA, NOMBRE) VALUES (:nombre, :descripcion)");
		$insertarCategoria->bindParam(':nombre', $nombre);
		$insertarCategoria->bindParam(':descripcion', $descripcion);
        $insertarCategoria->execute();

        $conexion->commit();
        return true;

    } catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al dar de alta la categoría: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		$conexion->rollBack();
		return false;
    }


# Cambios de Refactorización Realizados:
# 	- Actualizado el nombre de la función
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#   - Añadida la posibilidad de hacer Roll Back si algo falla, o Commit si todo funciona correctamente
#   - Modificada la sentencia de INSERT, para mayor claridad (no hay cambios relevantes, únicamente estéticos)
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



##
# La función 'obtenerTodo($tabla)' se convierte en las siguientes funciones:
# 	- obtenerCategorias()
# 	- obtenerProductos()
# 	- obtenerAlmacenes()
# 	- obtenerClientes()
##



function obtenerCategorias() {
# Función 'obtenerCategorias'. 
# Parámetros: 
# 	- (ninguno)
#
# Funcionalidad:
# Obtiene todos los datos de la tabla 'categoria'
#
# Retorna: Información sobre la tabla 'categoria' / NULL si hay algún error
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	// Sentencia anterior:
	// SELECT * FROM $tabla
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM categoria");
		$obtenerInfo->execute();
		return $obtenerInfo->fetchAll(PDO::FETCH_ASSOC); # Si falla, devuelve NULL por defecto

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos de las Categorías: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function obtenerProductos() {
# Función 'obtenerProductos'. 
# Parámetros: 
# 	- (ninguno)
#
# Funcionalidad:
# Obtiene todos los datos de la tabla 'producto'
#
# Retorna: Información sobre la tabla 'producto' / NULL si hay algún error
#
# Código por Raquel Alcázar y Marco Santiago (ambos hicieron su versión de la misma función)
# Refactorizado por Daniel González Carretero

	global $conexion;

	// Sentencia anterior:
	// SELECT * FROM $tabla
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM producto");
		$obtenerInfo->execute();
		return $obtenerInfo->fetchAll(PDO::FETCH_ASSOC); # Si falla, devuelve NULL por defecto

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos de los Productos: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
	
# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function obtenerCodigoProducto() {
# Función 'obtenerCodigoProducto'. 
# Parámetros: 
# 	- (ninguno)
#
# Funcionalidad:
# Determina y devuelve el siguiente código del siguiente producto añadido manualmente
#
# Retorna: Código a usar para el próximo producto / NULL si ha habido algún error
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	// Método anterior:
	// $maximo => SELECT max(substr(ID_PRODUCTO, 2)) as maximo FROM producto
	// $codigo => (int) $maximo + 1
	// $codigo => "P" . str_pad($codigo, 3, 0, STR_PAD_LEFT)
	try {
		$nuevoCodigo = $conexion->prepare("SELECT CONCAT('P', LPAD(SUBSTR(MAX(id_producto), 2)+1, 4, '0')) AS 'codigo' FROM producto WHERE id_producto LIKE 'P%'");
		$nuevoCodigo->execute();
		$codigo = $nuevoCodigo->fetch(PDO::FETCH_ASSOC)["codigo"];

		return $codigo == NULL ? "P0001" : $codigo; // Si no existe un producto con un ID que empiece por 'P' (es decir, la consulta devuelve NULL), devuelve el código 'P0001';

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver el Código del Producto: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
	

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#   - Modificada la sentencia de SELECT, para mayor claridad y mejora de eficiencia (al sustituir sentencias PHP por la sentencia de SQL)
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
# 	- Añadida la excepción para el cáso límite de la primera ejecución de la función sin haber productos previos (antes devolvía NULL, y por tanto, error)
}



function insertarProducto($id_prod, $nombre, $precio, $id_cat){
# Función 'insertarProducto'. 
# Parámetros: 
# 	- $id_prod (id del producto a insertar)
# 	- $nombre (nombre del producto a insertar)
# 	- $precio (precio del producto a insertar)
# 	- $id_cat (id de la categoría a la que pertenece el producto a insertar)
#
# Funcionalidad:
# Inserta un nuevo producto en la tabla 'producto'
#
# Retorna: TRUE / FALSE según si se ha ejecutado correctamente o no
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	try {
		$conexion->beginTransaction();

		$insertarProducto = $conexion->prepare("INSERT INTO producto (ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES (:id_prod, :nombre, :precio, :id_cat)");
		$insertarProducto->bindParam(':id_prod', $id_prod);
		$insertarProducto->bindParam(':nombre', $nombre);
		$insertarProducto->bindParam(':precio', $precio);
		$insertarProducto->bindParam(':id_cat', $id_cat);
		$insertarProducto->execute();

		$conexion->commit();
		return true;

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al intentar dar de alta al Producto: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		$conexion->rollBack();
		return false;
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#   - Modificada la sentencia de SELECT, con un único propósito estético
#	- Se añade un TRY-CATCH para que sea la propia función quien trata los errores
# 	- Se añade la posibilidad de realizar un RollBack en caso de haber habido algún error
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function obtenerCodigoAlmacen() {
# Función 'obtenerCodigoAlmacen'. 
# Parámetros: 
# 	- (ninguno)
#
# Funcionalidad:
# Determina el código del próximo almacen, según el último registrado
#
# Retorna: Código a usar para el próximo almacen, o NULL si hay algún error
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	try {

		// Método anterior:
		// $maximo => SELECT max(NUM_ALMACEN) as maximo FROM almacen
		// $maximo => (int) $maximo + 10

		$codigoAlmacen = $conexion->prepare("SELECT MAX(num_almacen) + 10 AS 'Maximo' FROM almacen");
		$codigoAlmacen->execute();
		$codigo = $codigoAlmacen->fetch(PDO::FETCH_ASSOC)["Maximo"];

		return $codigo == NULL ? 10 : $codigo; // Si no hay otros almacenes previos (es decir, $codigo es NULL), devuelve 10. Si no, devuelve $codigo

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver el Código del Almacén: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return NULL;
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#   - Modificada la sentencia de SELECT, para mayor claridad y mejora de eficiencia (al sustituir sentencias PHP por la sentencia de SQL)
#	- Se añade un TRY-CATCH para que sea la propia función quien trata los errores
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function insertarAlmacen($numAlmacen, $localidad) {
# Función 'insertarAlmacen'. 
# Parámetros: 
# 	- $numAlmacen (número del almacen, que hace de Clave Primaria)
# 	- $localidad (localidad donde está situado el almacen)
#
# Funcionalidad:
# Inserta un nuevo almacén en la tabla 'almacen'
#
# Retorna: TRUE / FALSE según si se ha ejecutado correctamente o no
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	try {
		$conexion->beginTransaction();

		$insertarAlmacen = $conexion->prepare("INSERT INTO almacen (num_almacen, localidad) VALUES (:num_almacen, :localidad)");
		$insertarAlmacen->bindParam(':num_almacen', $numAlmacen);
  		$insertarAlmacen->bindParam(':localidad', $localidad);
  		$insertarAlmacen->execute();

  		$conexion->commit();
  		return true;

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al intentar dar de alta al Almacén: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		$conexion->rollBack();
		return false;
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se añade un TRY-CATCH para que sea la propia función quien trata los errores
# 	- Se añade la posibilidad de realizar un RollBack en caso de haber habido algún error
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}

function insertarProductosFichero($fichero) {
# Función 'insertarProductosFichero'. 
# Parámetros: 
# 	- $fichero (fichero [tipo de datos File] donde está la información de los productos a insertar de forma masiva)
#
# Funcionalidad:
# Inserta de forma masiva productos a la tabla 'producto'
#
# Retorna: STRING con el número de líneas ejecutadas, y el total de las líneas leidas
#
# Código por Edu Gutierrez
# Refactorizado por Daniel González Carretero

	global $conexion;

	$numeroLineasTotales = 0;
	$numeroLineasEjecutadas = 0;
    foreach ($fichero as $lineas => $string) {
        $producto = explode('#', trim($string));
        //insertarProducto("S10_1678", "1969 Harley Davidson Ultimate Chopper", "48.81", "Motorcycles");

        $id_prod = $producto[0];
        $nombre = $producto[1];
        $precio = $producto[2];
        $id_cat = $producto[3];

        $numeroLineasTotales++;

        if ( $id_prod == NULL || !insertarProducto($id_prod, $nombre, $precio, $id_cat)) {
        	echo "<p>Ha habido un error al insertar el producto <strong>'". $nombre ."</strong>. El producto NO se ha dado de alta, pero la ejecución del archivo ha continuado. Por favor, de de alta este producto manualmente <strong><a href='comaltapro.php'>aquí</a></strong>, o edite el fichero.</p>";
        } else {
        	$numeroLineasEjecutadas++;
        }
    }

    return "Líneas ejecutadas: ". $numeroLineasEjecutadas ." / ". $numeroLineasTotales;

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se tratan manualmente los errores (comprobando los valores de retorno de las funciones usadas)
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function consultarStock($id_producto){
# Función 'consultarStock'. 
# Parámetros: 
# 	- $id_producto (ID del Producto del que se quiere consultar el Stock Disponible)
#
# Funcionalidad:
# Inserta de forma masiva productos a la tabla 'producto'
#
# Retorna: La información de los almacenes que tienen ese producto en Stock / NULL si ocurre algún error, o no hay existencias
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	try {
		// Consulta anterior:
		// SELECT almacena.*, producto.NOMBRE FROM almacena, producto where almacena.id_producto = producto.id_producto and almacena.id_producto = :idProducto
		$obtenerStock = $conexion->prepare("SELECT almacen.localidad AS 'localidadAlmacen', almacena.cantidad AS 'cantidadProducto', almacena.num_almacen AS 'numeroAlmacen' FROM almacena LEFT JOIN almacen ON almacen.num_almacen = almacena.num_almacen WHERE almacena.cantidad > 0 AND almacena.id_producto = :idProducto"); // cantidad > 0 para sólo mostrar almacenes con ese producto
		$obtenerStock->bindParam(":idProducto", $id_producto);
		$obtenerStock->execute();
		return $obtenerStock->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos del Stock del Producto: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se modifica la consulta, para devolver únicamente los valores usados, y los almacenes que tengan mínimo 1 unidad (para evitar posibles futuros problemas)
#	- Se añade un TRY-CATCH para que sea la propia función quien trata los errores
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function verStock($stock){
# Función 'consultarStock'. 
# Parámetros: 
# 	- $stock (Información del stock que se quiere mostrar por pantalla)
#
# Funcionalidad:
# Inserta de forma masiva productos a la tabla 'producto'
#
# Retorna: (nada, los datos tratados se muestran por pantalla)
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	echo 	"<table border='1'>
				<tr>
					<th>Almacén</th>
					<th>Cantidad</th>
				</tr>";

	foreach ($stock as $filas => $datos) {
		echo 	"<tr>
					<td>".  $datos["localidadAlmacen"] 	."</td>
					<td>".  $datos["cantidadProducto"] 	."</td>
			  	</tr>";
	}

	echo 	"</table>";

# Cambios de Refactorización Realizados:
# 	- Modificados los índices del array asociativo '$datos', para que se corresponda con los nuevos valores que debería tener el array '$stock'
#	- Se re-ordenan los echo's para que exista una jerarquía HTML y sea más facil de leer (puramente estético)
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function realizarCompraProducto($nifCliente, $id_producto, $cantidadCompra){
# Función 'realizarCompraProducto'. 
# Parámetros: 
# 	- $nifCliente (NIF del cliente que realiza la compra)
#	- $id_producto (ID del producto que se quiere comprar)
#	- $cantidadCompra (Número de unidades que se quiere comprar)
#
# Funcionalidad:
# Intenta realizar la compra de un producto concreto
#
# Retorna: TRUE / FALSE, según si se ha podido o no realizar la compra (por cualquier motivo. Se justifica con un echo)
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	$stock = consultarStock($id_producto);

	if ($stock == null) {

		echo "<p>Lo sentimos, parece que ningún almacén dispone de este producto</p></br>";

	} else {

		$cantidadTotalProductos = $conexion->prepare("SELECT SUM(cantidad) AS 'total' FROM almacena WHERE id_producto = :idProducto");
		$cantidadTotalProductos->bindParam(":idProducto", $id_producto);
		$cantidadTotalProductos->execute();

		$totalProducto = $cantidadTotalProductos->fetch(PDO::FETCH_ASSOC)["total"];

		$totalUnidadesComprar = $cantidadCompra; // Variable auxiliar, para no perder el valor de $cantidadCompra
		if ($totalProducto >= $cantidadCompra) {
			// Si hay suficientes productos, se realiza la compra

			try {
				$conexion->beginTransaction();

				foreach ($stock as $almacen => $informacion) {
					// Se consulta cada almacén que tenga ese producto en Stock
					if ($informacion["cantidadProducto"] >= $cantidadCompra) {
						$cantidadRetirar = $cantidadCompra; // Si un almacén tiene la cantidad de producto restante, se retira todo lo que quede por retirar del total comprado
					} else {
						$cantidadRetirar = $informacion["cantidadProducto"]; // Si la cantidad de producto de un almacén no es suficiente, se retiran todos los productos de ese almacén
					}

					# PENDIENTE DE CONFIRMAR POR EL CLIENTE / SISTEMAS [¿Si un almacén tiene 0 uds. de un producto, se debe borrar de la tabla 'almacena'?]
					# if ($cantidadRetirar == $informacion["cantidadProducto"]) {
					#	$borrarAlmacen = $conexion->prepare("DELETE FROM almacena WHERE num_almacen = :numAlmacen AND id_producto = :idProducto");
					#	$borrarAlmacen->bindParam(":numAlmacen", $informacion["numeroAlmacen"]);
					#	$borrarAlmacen->bindParam(":idProducto", $id_producto);
					#	$borrarAlmacen->execute();
					#} else {

					$actualizarCantidad = $conexion->prepare("UPDATE almacena SET cantidad = cantidad - :cantidadRetirar WHERE num_almacen = :numAlmacen AND id_producto = :idProducto");
					$actualizarCantidad->bindParam(":cantidadRetirar", $cantidadRetirar);
					$actualizarCantidad->bindParam(":numAlmacen", $informacion["numeroAlmacen"]);
					$actualizarCantidad->bindParam(":idProducto", $id_producto);
					$actualizarCantidad->execute();

					#}

					$cantidadCompra -= $cantidadRetirar;

					if ($cantidadCompra <= 0) { // Si ya no hay que retirar ningún producto más, se sale del bucle FOREACH
						break;
					}
				}

			} catch (PDOException $ex) {
				echo "<p>Ha ocurrido un error al actualizar el Stock de uno de los almacenes: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span>. La compra no se ha realizado.</p></br>";
				$conexion->rollBack();
				return false;
			}

			try {
				$agregarCompra = $conexion->prepare("INSERT INTO compra VALUES (:nifCliente, :idProducto, CURRENT_TIMESTAMP, :cantidadComprada)");
				$agregarCompra->bindParam(":nifCliente", $nifCliente);
				$agregarCompra->bindParam(":idProducto", $id_producto);
				$agregarCompra->bindParam(":cantidadComprada", $totalUnidadesComprar);
				$agregarCompra->execute();

				$conexion->commit();
				return true;

			} catch (PDOException $ex) {
				echo "<p>Ha ocurrido un error al intentar confirmar la Compra: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span>. La compra, finalmente, no se ha realizado.</p></br>";
				$conexion->rollBack();
				return false;
			}

		} else {
			// Si no hay suficientes productos, no se realiza la compra
			echo "<p>Lo sentimos, parece que no tenemos tantas unidades disponibles de este producto.</p></br>";
		}
	
	}
		
# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se añade el 'justificante' de la compra a la tabla 'compra' (INSERT en la tabla 'compra').
#	- Se añade el parámetro 'nifCliente', para poder ejecutar el INSERT en la tabla 'compra'
#	- Se añade la posibilidad de hacer un Roll Back si ocurre algún error a mitad del proceso
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)	
}



function obtenerAlmacenes() {
# Función 'obtenerAlmacenes'. 
# Parámetros: 
# 	- (ninguno)
#
# Funcionalidad:
# Obtiene todos los datos de la tabla 'almacen'
#
# Retorna: Información sobre la tabla / NULL si hay algún error
#
# Código por Edu Gutierrez y Marco Santiago (ambos hicieron su versión de la misma función)
# Refactorizado por Daniel González Carretero

	global $conexion;

	// Sentencia anterior:
	// SELECT * FROM $tabla
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM almacen");
		$obtenerInfo->execute();
		return $obtenerInfo->fetchAll(PDO::FETCH_ASSOC); # Si falla, devuelve NULL por defecto

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos de los Almacenes: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
	

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#   - Modificada la sentencia de INSERT, y la forma de gestionar el 'acceso' a la base de datos, para mayor claridad (no hay cambios relevantes, únicamente estéticos)
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function obtenerClientes() {
# Función 'obtenerClientes'. 
# Parámetros: 
# 	- (ninguno)
#
# Funcionalidad:
# Obtiene todos los datos de la tabla 'cliente'
#
# Retorna: Información sobre la tabla / NULL si hay algún error
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	// Sentencia anterior:
	// SELECT * FROM $tabla
	try {
		$obtenerInfo = $conexion->prepare("SELECT * FROM cliente");
		$obtenerInfo->execute();
		return $obtenerInfo->fetchAll(PDO::FETCH_ASSOC); # Si falla, devuelve NULL por defecto

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos de los Clientes: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
	
# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function obtenerProductosAlmacenes($num_almacen){
# Función 'obtenerProductosAlmacenes'. 
# Parámetros: 
# 	- $num_almacen (número del almacen del cual se quieren obtener los productos)
#
# Funcionalidad:
# Obtiene todos los datos de los productos que posee un almacén
#
# Retorna: (nada, los valores de retorno se muestran por pantalla)
#
# Código por Edu Gutierrez
# Refactorizado por Daniel González Carretero

	global $conexion;

	try {
		$obtenerProductos = $conexion->prepare("SELECT producto.nombre AS 'nombreProducto', producto.id_producto AS 'idProducto', producto.precio AS 'precioProducto', almacena.cantidad AS 'cantidadProducto' FROM almacena LEFT JOIN producto ON almacena.id_producto = producto.id_producto WHERE num_almacen = :numAlmacen");
		$obtenerProductos->bindParam(":numAlmacen", $num_almacen);
		$obtenerProductos->execute();

		$productos = $obtenerProductos->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los productos existentes en este almacén: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		$productos = null;
	}
	
	if ($productos == null) {
		echo "<p>Lo sentimos, pero parece que este almacén no tiene ningún producto.</p></br>";
	} else {
		echo "<table border='1'><tr><th>ID Producto</th><th>Nombre</th><th>Precio</th><th>Cantidad Disponible</th></tr>";
		foreach($productos as $producto) {
			echo "<tr>
					<td>". $producto["idProducto"] . "</td>
					<td>". $producto["nombreProducto"] ."</td>
					<td>". $producto["precioProducto"] ."</td>
					<td>". $producto["cantidadProducto"] ."</td>
				 </tr>";
		}
		echo "</table>";
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se transforma la información en texto plano a HTML (en formato tabla)
#	- Se modifica la consulta, para que devuelva únicamente los valores usados
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function consultarCompras($nif, $fecha_desde, $fecha_hasta){
# Función 'consultarCompras'. 
# Parámetros: 
# 	- $nif (NIF del cliente del cual se quiere comprobar su historial de compras)
#	- $fecha_desde (fecha de inicio, desde la cual se empieza a buscar en el historial)
#	- $fecha_hasta (fecha de fin, desde la cual se termina de buscar en el historial)
#
# Funcionalidad:
# Obtiene las compras relizadas por un cliente en un periodo de tiempo
#
# Retorna: Compras realizadas / NULL, si hay algún error o no hay compras
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	global $conexion;

	// Corrección de fechas para adecuarse al tipo de dato DATETIME, en vez de DATE en la base de datos
	$fecha_desde = $fecha_desde . " 00:00:00";
	$fecha_hasta = $fecha_hasta . " 23:59:59";

	try {
		$obtenerCompras = $conexion->prepare("SELECT compra.id_producto, producto.nombre, compra.unidades, (producto.precio * compra.unidades) as precioCompra FROM compra LEFT JOIN producto ON compra.id_producto = producto.id_producto WHERE compra.ID_PRODUCTO = producto.ID_PRODUCTO and (FECHA_COMPRA >= :fechaDesde and FECHA_COMPRA <= :fechaHasta) and NIF = :nifCliente");
		$obtenerCompras->bindParam(":fechaDesde", $fecha_desde);
		$obtenerCompras->bindParam(":fechaHasta", $fecha_hasta);
		$obtenerCompras->bindParam(":nifCliente", $nif);
		$obtenerCompras->execute();

		return $obtenerCompras->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver las compras que ha realizado este cliente: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se modifica la consulta, de forma únicamente estética
# 	- Se ajustan las fechas (fecha_desde, fecha_hasta) para ajustarse al tipo de dato 'DATETIME' de la base de datos, y por tanto evitar errores
#	- Se añade un TRY-CATCH para que sea la propia función quien trata los errores
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function verCompras($compras){
# Función 'verCompras'. 
# Parámetros: 
# 	- $compras (array asociativo con todas las compras realizadas por un cliente)
#
# Funcionalidad:
# Obtiene todos los datos de la tabla 'cliente'
#
# Retorna: (nada, los valores de retorno se muestran por la pantalla)
#
# Código por Raquel Alcázar
# Refactorizado por Daniel González Carretero

	$sumaTotal = 0;

	if($compras != null){
		echo "<table border='1'><tr><th>ID Producto</th><th>Nombre</th><th>Unidades</th><th>Precio de compra</th></tr>";

		foreach ($compras as $compra => $datos) {
			echo "<tr>
					<td>". $datos["id_producto"] ."</td>
					<td>". $datos["nombre"] ."</td>
					<td>". $datos["unidades"] ."</td>
					<td>". $datos["precioCompra"] ."</td>
				 </tr>";

			$sumaTotal += $datos["precioCompra"];
		}

		echo "<tr>
				<th colspan=3>Precio Total</th>
				<td>" .$sumaTotal ." €</td>
			 </tr></table>";
	} else {
		echo "<p>Lo sentimos, pero parece que este cliente no ha hecho ninguna compra.</p>";
	}

# Cambios de Refactorización Realizados:
# 	- Ordenada la función para mayor legibilidad al remarcar la jerarquía HTML
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}


function agregarProductosAlmacen($numAlmacen, $idProducto, $cantidad){
# Función 'agregarProductosAlmacen'. 
# Parámetros: 
# 	- $numAlmacen (número del almacén al que se quieren agregar existencias)
#	- $idProducto (ID del producto del cual se quieren agregar existencias)
#	- $cantidad (número de existencias a agregar)
#
# Funcionalidad:
# Añade cierta cantidad de un producto concreto al stock de un almacén
#
# Retorna: TRUE / FALSE, dependiendo de si ha ocurrido o no algún error
#
# Código por Marco Santiago
# Refactorizado por Daniel González Carretero

	global $conexion;

    try {

        

        $conexion->beginTransaction();

        $comprobarExistencia = $conexion->prepare("SELECT * FROM almacena WHERE num_almacen = :numAlmacen AND id_producto = :idProducto");
        $comprobarExistencia->bindParam(":numAlmacen", $numAlmacen);
        $comprobarExistencia->bindParam(":idProducto", $idProducto);
        $comprobarExistencia->execute();

        $hayProductoAlmacen = $comprobarExistencia->fetch(PDO::FETCH_ASSOC) != null;

        if ($hayProductoAlmacen) {
        	// Si en la tabla 'almacena' ya está registrado ese producto en ese almacén, se Actualiza
        	# PENDIENTE DE CONFIRMAR POR EL CLIENTE / SISTEMAS [¿Si un almacén ya está registrado, se establecen las uds (cantidad = :cantidad), o se añaden (cantidad += :cantidad)?]
        	$insertarProducto = $conexion->prepare("UPDATE almacena SET cantidad = cantidad + :cantidad WHERE num_almacen = :numAlmacen AND id_producto = :idProducto");
            $insertarProducto->bindParam(':numAlmacen', $numAlmacen);
            $insertarProducto->bindParam(':idProducto', $idProducto);
            $insertarProducto->bindParam(':cantidad', $cantidad);
            $insertarProducto->execute();

        } else {
        	// Si aún no se ha registrado ese producto en ese almacén, se Inserta
        	$insertarProducto = $conexion->prepare("INSERT INTO almacena (NUM_ALMACEN, ID_PRODUCTO, CANTIDAD) VALUES (:numAlmacen, :idProducto, :cantidad)");
            $insertarProducto->bindParam(':numAlmacen', $numAlmacen);
            $insertarProducto->bindParam(':idProducto', $idProducto);
            $insertarProducto->bindParam(':cantidad', $cantidad);
            $insertarProducto->execute();
        }

        $conexion->commit();
        return true;
       
    } catch(PDOException $ex) {
        echo "<p>Ha ocurrido un error al intentar actualizar la información sobre los productos de un almacén: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
        $conexion->rollBack();
        return false;
    }

# Cambios de Refactorización Realizados:
# 	- Sustituido el parámetro $conn (conexión), por la globalización de la variable
#	- Se añade la posibilidad de hacer un Roll Back en caso de que algo falle, o Commit si todo funciona como se esperaba
#	- Se añade la sentencia del UPDATE, en caso de que el registro del almacén y el producto indicado ya existiese
#	- Se obliga a pasar los datos por parámetros, en vez de acceder a ellos mediante la variable $_REQUEST
#	- Modificada la documentación de la función, para una coherencia de estilo (no hay cambios, es la misma información de la versión previa)
}



function obtenerClienteNIF($nif) {
# Función 'obtenerClienteNIF'. 
# Parámetros: 
# 	- $nif (NIF del cliente del que se quiere obtener los datos)
#
# Funcionalidad:
# Obtiene toda la información de un cliente, buscándolo por NIF
#
# Retorna: Los datos del Cliente / NULL si no existe el cliente o ha ocurrido un error
#
# Código por Daniel González Carretero
# Refactorizado por Daniel González Carretero

	global $conexion;

	try {
		$consulta = $conexion->prepare("SELECT * FROM cliente WHERE nif = :nif");
		$consulta->bindParam(":nif", $nif);
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos del cliente que se busca por este NIF: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}

# Cambios de Refactorización Realizados:
# 	- Se usa la variable global $conexion
#	- Se añade el TRY-CATCH, para que sea la propia función quien trata los errores
#	- Añadida la documentación de la función, para una coherencia de estilo
} 



function insertarCliente($nif, $nombre, $apellido, $codigoPostal, $direccion, $ciudad) {
# Función 'obtenerClienteNIF'. 
# Parámetros: 
# 	- $nif (NIF del cliente que se quiere insertar)
#	- $nombre (Nombre del cliente)
#	- $apellido (Apellido/s del cliente)
#	- $codigoPostal (Código Postal del cliente)
#	- $direccion (Dirección del cliente)
#	- $ciudad (Ciudadl donde vive el cliente / ciudad donde se encuentra la dirección)
#
# Funcionalidad:
# Inserta un nuevo cliente en la tabla 'cliente'
#
# Retorna: TRUE / FALSE, según si se ha ejecutado o no correctamente
#
# Código por Daniel González Carretero
# Refactorizado por Daniel González Carretero

	global $conexion;

	$usuario = preg_replace('/\s+/', '', strtolower($nombre)); // El usuario es el nombre, en minúsculas. Si hay espacios se eliminan
	$password = strrev(preg_replace('/\s+/', '', strtolower($apellido))); // La contraseña es el apellido en minúsculas, sin espacios y en orden inverso. No se eliminan las tildes, aunque se debería.

	try {
		$conexion->beginTransaction();

		$insertCliente = $conexion->prepare("INSERT INTO cliente (nif, nombre, apellido, cp, direccion, ciudad, usuario, password) VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad, :usuario, :password)");
		$insertCliente->bindParam(":nif", $nif);
		$insertCliente->bindParam(":nombre", $nombre);
		$insertCliente->bindParam(":apellido", $apellido);
		$insertCliente->bindParam(":cp", $codigoPostal);
		$insertCliente->bindParam(":direccion", $direccion);
		$insertCliente->bindParam(":ciudad", $ciudad);
		$insertCliente->bindParam(":usuario", $usuario);
		$insertCliente->bindParam(":password", $password);
		$insertCliente->execute();

		$conexion->commit();
		return true;

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al intentar dar de Alta al Cliente: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		$conexion->rollBack();
		return false;
	}

# Cambios de Refactorización Realizados:
# 	- Se usa la variable global $conexión
#	- Se añade la posibilidad de hacer un Roll Back en caso de que algo falle, o Commit si todo funciona como se esperaba
#	- Se añade el TRY-CATCH, para que sea la propia función quien trata los errores
#	- Añadida la documentación de la función, para una coherencia de estilo

# Cambios (14 / 01 / 2021, Daniel González Carretero) -> Se añade la información a las nuevas columnas 'usuario' y 'password'
}

function comprobarCliente($usuario, $clave){
# Función 'comprobarCliente'. 
# Parámetros: 
# 	- $usuario (usuario del cliente)
#	- $clave (clave del cliente)
#
# Funcionalidad:
# Comprobar que existe un cliente con ese $usuario y $clave
#
# Retorna: Los datos (NIF, APELLIDO) del Cliente / NULL si no existe el cliente o ha ocurrido un error
#
# Código por Raquel Alcázar Mesia
	global $conexion;

	try {
		$consulta = $conexion->prepare("SELECT APELLIDO, NIF FROM cliente WHERE NOMBRE = :usuario");
		$consulta->bindParam(":usuario", $usuario);
		$consulta->execute();
		$datos = $consulta -> fetch(PDO::FETCH_ASSOC);

		if($datos["APELLIDO"]==null){
			echo "El usuario no existe.";
		}else{
			if($clave != strrev($datos["APELLIDO"])){
				echo "Clave introducida incorrecta.";
			}
		}
		
		return $datos;

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos del cliente que se busca por este NIF: <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
}

?>
