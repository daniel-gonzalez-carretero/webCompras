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
            <?php
                include_once("php/conexion.php");
                include_once("php/funciones.php");
                if (!isset($_POST) || empty($_POST)) {
            ?>
            <?php
                }
                else {
                    $categoria=$_POST["categoria"];
                    $codigo=gen_cod_cat($conexion);
                    altacat($conexion,$categoria,$codigo);
                }
            ?>
            <input type="submit" name="enviar" id="enviar" value="Enviar">
        </form>
    </body>
</html>