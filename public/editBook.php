<?php

// Cargar el autoloader de Composer
require '../vendor/autoload.php';

use Application\BookController;
use Application\CSRFToken;

// Crear el controlador
$bookController = new BookController();


if (isset($_GET['isbn'])) {
    // Almacenar el parametro isbn
    $bookIsbn = $_GET['isbn'];
    $book = $bookController->getBookByIsbn($bookIsbn); // Obtener el libro
    $csrfToken = CSRFToken::generateToken(); // Generar token CSRF
} else {
    // Pner el parametro en null al no ser encontrado
    $bookIsbn = null;
    $book = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $csrfToken = $_POST['csrf_token'];
    $oldIsbn = $_POST['old_isbn'];
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    // Crear una instancia del controlador
    $bookController = new BookController();

    try {
        // Llamar al método update del controlador para agregar el libro
        $result = $bookController->update($title, $author, $isbn, $year, $oldIsbn, $csrfToken);

        if ($result) {
            echo "<p>El libro fue actualizado exitosamente.</p><a href='index.php'>Inicio</a>";
        } else {
            echo "Hubo un error al actualizar el libro.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
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
        <?php if ($book): ?>
        <p>
            <a href="index.php">Inicio</a>
        </p>
        <h1>Editar Libro</h1>
            <form action="editBook.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <input type="hidden" name="old_isbn" maxlength="13" value="<?= htmlspecialchars($book['isbn']); ?>">

                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" id="isbn" maxlength="13" value="<?= htmlspecialchars($book['isbn']); ?>" required><br><br>

                <label for="title">Título:</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($book['title']); ?>" required><br><br>
                
                <label for="author">Autor:</label>
                <input type="text" name="author" id="author" value="<?= htmlspecialchars($book['author']); ?>" required><br><br>
                
                <label for="year">Año de publicación:</label>
                <input type="number" name="year" id="year" value="<?= htmlspecialchars($book['pubYear']); ?>" required><br><br>
                
                <button type="submit">Actualizar Libro</button>
            </form>
        <?php endif; ?>
    </body>
</html>