<!--Marco Santiago-->
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <div>Cambio producto-almacen</div>

		<form name='formulario' action='comaprpro.php' method='post'>
            <label for="almacen">Almacen</label>
            <select name="almacen">
                <?php
                    include_once("conexion.php");
                    include_once("funciones.php");

                    try {
                        $almacenes=get_almacenes($conexion);
                        for ($a=0; $a < count($almacenes); $a++) { 
                            echo("<option>".$almacenes[$a]["NUM_ALMACEN"]."-".$almacenes[$a]["LOCALIDAD"]."</option>");
                        }
                    }
                    catch(PDOException $e) {
                        echo ("Error recuperar departamentos: -->".$e->getMessage()."</br>");
                    }
                ?>
            </select>
            <label for="producto">Producto</label>
            <select name="producto">
                <?php
                    try {
                        $productos=get_producto($conexion);
                        var_dump($productos);
                        for ($a=0; $a < count($productos); $a++) { 
                            echo("<option>".$productos[$a]["ID_PRODUCTO"]."</option>");
                        }
                    }
                    catch(PDOException $e) {
                        echo ("Error recuperar departamentos: -->".$e->getMessage()."</br>");
                    }
                ?>
            </select>
            <label for="cantidad">Cantidad</label>
            <input type="text" name="cantidad" size="2" /> <br />
                <?php
                    if (!isset($_POST) || empty($_POST)) {
                ?>
                <?php
                    } else {
                        update_producto($conexion);
                    }
                ?>
            <input type="submit" name="enviar" id="enviar" value="Enviar">
		</form>
    </body>
</html>
