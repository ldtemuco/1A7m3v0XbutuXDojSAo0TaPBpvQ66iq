<?php
 
namespace Tienda\Controladores;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR .'Config.php';

final class Constantes{  
    
    public const DB_DSN =  [
        'dbHost' => DB_HOST,
        'dbPort' => DB_PORT, 
        'dbName' => DB_NAME,
        'dbUser' => DB_USER,
        'dbPass' => DB_PASS,
        'dbCharset' => DB_CHARSET
    ]; 
   
    public const SERVER_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..'; 
    public const EMPTY_STRING = '';
    public const CLASS_CONFIG = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR .'Config.php';  
    public const CLASS_DSN = __DIR__ . DIRECTORY_SEPARATOR . 'DSN.php';
    public const CLASS_DB = __DIR__ . DIRECTORY_SEPARATOR . 'DB.php';
    public const CLASS_PAGINATOR = __DIR__ . DIRECTORY_SEPARATOR . 'Paginador.php';
    public const CLASS_FILTER = __DIR__ . DIRECTORY_SEPARATOR . 'Filtro.php';
    public const CLASS_PRODUCT = __DIR__ . DIRECTORY_SEPARATOR . 'Producto.php';
    private function __construct() {}
   
}
?>
