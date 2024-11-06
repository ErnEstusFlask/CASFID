<?php

// Cargar el autoloader de Composer
require '../vendor/autoload.php';

use Application\BookController;

// Crear el controlador
$bookController = new BookController();

// Listar los libros
$books = $bookController->listAll();

?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <p>
            <a href="searchBook.php">Busqueda de libros</a> - 
            <a href="createBook.php">Añadir Libro</a>
        </p>
        <h1>Listado de libros</h1>
        <table>
            <tr>
                <th>Titulo</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Año</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><a href="viewBook.php?isbn=<?= htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8')?>"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8')?></a></td>
                    <td><?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8')?></td>
                    <td><?= htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8')?></td>
                    <td><?= htmlspecialchars($book['pubYear'], ENT_QUOTES, 'UTF-8')?></td>
                </tr>
            <?php endforeach;?>

        </table>
    </body>
</html>