<?php

use Infrastructure\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    private $logger;
    private $logFile;

    protected function setUp(): void
    {
        $this->logFile = 'test.log'; // Archivo de log temporal para las pruebas
        $this->logger = new Logger($this->logFile);
    }

    public function testLog()
    {
        $message = "This is a test message";
        $this->logger->log($message);

        // Verificamos si el mensaje fue agregado al archivo de log
        $logContents = file_get_contents($this->logFile);
        $this->assertStringContainsString($message, $logContents);
    }

    public function testLogError()
    {
        $message = "This is an error message";
        $this->logger->logError($message);

        // Verificamos si el mensaje con el nivel de error está en el log
        $logContents = file_get_contents($this->logFile);
        $this->assertStringContainsString("[ERROR] $message", $logContents);
    }

    public function testLogChange()
    {
        $message = "This is a change message";
        $this->logger->logChange($message);

        // Verificamos si el mensaje con el nivel de change está en el log
        $logContents = file_get_contents($this->logFile);
        $this->assertStringContainsString("[CHANGE] $message", $logContents);
    }

    protected function tearDown(): void
    {
        // Limpiar el archivo de log después de las pruebas
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
    }
}
