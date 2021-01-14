-- Script proporcionado por el Departamento de Sistemas
CREATE DATABASE COMPRASWEB;
USE COMPRASWEB;

CREATE TABLE CLIENTE
(NIF VARCHAR(9),
 NOMBRE VARCHAR(40),
 APELLIDO VARCHAR(40),
 CP VARCHAR(5),
 DIRECCION VARCHAR(40),
 CIUDAD VARCHAR(40));
 
ALTER TABLE CLIENTE ADD CONSTRAINT PK_CLIENTE PRIMARY KEY (NIF); 

CREATE TABLE CATEGORIA
(ID_CATEGORIA VARCHAR(5),
 NOMBRE VARCHAR(40));
 
ALTER TABLE CATEGORIA ADD CONSTRAINT PK_CATEGORIA PRIMARY KEY (ID_CATEGORIA); 

CREATE TABLE ALMACEN
(NUM_ALMACEN INTEGER,
 LOCALIDAD VARCHAR(40));
 
ALTER TABLE ALMACEN ADD CONSTRAINT PK_ALMACEN PRIMARY KEY (NUM_ALMACEN); 


CREATE TABLE PRODUCTO
(ID_PRODUCTO VARCHAR(5),
 NOMBRE VARCHAR(40),
 PRECIO DOUBLE,
 ID_CATEGORIA VARCHAR(5));

ALTER TABLE PRODUCTO ADD CONSTRAINT PK_PRODUCTO PRIMARY KEY (ID_PRODUCTO); 

ALTER TABLE PRODUCTO ADD CONSTRAINT FK_PROD_CAT FOREIGN KEY (ID_CATEGORIA) REFERENCES CATEGORIA(ID_CATEGORIA); 

CREATE TABLE COMPRA
(NIF VARCHAR(9),
 ID_PRODUCTO VARCHAR(5),
 FECHA_COMPRA DATE,
 UNIDADES INTEGER);
 
ALTER TABLE COMPRA ADD CONSTRAINT PK_COMPRA PRIMARY KEY (NIF,ID_PRODUCTO,FECHA_COMPRA);  
 
ALTER TABLE COMPRA ADD CONSTRAINT FK_COM_CLI FOREIGN KEY (NIF) REFERENCES CLIENTE(NIF);  

ALTER TABLE COMPRA ADD CONSTRAINT FK_COM_PRO FOREIGN KEY (ID_PRODUCTO) REFERENCES PRODUCTO(ID_PRODUCTO); 

CREATE TABLE ALMACENA
(NUM_ALMACEN INTEGER,
 ID_PRODUCTO VARCHAR(5),
 CANTIDAD INTEGER);

ALTER TABLE ALMACENA ADD CONSTRAINT PK_ALMACENA PRIMARY KEY (NUM_ALMACEN,ID_PRODUCTO); 

ALTER TABLE ALMACENA ADD CONSTRAINT FK_ALM_ALM FOREIGN KEY (NUM_ALMACEN) REFERENCES ALMACEN(NUM_ALMACEN);  

ALTER TABLE ALMACENA ADD CONSTRAINT FK_ALM_PRO FOREIGN KEY (ID_PRODUCTO) REFERENCES PRODUCTO(ID_PRODUCTO); 




-- Modificación realizada para ajustarse a los cambios del cliente

-- Sobre la tabla 'categoría', y claves ajenas
ALTER TABLE categoria MODIFY ID_CATEGORIA varchar(20);
ALTER TABLE categoria MODIFY NOMBRE varchar(800);
ALTER TABLE producto MODIFY ID_CATEGORIA varchar(20);

-- Sobre la tabla 'producto', y claves ajenas
ALTER TABLE producto MODIFY ID_PRODUCTO varchar(10);
ALTER TABLE producto MODIFY NOMBRE varchar(50);
ALTER TABLE compra MODIFY ID_PRODUCTO varchar(10);
ALTER TABLE almacena MODIFY ID_PRODUCTO varchar(10);
                     
-- Sobre la tabla 'compra', para admitir no solo Fecha, sino también Hora (CURRENT_TIMESTAMP);
ALTER TABLE compra MODIFY FECHA_COMPRA DATETIME;


-- Inserción de las categorías (proporcionadas por el cliente) [OPCIONAL]
INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE`) VALUES
('Classic Cars', 'Attention car enthusiasts: Make your wildest car ownership dreams come true. Whether you are looking for classic muscle cars, dream sports cars or movie-inspired miniatures, you will find great choices in this category. These replicas feature superb attention to detail and craftsmanship and offer features such as working steering system, opening forward compartment, opening rear trunk with removable spare wheel, 4-wheel independent spring suspension, and so on. The models range in size from 1:10 to 1:24 scale and include numerous limited edition and several out-of-production vehicles. All models include a certificate of authenticity from their manufacturers and come fully assembled and ready for display in the home or office.'),
('Motorcycles', 'Our motorcycles are state of the art replicas of classic as well as contemporary motorcycle legends such as Harley Davidson, Ducati and Vespa. Models contain stunning details such as official logos, rotating wheels, working kickstand, front suspension, gear-shift lever, footbrake lever, and drive chain. Materials used include diecast and plastic. The models range in size from 1:10 to 1:50 scale and include numerous limited edition and several out-of-production vehicles. All models come fully assembled and ready for display in the home or office. Most include a certificate of authenticity.'),
('Planes', 'Unique, diecast airplane and helicopter replicas suitable for collections, as well as home, office or classroom decorations. Models contain stunning details such as official logos and insignias, rotating jet engines and propellers, retractable wheels, and so on. Most come fully assembled and with a certificate of authenticity from their manufacturers.'),
('Ships', 'The perfect holiday or anniversary gift for executives, clients, friends, and family. These handcrafted model ships are unique, stunning works of art that will be treasured for generations! They come fully assembled and ready for display in the home or office. We guarantee the highest quality, and best value.'),
('Trains', 'Model trains are a rewarding hobby for enthusiasts of all ages. Whether you''re looking for collectible wooden trains, electric streetcars or locomotives, you''ll find a number of great choices for any budget within this category. The interactive aspect of trains makes toy trains perfect for young children. The wooden train sets are ideal for children under the age of 5.'),
('Trucks and Buses', 'The Truck and Bus models are realistic replicas of buses and specialized trucks produced from the early 1920s to present. The models range in size from 1:12 to 1:50 scale and include numerous limited edition and several out-of-production vehicles. Materials used include tin, diecast and plastic. All models include a certificate of authenticity from their manufacturers and are a perfect ornament for the home and office.'),
('Vintage Cars', 'Our Vintage Car models realistically portray automobiles produced from the early 1900s through the 1940s. Materials used include Bakelite, diecast, plastic and wood. Most of the replicas are in the 1:18 and 1:24 scale sizes, which provide the optimum in detail and accuracy. Prices range from $30.00 up to $180.00 for some special limited edition replicas. All models include a certificate of authenticity from their manufacturers and come fully assembled and ready for display in the home or office.');
