<?php

class AllergenModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createAllergen(string $label): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO allergen (label)
            VALUES (:label)
        ");
        return $stmt->execute([':label' => $label]);
    
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                allergen_id ,
                label
            FROM allergen
            ORDER BY label ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
    }

    public function getAllergensByDishId(int $dishId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                a.allergen_id,
                a.label
            FROM allergen a
            JOIN dish_allergen da ON a.allergen_id = da.allergen_id
            WHERE da.dish_id = :dish_id
        ");
        $stmt->execute([':dish_id' =>$dishId]);
        return $stmt->fetchAll();
    }

    public function updateAllergen(int $id, string $label): bool
    {
        $stmt = $this->db->prepare("
            UPDATE allergen
            SET label = :label
            WHERE allergen_id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':label' => $label
        ]);    
    }

    public function deleteAllergen(int $id): bool
    {
        $stmt= $this->db->prepare("
            DELETE FROM allergen
            WHERE allergen_id = :id
            ");
        return $stmt->execute([':id' => $id]);
    }

    // Supprimer tous les allergènes d'un plat
    public function deleteAllergensDish(int $dishId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM dish_allergen WHERE dish_id = :dish_id
        ");
        return $stmt->execute([':dish_id' => $dishId]);
    }

    // Associer un allergène à un plat
    public function attachAllergen(int $dishId, int $allergenId): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO dish_allergen (dish_id, allergen_id)
            VALUES (:dish_id, :allergen_id)
        ");
        return $stmt->execute([
            ':dish_id'     => $dishId,
            ':allergen_id' => $allergenId
        ]);
    }
}