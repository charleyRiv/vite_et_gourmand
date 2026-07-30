<?php

class AuthMiddleware
{
    public static function requireAuth(): void
    {
        if (!Session::isLoggedIn())
            {
                header('Location: /connexion');
                exit();
            }
    }

    public static function requireRole(array $rolesAuth): void
    {
        self::requireAuth();

        $role = Session::get('role');

        if (!in_array($role, $rolesAuth))
            {
                http_response_code(403);
                require_once __DIR__ . '/../../views/errors/403.php';
                exit();
            }
    }
}