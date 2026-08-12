<?php

class UserModel{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createUser(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO user (
                public_token, 
                email, 
                password, 
                last_name,
                first_name,
                phone,
                street_number,
                street_type,
                street_name,
                zip_code,
                city,
                country,
                role_id 
            )
            VALUES (
                :public_token, 
                :email, 
                :password, 
                :last_name,
                :first_name,
                :phone,
                :street_number,
                :street_type,
                :street_name,
                :zip_code,
                :city,
                :country,
                :role_id 
            )
        ");

        $stmt->execute([
            ':public_token' => $data['public_token'], 
            ':email'=> $data['email'], 
            ':password'=> $data['password'], 
            ':last_name'=> $data['last_name'],
            ':first_name'=> $data['first_name'],
            ':phone'=> $data['phone'],
            ':street_number'=> $data['street_number'],
            ':street_type'=> $data['street_type'],
            ':street_name'=> $data['street_name'],
            ':zip_code'=> $data['zip_code'],
            ':city'=> $data['city'],
            ':country'=> $data['country'],
            ':role_id'=> $data['role_id']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function findByMail(string $email): ?array
    {
        $stmt = $this->db->prepare("
        SELECT 
            u.*,
            r.label
        FROM user u
        JOIN role r ON u.role_id = r.role_id
        WHERE email = :email
        LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
        SELECT * FROM user
        WHERE user_id = :id
        LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    //Reinitialisation du mot de passe
    public function setResetToken(string $email, string $token): bool
    {
        $stmt = $this->db->prepare("
        UPDATE user
        SET token_reset = :token,
            token_reset_expiration = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
        WHERE email = :email
        ");
        return $stmt->execute([
            ':token' => $token,
            ':email' => $email
        ]);
    }

    public function findByResetToken(string $token): ?array
    {
        $stmt = $this->db->prepare("
        SELECT * FROM user
        WHERE token_reset = :token
        AND token_reset_expiration > NOW()
        LIMIT 1
        ");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function updatePassword(int $userId, string $hashedPassword): bool
    {
        $stmt = $this->db->prepare("
        UPDATE user
        SET password = :password,
            token_reset = NULL,
            token_reset_expiration = NULL,
            modified_at = NOW()
        WHERE user_id = :user_id
        ");
        return $stmt->execute([
            ':password' =>$hashedPassword,
            ':user_id' => $userId
        ]);
    }

    public function updateProfile(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE user
            SET last_name = :last_name,
                first_name = :first_name,
                phone = :phone,
                street_number = :street_number,
                street_type = :street_type,
                street_name = :street_name,
                zip_code = :zip_code,
                city = :city,
                country = :country,
                modified_at = current_timestamp
            WHERE user_id = :user_id
        ");
        return $stmt->execute([
            ':last_name' => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':phone' => $data['phone'],
            ':street_number' => $data['street_number'],
            ':street_type' => $data['street_type'],
            ':street_name' => $data['street_name'],
            ':zip_code'=> $data['zip_code'],
            ':city' => $data['city'],
            ':country' => $data['country'],
            ':user_id' => $data['user_id']
        ]);
    }

    public function deleteUser(int $id): bool 
    {
        $stmt = $this->db->prepare("
            DELETE FROM user 
            WHERE user_id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }
}