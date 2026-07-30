<?php

class AuthServices
{
    //Hashage du mot de passe
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    //Verification du mot de passe
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    //Validation de la force du mot de passe
    public function validatePasswordStrength(string $password): bool
    {
        //Minimum 10 caractères
        if (strlen($password) < 10)
            return false;
        //Au moins 1 majuscule
        if (!preg_match('/[A-Z]/', $password))
            return false;
        //Au moins 1 minuscule
        if (!preg_match('/[a-z]/', $password))
            return false;
        //Au moins 1 chiffre
        if (!preg_match('/[0-9]/', $password))
            return false;
        //Au moins 1 caractère special
        if (!preg_match('/[\W_]/', $password))
            return false;

        return true;
    }

    public function generateUUID(): string
    {
        $uuid = bin2hex(random_bytes(16));
        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($uuid, 0,8),
            substr($uuid, 8,4),
            substr($uuid, 12,4),
            substr($uuid, 16,4),
            substr($uuid, 20,12)
        );
    }

    public function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}