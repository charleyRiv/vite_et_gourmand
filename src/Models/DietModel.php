<?php

class DietModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createDiet(string $label): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO diet (label)
            VALUES (:label)
        ");
        return $stmt->execute([':label' => $label]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                diet_id,
                label
                FROM diet
                ORDER BY label ASC
            ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getDietByMenuId(int $menuId): ?array
    {
        $stmt= $this->db->prepare("
            SELECT
                d.diet_id,
                d.label
                FROM diet d
                JOIN menu m ON d.diet_id = m.diet_id
                WHERE m.menu_id = :menu_id
        ");
        $stmt->execute([':menu_id' => $menuId]);
        $diet = $stmt->fetch();
        return $diet ?: null;
    }
}