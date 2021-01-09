<!---->
<!--
    Código por:         Marco Santiago 
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Añadir Productos a un Almacén</title>
    <meta charset="utf-8" />
    <meta name="author" value="Marco Santiago" />
</head>
<body>
    <h1>Añadir Productos a un Almacén</h1>
    <p><a href="index.html">Volver al Menú</a></p><br><br>

    <?php 
        include_once("funciones.php");
        $almacenes = obtenerAlmacenes();
        $productos = obtenerProductos();
    ?>
	<form action='<?php echo htmlentities($_SERVER["PHP_SELF"]);?>' method='post'>
        <label for="almacen">Almacen</label>
        <select name="almacen" required>
            <option disabled selected>Selecciona un Almacén</option>
            <?php
                foreach($almacenes as $almacen) {
                    echo "<option value='". $almacen["NUM_ALMACEN"] ."'>[". $almacen["NUM_ALMACEN"] ."]: ". $almacen["LOCALIDAD"] ."</option>";
                }
            ?>
        </select><br />

        <label for="producto">Producto</label>
        <select name="producto" required>
            <option disabled selected>Selecciona un Producto</option>
            <?php
                foreach($productos as $producto) {
                    echo "<option value='". $producto["ID_PRODUCTO"] ."'>[". $producto["ID_PRODUCTO"] ."]: ". $producto["NOMBRE"] ."</option>";
                }
            ?>
        </select><br />

        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" required /> <br />

        <input type="submit" name="enviar" id="enviar" value="Enviar">
    </form>  
    

    <?php
        if (isset($_POST) && !empty($_POST)) {

            $almacen = $_POST["almacen"];
            $producto = $_POST["producto"];
            $cantidad = $_POST["cantidad"];

            if ( agregarProductosAlmacen($almacen, $producto, $cantidad) ) {
                echo "<p>Se ha añadido un total de ". $cantidad ." unidad(es) del producto al almacén.</p>";
            } // Si la función devuelve FALSE, es la propia función quien muestra el mensaje de error
        }
    ?>
  
</body>
<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Actualizado el nombre de la función (update_producto -> agregarProductosAlmacen), y sus parámetros
    # Se traspasan ( y editan ) las líneas 52, 53 y 54, de la función anterior 'update_producto'
    # Invertida la condición del IF, para evitar el ELSE innecesario
    # Añadido mensaje informativo, si todo funciona como se esperaba
    # Se añade información a la etiqueta <head>
    # Se sustituye el código PHP dentro de la etiqueta <form> por las llamas a las funciones 'obtenerAlmacenes()' y 'obtenerProductos()', fuera del formulario
    # Se sustituyen los FOR para crear las etiquetas <option>, por FOREACH para mejorar la eficiencia del código
-->
</html>