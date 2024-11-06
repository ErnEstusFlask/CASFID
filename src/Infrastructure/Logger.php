<?php

namespace Infrastructure;

class Logger
{
    private $logFile;

    // Constructor para definir el archivo de log
    public function __construct($logFile = 'app.log')
    {
        $this->logFile = $logFile;
    }

    // Método para escribir en el archivo de log
    public function log($message, $level = 'INFO')
    {
        // Asegurarse de que el directorio del log existe
        if (!file_exists(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0777, true);
        }

        // Formato de la fecha y hora
        $timestamp = date('Y-m-d H:i:s');
        
        // Formatear el mensaje
        $logMessage = "[$timestamp] [$level] $message" . PHP_EOL;

        // Escribir el mensaje en el archivo de log
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    // Método para registrar errores
    public function logError($message)
    {
        $this->log($message, 'ERROR');
    }

    // Método para registrar cambios
    public function logChange($message)
    {
        $this->log($message, 'CHANGE');
    }

    // Método para registrar llamadas a la Api
    public function logApi($message)
    {
        $this->log($message, 'API');
    }
}
