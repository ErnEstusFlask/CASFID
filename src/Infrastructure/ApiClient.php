<?php

namespace Infrastructure;

class ApiClient {

    private $baseUrl = 'https://openlibrary.org/api/books';

    /**
     * Realiza una consulta a la API externa de Open Library
     * @param string $isbn El ISBN del libro que queremos consultar
     * @return array|null La respuesta de la API o null si ocurre un error
     */
    public function getBookDataByIsbn($isbn) {
        // Preparamos la URL para hacer la consulta
        $url = "{$this->baseUrl}?bibkeys=ISBN:{$isbn}&jscmd=details&format=json";
        
        // Usamos cURL para realizar la petición
        $ch = curl_init();
        
        // Configuramos la opción para hacer una petición GET
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para obtener la respuesta como string
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Tiempo de espera máximo en segundos

        // Ejecutamos la solicitud y almacenamos la respuesta
        $response = curl_exec($ch);

        // Verificamos si hubo algún error durante la ejecución de cURL
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            die("Error en la conexión a la API: " . $error);
        }

        // Cerramos la sesión de cURL
        curl_close($ch);

        // Decodificamos la respuesta JSON en un array asociativo
        $data = json_decode($response, true);

        // Si no hay datos para el ISBN proporcionado, devolvemos null
        if (isset($data["ISBN:{$isbn}"])) {
            return $data["ISBN:{$isbn}"];
        }

        return null; // No se encontró información para ese ISBN
    }

    public function getBookCoverByIsbn($isbn) {
        $url = "https://covers.openlibrary.org/b/isbn/{$isbn}-M.jpg";
        return $url;
    }
}
