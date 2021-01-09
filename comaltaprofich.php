<!--
    Código por:         Edu Gutierrez  
    Refactorizado por:  Daniel González Carretero
-->
<html>
<head>
    <title>Dar de Alta varios Productos con un Fichero</title>
    <meta name="author" content="Edu Gutierrez" />
    <meta charset="utf-8" />
</head>
<body>
    <h1>Alta de productos mediante un Fichero</h1>
    <p><a href="index.html">Volver al Menú</a></p><br><br>

    <form method='post' action='<?php echo htmlentities($_SERVER["PHP_SELF"]);?>'>
        <label for="nombre">Indica la Ruta hasta el archivo:</label>
        <input type='text' name='fichero' required><br />

        <input type='submit' value='Añadir productos'>
    </form>

    <?php

    include_once("funciones.php");
    if (isset($_POST) && !empty($_POST)) {
        $fichero = file($_POST["fichero"]);

        $totalLineas = insertarProductosFichero($fichero);
        echo "<p>Se han finalizado la ejecucion del programa. ". $totalLineas ."</p>";
       
    }

    ?>
 
    <!-- Código Anterior [PENDIENTE CONFIRMACIÓN CLIENTE, ¿El Input Type debe ser 'file', o 'text'?]

        if (isset($_FILES['fichero']) && $_FILES['fichero']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['fichero']['tmp_name'];
            $fileName = $_FILES['fichero']['name'];
            if (!file_exists('./subidas/')) {
                 mkdir('./subidas/', 0700);
            }
            $uploadFileDir = './subidas/';
            $dest_path = $uploadFileDir . $fileName;
     
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $message ='Archivo se ha subido correctamente.';
            } else {
                $message = 'Ha ocurrido un error al mover el fichero.';
            }
            $fichero=file("./subidas/$fileName");
            prodFichSubida($conexion,$fichero);
            echo $message;
        }

    -->
 
</body>
<!-- Cambios de Refactorización Realizados -->
<!-- 
    # Se elimina la hoja de estilos de BootStrap, para un estilo coherente entre archivos
    # Se sustituye la subida de un archivo (type='file'), por la referencia al archivo (type='text'). Se comenta el código anterior, a esperas de la confirmación del cliente
    # Actualizado el nombre de la función (prodFichSubida -> insertarProductosFichero), y sus parámetros
    # Añadido mensaje informativo
-->
</html>