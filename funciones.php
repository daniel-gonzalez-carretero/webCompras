<?php
/* 	- Función: "obtenerCodProd". 
	- Parámetros: $conn.
	- Funcionalidad: Determinar un código automático en función del código del último departamento registrado.
	- Valor de retorno: $codigo.*/
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

/* 	- Función: "obtenerCategorias". 
	- Parámetros: $conn.
	- Funcionalidad: Obtener todas las categorías.
	- Valor de retorno: Array asociativo $categorias.*/
function obtenerCategorias($conn){
	$sql="SELECT * FROM categoria";

	$stmt=$conn->prepare($sql);

	$stmt->execute();
	$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $categorias;
}

/* 	- Función: "insertarProducto". 
	- Parámetros: $conn, $dni, $nombre, $apellidos, $fecha_nac, $salario.
	- Funcionalidad: Insertar un nuevo producto en la tabla "producto".
	- Valor de retorno: Ninguno.*/
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

?>
