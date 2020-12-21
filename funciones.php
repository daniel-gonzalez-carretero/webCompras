<?php
/* 	- Función: "obtenerCodProd". 
	- Parámetros: $conn.
	- Funcionalidad: Determinar un código automático en función del código del último producto registrado.
	- Valor de retorno: $codigo.
	- Dev: Raquel Alcázar*/
function obtenerCodProd($conn){
	$sql="SELECT max(substr(ID_PRODUCTO, 2)) as maximo FROM producto";

	$stmt=$conn->prepare($sql);
	$stmt->execute();

	$maximo = $stmt->fetch(PDO::FETCH_ASSOC);

	$maximo=(int)$maximo["maximo"];
	$codigo=$maximo+1;

	$codigo="P" .str_pad($codigo, 3, 0, STR_PAD_LEFT);

	return $codigo;
}

/* 	- Función: "insertarProducto". 
	- Parámetros: $conn, $dni, $nombre, $apellidos, $fecha_nac, $salario.
	- Funcionalidad: Insertar un nuevo producto en la tabla "producto".
	- Valor de retorno: Ninguno.
	- Dev: Raquel Alcázar*/
function insertarProducto($conn, $id_prod, $nombre, $precio, $id_cat){
	$conn->beginTransaction();

	$stmt=$conn->prepare("INSERT INTO producto (ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES (:id_prod, :nombre, :precio, :id_cat)");

    $stmt->bindParam(':id_prod', $id_prod);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':id_cat', $id_cat);

	$stmt->execute();

	if(!$conn->commit()){
		echo "Error: No se ha podido dar de alta el producto.";
	}else{
		  echo "<p>Producto dado de alta correctamente.</p>";
	}
}

/* 	- Función: "obtenerCodProd". 
	- Parámetros: $conn.
	- Funcionalidad: Determinar un código automático en función del código del último almacén registrado.
	- Valor de retorno: $codigo.
	- Dev: Raquel Alcázar*/
function obtenerCodAlmacen($conn){
	$sql="SELECT max(NUM_ALMACEN) as maximo FROM almacen";

	$stmt=$conn->prepare($sql);
	$stmt->execute();

	$maximo = $stmt->fetch(PDO::FETCH_ASSOC);

	$maximo=(int)$maximo["maximo"];
	$codigo=$maximo+10;

	return $codigo;
}

/* 	- Función: "insertarAlmacen". 
	- Parámetros: $conn, $dni, $nombre, $apellidos, $fecha_nac, $salario.
	- Funcionalidad: Insertar un nuevo producto en la tabla "producto".
	- Valor de retorno: Ninguno.
	- Dev: Raquel Alcázar*/
function insertarAlmacen($conn, $num_almacen, $localidad){
	$conn->beginTransaction();

	$stmt=$conn->prepare("INSERT INTO almacen (NUM_ALMACEN, LOCALIDAD) VALUES (:num_almacen, :localidad)");

    $stmt->bindParam(':num_almacen', $num_almacen);
    $stmt->bindParam(':localidad', $localidad);

	$stmt->execute();

	if(!$conn->commit()){
		echo "Error: No se ha podido dar de alta el almac&#233;n.";
	}else{
		  echo "<p>Almac&#233;n dado de alta correctamente.</p>";
	}
}
    function altacat($conn,$categoria,$codigo){
/* 	- Función: "altacat". 
	- Parámetros: $conn,$categoria,$codigo.
	- Funcionalidad: Insertar una nueva categoria en la tabla "categoria".
	- Valor de retorno: Ninguno.
	- Dev:Marco Santiago*/
        try{
            $stmt = $conn->prepare("insert into categoria (ID_CATEGORIA,NOMBRE)values('$categoria','$codigo')");
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();

            echo("Insert succesfully");
        }
        catch(PDOException $e) {
            $test= "Error insertar categoria: -->".$e->getMessage()."</br>";
        }
    }

 /* 	- Función: "prodFichSubida". 
	- Parámetros: $conexion,$fichero.
	- Funcionalidad: Dar alta productos de manera masiva.
	- Valor de retorno: none
	- Dev:Edu Gutierrez*/

    function prodFichSubida($conexion,$fichero){

        foreach ($fichero as $index=>$lineas) {
            $producto= explode('#', $lineas);
            $id_prod=obtenerCodProd($conexion);
            $nombre=$producto[0];
            $precio=$producto[1];
            $id_cat=$producto[2];
            insertarProducto($conexion, $id_prod, $nombre, $precio, $id_cat);
        }
    }

