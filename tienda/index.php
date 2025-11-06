<?php 
namespace Tienda;

  require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controladores' . DIRECTORY_SEPARATOR .'Constantes.php';
  use Tienda\Controladores\Constantes;
  require_once Constantes::CLASS_DSN;
  use Tienda\Controladores\DSN;
  require_once Constantes::CLASS_DB;
  use Tienda\Controladores\DB;


  $DB = DB::getInstance(DSN::fromArray(Constantes::DB_DSN));
  
?>
