<?php
// Incluir el controlador de libros
require '../vendor/autoload.php';

use Application\BookController;
use Application\CSRFToken;

// Inicializar el controlador
$bookController = new BookController();

// Variable para los resultados de la búsqueda
$books = [];

// Si se ha enviado el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    // Obtener el término de búsqueda (título o autor)
    $searchTerm = $_GET['search'];

    // Buscar los libros en la base de datos
    try {
        $books = $bookController->searchByTitleOrAuthor($searchTerm);
    } catch (Exception $e) {
        echo "<p>Error al realizar la búsqueda: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Libros</title>
</head>
<body>
    <p>
        <a href="index.php">Inicio</a>
    </p>
    <h1>Buscar Libros</h1>

    <!-- Formulario de búsqueda -->
    <form action="searchBook.php" method="GET">
        <label for="search">Buscar por Título o Autor:</label>
        <input type="text" name="search" id="search" required>
        <button type="submit">Buscar</button>
    </form>

    <!-- Mostrar resultados de la búsqueda -->
    <?php if (!empty($books)): ?>
        <h2>Resultados de la búsqueda:</h2>
        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <strong><?= htmlspecialchars($book['title']) ?></strong> por <?= htmlspecialchars($book['author']) ?>
                    <br>
                    <a href="viewBook.php?isbn=<?= htmlspecialchars($book['isbn']) ?>">Ver detalles</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($searchTerm)): ?>
        <p>No se encontraron libros con el término de búsqueda: <?= htmlspecialchars($searchTerm) ?></p>
    <?php endif; ?>
</body>
</html>
