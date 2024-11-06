<?php

// Cargar el autoloader de Composer
require '../vendor/autoload.php';

use Application\BookController;

// Crear el controlador
$bookController = new BookController();


if (isset($_GET['isbn'])) {
    // Almacenar el parametro isbn
    $bookIsbn = $_GET['isbn'];
    $book = $bookController->getBookByIsbn($bookIsbn);
} else {
    // Pner el parametro en null al no ser encontrado
    $bookIsbn = null;
    $book = false;
}

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
        <?php if ($book): // Comprobar si el libro existe?>

        <h1><?= htmlspecialchars($book['title']." - ".$book['author'], ENT_QUOTES, 'UTF-8')?></h1>
        <h2>ISBN: <?= htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8')?></h2>
        <img src="<?= htmlspecialchars($bookController->getBookCoverByIsbn($bookIsbn), ENT_QUOTES, 'UTF-8')?>" alt="Portada del libro">
        <p><b>Año de publicación:</b> <?= htmlspecialchars($book['pubYear'], ENT_QUOTES, 'UTF-8')?></p>
        <b>Descripcion:</b><p><?= htmlspecialchars($bookController->getBookDescriptionByIsbn($bookIsbn), ENT_QUOTES, 'UTF-8')?></p>
        <a href="editBook.php?isbn=<?= htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8')?>">Editar</a>
        <a href="deleteBook.php?isbn=<?php echo htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8'); ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este libro?');">Eliminar Libro</a>
        
        <?php endif; ?>
    </body>
</html>