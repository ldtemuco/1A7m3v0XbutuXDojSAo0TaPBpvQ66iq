<?php
declare(strict_types=1);
namespace Tienda\Controladores;

use Throwable;
use InvalidArgumentException;

final class DSN
{
    public function __construct(
        public readonly string $dbHost,
        public readonly int    $dbPort,
        public readonly string $dbName,
        public readonly string $dbUser,
        public readonly string $dbPass,
        public readonly string $dbCharset = 'utf8mb4',
        public readonly array  $dbOptions = [],
    ) {}

    public function pdoDsn(): string {
        
        return "mysql:host={$this->dbHost};port={$this->dbPort};dbname={$this->dbName};charset={$this->dbCharset}";
    }

    public static function fromArray(array $data): self
    {  
        foreach (['dbHost', 'dbPort', 'dbName', 'dbUser', 'dbPass', 'dbCharset'] as $key) {
            if (!isset($data[$key]) || $data[$key] === '') {                
                try {
                    throw new InvalidArgumentException("Falta el índice: '$key'", 500);
                } 
                catch (Throwable $e) {
                    die('Error en DSN');            
                }
            }
        }             
        return new self(
            dbHost: (string) $data['dbHost'],
            dbPort: (int) $data['dbPort'],
            dbName: (string) $data['dbName'],
            dbUser: (string) $data['dbUser'],
            dbPass: (string) $data['dbPass'],
            dbCharset: (string) $data['dbCharset'],
            dbOptions: isset($data['dbOptions']) && is_array($data['dbOptions']) ? (array) $data['dbOptions'] : self::defaultOptions()            
        );
    }
    
    public static function defaultOptions(): array {
        return  
        [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
            \PDO::ATTR_STRINGIFY_FETCHES  => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_spanish_ci",
        ];
    }
}
