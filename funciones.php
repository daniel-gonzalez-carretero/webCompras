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

/* 	- Función: "obtenerCodProd". 
	- Parámetros: $conn.
	- Funcionalidad: Determinar un código automático en función del código del último departamento registrado.
	- Valor de retorno: $codigo.*/
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
	- Valor de retorno: Ninguno.*/
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
            $stmt = $conn->prepare("insert into categoria (ID_CATEGORIA,NOMBRE)values('$codigo','$categoria')");
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();

            echo("Insert succesfully");
        }
        catch(PDOException $e) {
            $test= "Error insertar categoria: -->".$e->getMessage()."</br>";
        }
    }
    function gen_cod_cat($conn){
/* 	- Función: "gen_cod_cat". 
	- Parámetros: $conn.
	- Funcionalidad: Generar el codigo de la categoria.
	- Valor de retorno: Codigo.
	- Dev:Marco Santiago*/
        try{
            $cod=null;
            $cod = $conn->query("SELECT MAX(ID_CATEGORIA) as cod from categoria")->fetchAll(PDO::FETCH_ASSOC);
            if ($cod==null)
                $cod=0;
            else{
                $cod=$cod[0]["cod"];
                $cod=substr($cod,-(count($cod-1)));
            }
            $cod="C".($cod+1);

            echo "Gen cod succesfully<br>";
    
            return $cod;
        }
        catch(Exception $e) {
            $test= "Error generar codigo -->".$e->getMessage()."</br>";
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
            $id_prod=$producto[0];
            $nombre=$producto[1];
            $precio=$producto[2];
            $id_cat=$producto[3];
            insertarProducto($conexion, $id_prod, $nombre, $precio, $id_cat);
        }
    }

?>
