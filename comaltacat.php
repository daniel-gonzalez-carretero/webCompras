<!--
    Código por:         Marco Santiago  
    Refactorizado por:  Daniel González Carretero
-->
<!DOCTYPE html>
<html>
<head>
    <title>Dar de Alta una Categoría</title>
    <meta charset="utf-8" />
    <meta name="author" value="Marco Santiago" />
</head>
<body>
    <h1>Datos de Registro categorias</h1>
    <p><a href="index.html">Volver al Menú</a></p><br><br>
    
    <form name='formulario' action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' method='post'>
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" required /> <br />

        <label for="descripcion">Descripción: </label>
        <input type="text" name="descripcion" required /> <br />
        <?php
            include_once("funciones.php");
            if (isset($_POST) && !empty($_POST)) {
                $nombre = $_POST["nombre"];
                $descripcion = $_POST["descripcion"];
                if ( altaCategoria($nombre, $descripcion) ) {
                    echo "<p>Se ha dado de alta correctamente la categoría '". $nombre . "'.</p>";
                } // Si la función devuelve FALSE, el mensaje de error lo devuelve la propia función
            }
        ?>
        <input type="submit" name="enviar" id="enviar" value="Enviar">
    </form>
</body>

<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Actualizado el nombre de la función (altacat -> altaCategoria), y sus parámetros
    # Actualizados los nombres de los campos, para una mayor coherencia con los nuevos datos de la base de datos
    # Invertida la condición del IF, para evitar el ELSE innecesario
    # Añadido mensaje informativo, si todo funciona como se esperaba
    # Añadida, aunque no necesaria, dirección del propio archivo en el 'action' del formulario, con escapado de caracteres para evitar ataques XSS
-->
</html>