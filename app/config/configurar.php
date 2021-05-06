<?php
// Configuracion de acceso a la base de datos
define('DB_HOST','127.0.0.1:3306');
define('DB_USUARIO','root');
define('DB_PASSWORD','1234');
define('DB_NOMBRE','mydb');

/*define('DB_HOST','localhost');
define('DB_USUARIO','root');
define('DB_PASSWORD','');
define('DB_NOMBRE','test_informa_local');*/

// Ruta de la aplicacion
define('RUTA_APP', dirname(dirname(__FILE__)));

define('RUTA_URL','http://localhost/myfp');
// NOMBRE DEL SITIO
define('NOMBRE_SITIO', 'MyFP');
// CARPETA PARA SUBIR FICHEROS
define("DOCUMENTOS_PRIVADOS", RUTA_APP."/documentos/");