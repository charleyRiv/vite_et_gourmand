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
        SELECT * FROM user
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
        WHERE id = :id
        LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;

    }
}