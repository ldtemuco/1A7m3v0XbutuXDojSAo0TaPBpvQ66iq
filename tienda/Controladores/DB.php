<?php
declare(strict_types=1);
namespace Tienda\Controladores;
require_once 'Constantes.php';
use Tienda\Controladores\Constantes;
require_once Constantes::CLASS_DSN;
use Tienda\Controladores\DSN;

use PDO;
use PDOStatement;
use Throwable;
use RuntimeException;

final class DB
{
    private static ?self $instance = null;
    private PDO $pdo;
    
    private function __construct(DSN $dsn) {
        $this->pdo = new PDO(
            $dsn->pdoDsn(),
            $dsn->dbUser,
            $dsn->dbPass,
            $dsn->defaultOptions()
        );
    }
   
    public static function getInstance(DSN $dsn): self  {                
        if (self::$instance === null) {
            self::$instance = new self($dsn);
        }
        return self::$instance;
    }   
    private function __clone() {}
    public function __wakeup(): void
    {        
        try {
            throw new RuntimeException("No se puede deserializar la clase Database.", 500);
        } 
        catch (Throwable $e) {
            die('Error en Base de Datos');            
        }
    }
    
    public function pdo(): PDO
    {
        return $this->pdo;
    }
    
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);        
        foreach ($params as $key => $value) {
            $type = $this->detectType($value);
            $stmt->bindValue(is_int($key) ? $key + 1 : (str_starts_with((string)$key, ':') ? (string)$key : ':' . $key), $value, $type);
        }
        $stmt->execute();
        return $stmt;
    }
    
    public function fetch(string $sql, array $params = []): ?array
    {
        $row = $this->query($sql, $params)->fetch();
        return $row === false ? null : $row;
    }
    
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }
   
    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }
    
    public function lastInsertId(?string $name = null): string
    {
        return $this->pdo->lastInsertId($name);
    }
    
    public function begin(): void
    {
        if (!$this->pdo->inTransaction()) {
            $this->pdo->beginTransaction();
        }
    }

    public function commit(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->commit();
        }
    }

    public function rollback(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }

    public function transaction(callable $fn)
    {
        $this->begin();
        try {
            $result = $fn($this);
            $this->commit();
            return $result;
        } catch (Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }
    
    private function detectType(mixed $value): int
    {
        return match (true) {
            is_int($value)   => PDO::PARAM_INT,
            is_bool($value)  => PDO::PARAM_BOOL,
            is_null($value)  => PDO::PARAM_NULL,
            default          => PDO::PARAM_STR,
        };
    }
}
