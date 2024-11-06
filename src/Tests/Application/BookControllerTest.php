<?php

use Application\BookController;
use PHPUnit\Framework\TestCase;
use Infrastructure\Logger;
use Infrastructure\ApiClient;
use Application\CSRFToken;
use Domain\BookRepository;
use Domain\Book;

class BookControllerTest extends TestCase
{
    private $pdo;
    private $bookController;
    private $logger;

    protected function setUp(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        

        // Creamos mocks para las dependencias de BookController
        $this->mockBookRepository = $this->createMock(BookRepository::class);
        $this->mockApiClient = $this->createMock(ApiClient::class);
        $this->mockLogger = $this->createMock(Logger::class);

        // Mock de la conexión a la base de datos
        $mockDb = $this->createMock(PDO::class);

        // Creamos el BookController pasando los mocks
        $this->bookController = new BookController();
        $this->bookController->bookRepository = $this->mockBookRepository;
        $this->bookController->apiClient = $this->mockApiClient;
        $this->bookController->logger = $this->mockLogger;
    }

    public function testCreate()
    {
        // Generamos un token CSRF
        $csrfToken = CSRFToken::generateToken();

        // Definir los parámetros de prueba
        $title = "PHP Unit Testing";
        $author = "John Doe";
        $isbn = "9781234567890";
        $pubYear = 2024;
        
        // Creamos un libro válido
        $book = new Book($title, $author, $isbn, $pubYear);

        // Simulamos la creación del libro
        $this->mockBookRepository->expects($this->once())
            ->method('create')
            ->with($book)
            ->willReturn(true);

        // Llamamos al método
        $this->bookController->create($title, $author, $isbn, $pubYear, $csrfToken);

        // Verifica que no se haya producido ningún error
        $this->assertTrue(true);
    }

    public function testUpdate()
    {
        // Simula la generación de un token CSRF
        $csrfToken = CSRFToken::generateToken();

        // Definir los parámetros de prueba
        $isbn = "9781234567891";
        $oldIsbn = "9781234567890";
        $title = "PHP Unit Testing - Updated";
        $author = "Jane Doe";
        $pubYear = 2025;

        // Creamos un libro válido
        $book = new Book($title, $author, $isbn, $pubYear);
        
        // Simulamos la actualización del libro
        $this->mockBookRepository->expects($this->once())
            ->method('create')
            ->with($book, $oldIsbn)
            ->willReturn(true);

        // Llamamos al método
        $this->bookController->update($isbn, $title, $author, $pubYear, $oldIsbn, $csrfToken);
    }

    public function testDelete()
    {

        // Simula la generación de un token CSRF
        $csrfToken = CSRFToken::generateToken();

        // Definir el ISBN del libro a eliminar
        $isbn = "9781234567890";
        
        // Simulamos la eliminación del libro
        $this->mockBookRepository->expects($this->once())
            ->method('delete')
            ->with($isbn)
            ->willReturn(true);

        // Llamamos al método
        $this->bookController->delete($isbn, $csrfToken);
    }
}
