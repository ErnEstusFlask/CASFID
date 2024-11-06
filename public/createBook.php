<?php

// Cargar el autoloader de Composer
require '../vendor/autoload.php';

use Application\BookController;
use Application\CSRFToken;

$csrfToken = CSRFToken::generateToken(); // Generar token CSRF

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $csrfToken = $_POST['csrf_token'];
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    // Crear una instancia del controlador
    $bookController = new BookController();

    $result = $bookController->create($title, $author, $isbn, $year, $csrfToken);

    if ($result) {
        echo "El libro fue creado exitosamente.";
    }
}


// echo var_dump($book);

?>
<!DOCTYPE html>
<html>
    <head>
        <style>
        </style>
    </head>
    <body>
        <p>
            <a href="index.php">Inicio</a>
        </p>
        <h1>Añadir Libro</h1>
        
            <form action="createBook.php" method="POST">
                
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" id="isbn" maxlength="13" value="" required><br><br>

                <label for="title">Título:</label>
                <input type="text" name="title" id="title" value="" required><br><br>
                
                <label for="author">Autor:</label>
                <input type="text" name="author" id="author" value="" required><br><br>
                
                <label for="year">Año de publicación:</label>
                <input type="number" name="year" id="year" max="9999" value="" required><br><br>
                
                <button type="submit">Añadir</button>
            </form>
    </body>
</html>