/* 	- Función: "obtenerTodo". 
	- Parámetros: $conn.
	- Funcionalidad: Obtener todo de una tabla.
	- Valor de retorno: Array asociativo $seleccion.
	- Dev: Raquel Alcázar*/
function obtenerTodo($conn, $tabla){
	$sql="SELECT * FROM $tabla";

	$stmt=$conn->prepare($sql);

	$stmt->execute();
	$seleccion = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $seleccion;
}

/* 	- Función: "consultarStock". 
	- Parámetros: $conn.
	- Funcionalidad: Obtener el stock de un producto por cada almacén.
	- Valor de retorno: Array asociativo $stock.
	- Dev: Raquel Alcázar*/
function consultarStock($conn, $id_producto){
	$sql="SELECT *, NOMBRE FROM almacena, producto WHERE almacena.ID_PRODUCTO = producto.ID_PRODUCTO and almacena.ID_PRODUCTO='$id_producto'";

	$stmt=$conn->prepare($sql);
	$stmt->execute();

	$stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $stock;
}

/* 	- Función: "verStock". 
	- Parámetros: $conn.
	- Funcionalidad: Visualizar el stock de un producto por cada almacén.
	- Valor de retorno: Ninguno.
	- Dev: Raquel Alcázar*/
function verStock($stock){
	echo "<h1>Stock</h1>
					<table border='1'>
						<caption>" .$stock[0]["NOMBRE"] ." (" .$stock[0]["ID_PRODUCTO"] .")</caption>
						<tr>
							<th>Almacén</th>
							<th>Cantidad</th>
						</tr>";

			foreach ($stock as $st => $array) {
				echo "<tr>
						<td>" .$array["NUM_ALMACEN"] ."</td>
						<td>" .$array["CANTIDAD"] ."</td>
					</tr>";
			}

			echo "</table>";
}

/* 	- Función: "validarCompraProd". 
	- Parámetros: $conn, $id_producto, $cantidad, $stock.
	- Funcionalidad: Validar la compra de un producto en función del stock.
	- Valor de retorno: Ninguno.
	- Dev: Raquel Alcázar*/
function validarCompraProd($conn, $id_producto, $cantidad, $stock){

	if($stock==null){

		echo "El producto no está disponible.";

	}else{

		$sql="SELECT sum(cantidad) as total FROM ALMACENA WHERE ID_PRODUCTO='$id_producto'";

		$stmt=$conn->prepare($sql);
		$stmt->execute();

		$total = $stmt->fetch(PDO::FETCH_ASSOC);

		if($total["total"]>=$cantidad){

			$conn->beginTransaction();

			foreach ($stock as $st => $array) {
				
				if($array["CANTIDAD"] >= $cantidad){

					$retirar = $cantidad;

				}else{

					$retirar = $array["CANTIDAD"];
				}

				$num_almacen = $array["NUM_ALMACEN"];

				if($array["CANTIDAD"]>$cantidad){
					$stmt=$conn->prepare("UPDATE almacena SET CANTIDAD = CANTIDAD - '$retirar' WHERE NUM_ALMACEN = '$num_almacen' and ID_PRODUCTO = '$id_producto'");
				}else{
					$stmt=$conn->prepare("DELETE FROM almacena WHERE NUM_ALMACEN = '$num_almacen' and ID_PRODUCTO = '$id_producto'");
				}

				$stmt->execute();

				$cantidad-=$retirar;

				if($cantidad==0){
					break;
				}

			}

			
			if(!$conn->commit()){
				echo "<p>Error: No se ha podido realizar la compra.</p>";
			}else{
				echo "<p>Gracias por su compra.</p>";
			}

		}else{
			echo "<p>No hay suficiente stock.</p>";
		}
	
	}
				
}
/* 	- Función: "obtenerAlmacenes". 
	- Parámetros: $conexion.
	- Funcionalidad: Obtener todos los almacenes.
	- Valor de retorno: Array asociativo $almacenes.
	- Dev:Edu Gutierrez
	*/

function obtenerAlmacenes($conexion){

		$sql="SELECT * FROM almacen";
		$stmt=$conexion->prepare($sql);
		$stmt->execute();
		$almacenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $almacenes;

	}
	/* 	
	- Función: "obtenerProdAlmacenes". 
	- Parámetros: $conexion, $num_almacen.
	- Funcionalidad: Obtener los datos de productos de un almacén.
	- Valor de retorno: none.
	- Dev:Edu Gutierrez
	*/

