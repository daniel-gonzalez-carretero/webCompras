### IMPORTANTE
Todos los archivos (incluído el archivo con código SQL 'creacionBaseDatos.sql') han sido modificados, y por tanto su contenido NO ES EL MISMO.

Antes de implementar este programa, o seguir desarrollándolo, hay que hacer lo siguiente:

1. Ejecuta el siguiente código en la consola de comandos de MySQL:
	``DROP  DATABASE  IF  EXISTS webcompras``
	(Haz una copia de seguridad, si lo consideras necesario, de los datos)
	
2. Ejecuta el contenido del archivo ``creacionBaseDatos.sql`` 
3. Comprueba que no ha habido ningún error. En ese caso, puedes seguir adelante. Si hay algún error, coméntaselo al Jefe o a la Jefa de Proyecto

En caso de que vayas a seguir escribiendo código, por favor consulta las nuevas **REGLAS DE FORMATO**, que están al final de este documento.

 
### División del Trabajo

| Apartado                                      | Persona Asignada | Estado         |
|-----------------------------------------------|------------------|----------------|
| Apartado 1  (Alta Categorías)                 | Marco            | [DONE]         |
| Apartado 2  (Alta de Productos)               | Raquel           | [DONE]         |
| Apartado 3  (Alta Masiva de Productos)        | Edu              | [DONE]         |
| Apartado 4  (Alta de Clientes)                | Dani             | [DONE]         |
| Apartado 5  (Alta de Almacenes)               | Raquel           | [DONE]         |
| Apartado 6  (Aprovisionar Productos)          | Marco            | [DONE]         |
| Apartado 7  (Compra Productos)                | Raquel           | [DONE]         |
| Apartado 8  (Consulta de Stock)               | Raquel           | [DONE]         |
| Apartado 9  (Consulta de Almacenes)           | Edu              | [DONE]         |
| Apartado 10 (Consulta de Compras)             | Raquel           | [DONE]         |
|                                               |                  |                |
| Refactorización de los apartados (1 - 10)     | Dani             | [DONE]         |
|                                               |                  |                |
| Apartado 11 (Registro de Clientes)            | Dani             | [DONE]         |
| Apartado 12 (Formulario LogIn)                |     		   |  		    |
|      -> Con Cookies		                | Raquel           | [DONE]   	    |
|      -> Con Sesiones		                | Marco            | [PENDING]      |
| Apartado 13 (Carrito de la Compra)            |     		   |  		    |
|      -> Con Cookies		                | (???)            | [NOT ASSIGNED] |
|      -> Con Sesiones		                | (???)            | [NOT ASSIGNED] |
| Apartado 14 (Consulta de Compras)             |     		   |  		    |
|      -> Con Cookies		                | Dani             | [PENDING] 	    |
|      -> Con Sesiones		                | Raquel           | [PENDING]      |
|                                               |                  |                |
| Refactorización de los apartados (11 - 14)    | (???)            | [NOT ASSIGNED] |
|                                               |                  |                |



### Reglas de Formato

 - **Sobre las variables:**
	 - El nombre de las variables debe describir qué valor van a contener sólo con leer su nombre.
	  ``$stmt -> $insertadoClientes``
	  
	 - Si el tipo de dato que van a contener es de tipo Booleano (true o false), la variable debe tener un verbo descriptivo de qué indica.
	  ``$cliente -> $clienteExiste``
	  
	 - Evita los nombres demasiado largos, o que contengan preposiciones, o palabras innecesarias 
	``$obtenerStockDeProductoEnAlmacen -> $obtenerStockProducto``



- **Sobre las consultas:**
	- Todas las consultas deberán ir en una función, para evitar repetición de posible código entre personas
	
	- Todas las funciones de este tipo, deberán llevar su correspondiente TRY-CATCH, y un mensaje de error descriptivo de qué ha pasado (en caso de saberlo) o cuándo ha ocurrido el error
	
	- Si la consulta es un SELECT, la función deberá devolver un array asociativo con únicamente la **información que se vaya a usar** (a no ser que no se sepa o pueda variar), o NULL en caso de que haya algún error
	
	- Si la sentencia a ejecutar NO ES un SELECT (insert, update o delete), deberá devolver TRUE si todo ha ido correctamente, o FALSE si ha habido algún error. Adicionalmente, se deberá iniciar una Transacción antes de ejecutar nada, y hacer un Commit o un Roll Back, dependiendo si todo vaya bien o algo falle.
	


- **Sobre las funciones, en general:**
	- Al igual que con las variables, deberán tener nombres descriptivos, cortos y con palabras relevantes
	
	- Si necesitas conectarte a la base de datos en la función, deberás globalizar la variable ``$conexion``, en vez de pasarla por parámetro
	
	- La documentación de la función es **completamente necesaria**. En ella, deberá indicar quién ha hecho la función, qué parámetros tiene y qué significa cada uno, y qué valor devuelve en caso de hacerlo, además de una breve descripción de qué hace la función. Puedes apoyar esta documentación obligatoria con comentarios a lo largo de la función, para explicar qué hace ciertas partes del código, aunque sólo si es necesario.
	


- **Sobre los formularios y archivos HTML:**
	- Siempre se va a usar el método POST, y por seguridad, se accederá a la información con la variable ``$_POST``
	
	- A no ser que lo pida expresamente el cliente, o no tenga ninguna utilidad, los formularios **no se deberán ocultar** cuando el usuario lo envíe. Se deberá mostrar un mensaje informativo, avisando que ha pasado algo (bueno o malo), pero no desaparecerá el formulario. Cualquier duda, coméntalo al Jefe o a la Jefa de Proyecto
	
	- En todos los archivos que tengan parte de HTML, deberán tener la etiqueta ``<head>``, con el autor del archivo, la etiqueta ``<meta charset="utf-8" />``, y un título descriptivo de la página
	
	- Debido a que no se verifican todos los datos que llegan desde los formularios, **todos** los ``<input>`` y ``<select>`` de un formulario, deberán tener el atributo ``required``



- **Sobre el código PHP embebido entre etiquetas HTML**

	- El único fichero que debería incluirse, sería ``funciones.php``. Si necesitas incluir el fichero ``conexion.php``, replantéate crear una función y llamarla desde ese archivo
	
	- El IF para comprobar si el usuario ha enviado un formulario, **no debe** tener un ELSE si no es completamente necesario. Plantéate la posibilidad de invertir la condición del IF, o a cambiarla si compruebas que no es necesario un ELSE


#### Puedes ver ejemplos de estas Reglas de Formato, aplicadas a los ficheros de los diez primeros apartados.
