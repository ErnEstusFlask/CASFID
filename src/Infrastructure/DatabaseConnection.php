<?php

namespace Infrastructure;

use PDO;

class DatabaseConnection {
    private $host = 'localhost'; // Dirección del servidor MySQL
    private $dbName = 'books';   // Nombre de la base de datos
    private $username = 'root';  // Usuario de la base de datos
    private $password = '';      // Contraseña del usuario
    private $charset = 'utf8mb4';// Juego de caracteres (UTF-8 recomendado)
    private $pdo;                // Instancia de PDO

    public function __construct() {
        $this->connect();
    }

    /**
     * Método para establecer la conexión a la base de datos.
     */
    private function connect() {
        // DSN (Data Source Name) de PDO para conectar a la base de datos
        $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
        
        try {
            // Crear una nueva instancia de PDO
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            
            // Configuración para manejar errores con excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Configurar el modo de recuperación de datos (opcional)
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // echo "Conexión exitosa a la base de datos {$this->dbName}\n";
        } catch (PDOException $e) {
            // Capturar cualquier error de conexión
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * Método para obtener la instancia de PDO.
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }
}