function obtenerProdAlmacenes($conexion, $num_almacen){

	$sql="SELECT * FROM almacena LEFT JOIN producto on almacena.ID_PRODUCTO=producto.ID_PRODUCTO WHERE NUM_ALMACEN='$num_almacen'";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$id_productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach($id_productos as $producto){
			echo "ID:<strong> ".$producto['ID_PRODUCTO']."</strong> NOMBRE:<strong>  ".$producto['NOMBRE']."</strong> PRECIO:<strong>  ".$producto['PRECIO']."</strong> <br>";
		}
	}

/* 	- Función: "consultarCompras". 
	- Parámetros: $conn, $nif, $fecha_desde, $fecha_hasta.
	- Funcionalidad: Obtener las compras realizadas por un cliente en un periodo de tiempo.
	- Valor de retorno: Array asociativo $comprasCliente.*/
function consultarCompras($conn, $nif, $fecha_desde, $fecha_hasta){
	$sql="SELECT compra.ID_PRODUCTO, producto.NOMBRE, compra.UNIDADES, (producto.PRECIO * compra.UNIDADES) as precioCompra FROM compra, producto WHERE compra.ID_PRODUCTO = producto.ID_PRODUCTO and (FECHA_COMPRA >= '$fecha_desde' and FECHA_COMPRA <= '$fecha_hasta') and NIF = '$nif'";

	$stmt=$conn->prepare($sql);
	$stmt->execute();

	$comprasCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $comprasCliente;
}

/* 	- Función: "verCompras". 
	- Parámetros: $conn.
	- Funcionalidad: Visualizar las compras.
	- Valor de retorno: Ninguno.
	- Dev: Raquel Alcázar*/
function verCompras($compras){

	$sum = 0;

	if($compras!=null){
		echo "<h1>Compras realizadas</h1>
						<table border='1'>
							<tr>
								<th>Producto</th>
								<th>Nombre producto</th>
								<th>Unidades</th>
								<th>Precio de compra</th>
							</tr>";

				foreach ($compras as $compra => $datos) {
					echo "<tr>
							<td>" .$datos["ID_PRODUCTO"] ."</td>
							<td>" .$datos["NOMBRE"] ."</td>
							<td>" .$datos["UNIDADES"] ."</td>
							<td>" .$datos["precioCompra"] ."</td>
						</tr>";

						$sum += $datos["precioCompra"];
				}

				echo "<tr>
						<th colspan=3>Total</th>
						<td>" .$sum ."</td>
					</tr>";

				echo "</table>";
	}else{
		echo "<p>No hay registros de compras.</p>";
	}
}

    function get_almacenes($conn){
	    /* 	- Función: "get_almacenes". 
	- Parámetros: $conn.
	- Funcionalidad: obtener almacenes.
	- Valor de retorno: array de almacenes.
	- Dev: Marco Santiago*/
        try{
            $almacenes = $conn->query("SELECT * from almacen")->fetchAll(PDO::FETCH_ASSOC);
            echo "Gen almacenes succesfully<br>";
            
            return $almacenes;
        }
        catch(Exception $e) {
            echo("Error obtener almacenes -->".$e->getMessage()."</br>");
        }
    }
    function get_producto($conn){
/* 	- Función: "get_producto". 
	- Parámetros: $conn.
	- Funcionalidad: obtener productos.
	- Valor de retorno: Array productos.
	- Dev: Marco Santiago*/
        try{
            $almacenes = $conn->query("SELECT * from producto")->fetchAll(PDO::FETCH_ASSOC);
            echo "Gen almacenes succesfully<br>";
            
            return $almacenes;
        }
        catch(Exception $e) {
            echo("Error obtener productos -->".$e->getMessage()."</br>");
        }
    }
    function update_producto($conn){
/* 	- Función: "update_producto". 
	- Parámetros: $conn.
	- Funcionalidad: actualizar productos.
	- Valor de retorno: nada.
	- Dev: Marco Santiago*/
        try{
            $almacen=$_POST["almacen"];
            $producto=$_POST["producto"];
            $cantidad=$_POST["cantidad"];
            $almacen=explode("-",$almacen);
            $almacen=$almacen[0];
            $stmt = $conn->prepare("insert into almacena (NUM_ALMACEN,ID_PRODUCTO,CANTIDAD)values('$almacen','$producto','$cantidad')");
                $stmt->bindParam(':almacen', $almacen);
                $stmt->bindParam(':producto', $producto);
                $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();

            echo("Insert succesfully");
        }
        catch(PDOException $e) {
            echo("Error update producto: -->".$e->getMessage()."</br>");
        }
    }
?>

?>
