<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta de un producto</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <h1 class="text-center">ALTA PRODUCTOS</h1>

    <?php
 
 include_once("funciones.php");
 include_once("conexion.php");

try {
    if (!isset($_POST) || empty($_POST)) { ?>
	<h1>Alta de productos</h1>
    <div class="container ">
        <div class="card border-success mb-3" style="max-width: 30rem;">
            <div class="card-header">Dar alta productos</div>
            <div class="card-body">
                <form id="product-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="card-body">
                    <div class="form-group">
                        PRODUCTOS <input type="file" name="fichero" placeholder="Sube un fichero con los producots" class="form-control">
                    </div>
                    <input type="submit" name="submit" value="Subir productos" class="btn btn-warning disabled">
                </form>
            </div>
        </div>
    </div>
    <br>
    </div>
	
<?php
    } elseif (isset($_FILES['fichero']) && $_FILES['fichero']['error'] === UPLOAD_ERR_OK) {
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
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() ."</p>";
}
            
?>
</body>
</html>
