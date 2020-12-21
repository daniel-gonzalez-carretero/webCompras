<!--Marco Santiago-->
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <div>Datos de Registro categorias</div>
        <form name='formulario' action='' method='post'>
            <label for="categoria">Categoria</label>
            <input type="text" name="categoria" /> <br />
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" /> <br />
            <?php
                include_once("php/conexion.php");
                include_once("php/funciones.php");
                if (!isset($_POST) || empty($_POST)) {
            ?>
            <?php
                }
                else {
                    $categoria=$_POST["categoria"];
                    $descripcion=$_POST["descripcion"];
                    altacat($conexion,$categoria,$descripcion);
                }
            ?>
            <input type="submit" name="enviar" id="enviar" value="Enviar">
        </form>
    </body>
</html>
