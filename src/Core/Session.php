<?php

class Session
{
    //Démarrer la session
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $isProduction = $_ENV['APP_ENV'] === 'production';

            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => $isProduction,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    public static function regenerate(): void 
    {
        session_regenerate_id(true);    
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key) : void 
    {
        unset($_SESSION[$key]);    
    }

}