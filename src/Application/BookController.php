<?php

namespace Application;

use Domain\Book;
use Domain\BookRepository;
use Infrastructure\ApiClient;
use Infrastructure\DatabaseConnection;
use Infrastructure\Logger;

class BookController {

    public $bookRepository;
    public $apiClient;
    public $logger;

    public function __construct() {
        // Crear la conexión a la base de datos
        $dbConnection = new DatabaseConnection();
        $pdo = $dbConnection->getConnection();

        
    // Crear las dependencias
        $this->bookRepository = new BookRepository($pdo);
        $this->apiClient = new ApiClient();
        $this->logger = new Logger(); // Instanciar el logger
    }
    

    public function create($title, $author, $isbn, $publishedYear, $csrfToken) {
        CSRFToken::validateToken($csrfToken);
        try{
            $book = $this->bookRepository->findByIsbn($isbn);
            if ($book) {
                http_response_code(400); // 400 Bad Request
                throw new \Exception('El ISBN ya esta en uso');
            }else{
                if (empty($title) || empty($author) || empty($isbn) || empty($publishedYear)) {
                    http_response_code(400); // 400 Bad Request
                    throw new \Exception('Todos los campos son obligatorios');
                }else{
                    if (!is_numeric($publishedYear)) {
                        http_response_code(400); // 400 Bad Request
                        throw new \Exception('El año de publicación debe ser un número');
                    }else{
                        if (!$this->bookRepository->validateIsbn($isbn)) {
                            http_response_code(400); // 400 Bad Request
                            throw new \Exception('El ISBN no es válido');
                        }else{
                            $book = new Book($title, $author, $isbn, $publishedYear);
                            http_response_code(201);
                            $this->logger->logChange("Libro creado: Título: $title, Autor: $author, ISBN: $isbn");
                            return $this->bookRepository->create($book);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->logError("Error al crear libro: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }

    public function searchByTitleOrAuthor($query) {
        return $this->bookRepository->findByTitleOrAuthor('%' . $query . '%');
    }

    public function listAll() {
        return $this->bookRepository->findAll();
    }

    public function delete($isbn, $csrfToken) {
        CSRFToken::validateToken($csrfToken);
        try{
            $book = $this->bookRepository->findByIsbn($isbn);
            if (!$book) {
                http_response_code(404); // 404 Not Found
                throw new \Exception('Libro no encontrado');
            }else{
                http_response_code(201);
                $this->logger->logChange("Libro borrado: ISBN: $isbn");
                return $this->bookRepository->delete($isbn);
            }
        
        } catch (Exception $e) {
            $this->logger->logError("Error al borrar libro: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }

    public function update($title, $author, $isbn, $publishedYear, $oldIsbn, $csrfToken) {
        CSRFToken::validateToken($csrfToken);
        try{
            $book = $this->bookRepository->findByIsbn($oldIsbn);
            if (!$book) {
                http_response_code(404); // 404 Bad Request
                throw new \Exception('Libro no encontrado'.$oldIsbn);
            }else{
                if (empty($title) || empty($author) || empty($isbn) || empty($publishedYear)) {
                    http_response_code(400); // 400 Bad Request
                    throw new \Exception('Todos los campos son obligatorios');
                }else{
                    if (!is_numeric($publishedYear)) {
                        http_response_code(400); // 400 Bad Request
                        throw new \Exception('El año de publicación debe ser un número');
                    }else{
                        if (!$this->bookRepository->validateIsbn($isbn)) {
                            http_response_code(400); // 400 Bad Request
                            throw new \Exception('El ISBN no es válido');
                        }else{
                            $book = new Book($title, $author, $isbn, $publishedYear);
                            http_response_code(201);
                            $this->logger->logChange("Libro actualizado: Título: $title, Autor: $author, ISBN: $isbn");
                            return $this->bookRepository->update($book, $oldIsbn);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $this->logger->logError("Error al actualizar libro: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }

    public function getBookByIsbn($isbn) {
        try{
            if($isbn!=null){
                $book = $this->bookRepository->findByIsbn($isbn);
                if (!$book) {
                    http_response_code(404); // 404 Not Found
                    throw new \Exception('Libro no encontrado');
                }else{
                    http_response_code(201);
                    return $book;
                }
            }
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getBookDescriptionByIsbn($isbn) {
        try{
            $apiData = $this->apiClient->getBookDataByIsbn($isbn);
            if ($apiData) {
                if(array_key_exists('description', $apiData['details'])){
                    $this->logger->logApi("Consulta Descripción Libro");
                    return $apiData['details']['description'] ? $apiData['details']['description'] : 'No description available';
                }else{
                    http_response_code(404); // 404 Not Found
                    throw new \Exception('No hay una descripción disponible');
                }
            } else {
                http_response_code(404); // 404 Not Found
                throw new \Exception('No hay una descripción disponible');
            }
        } catch (\Exception $e) {
            $this->logger->logError("Error al consultar la API de libros" . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
        
    }

    public function getBookCoverByIsbn($isbn) {
        try{
            $apiData = $this->apiClient->getBookCoverByIsbn($isbn);
            if ($apiData) {
                $this->logger->logApi("Consulta Portada Libro");
                return $apiData;
            } else {
                http_response_code(404); // 404 Not Found
                throw new \Exception('No hay una portada disponible');
            }
        } catch (\Exception $e) {
            $this->logger->logError("Error al consultar la API de portadas" . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }
}
