<?php

namespace Application;

class CSRFToken
{
    // Generar un token CSRF y almacenarlo en la sesión
    public static function generateToken()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generar un token aleatorio
        }
        return $_SESSION['csrf_token'];
    }

    // Validar el token CSRF enviado en el formulario
    public static function validateToken($token)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            throw new \Exception('Token CSRF no válido');
        }
    }
}
