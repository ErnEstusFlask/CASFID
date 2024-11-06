<?php

// Cargar el autoloader de Composer
require '../vendor/autoload.php';

use Application\BookController;
use Application\CSRFToken;

// Crear el controlador
$bookController = new BookController();
$csrfToken = CSRFToken::generateToken(); // Generar token CSRF


if (isset($_GET['isbn'])) {
    // Almacenar el parametro isbn
    $bookIsbn = $_GET['isbn'];
    try{
        $bookController->delete($bookIsbn, $csrfToken);
        echo "Libro eliminado correctamente";
    } catch(Exception $e){
        echo $e->getMessage();
    }
} else {
    echo "ISBN incorrecto";
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
    </body>
</html>