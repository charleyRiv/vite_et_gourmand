<?php

class DishModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByMenuId(int $menuId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                d.dish_id,
                d.title,
                d.description,
                d.dish_type
            FROM dish d
            JOIN menu_dish md ON d.dish_id = md.dish_id
            WHERE md.menu_id = :menu_id
            ORDER BY d.dish_type ASC
        ");
        $stmt->execute([':menu_id' =>$menuId]);
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

    public function getPicturesByDishId(int $dishId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                pd.picture_id,
                pd.url,
                pd.title,
                pd.alt_text,
                pd.slug,
                pd.display_order,
                pd.dish_id
            FROM picture_dish pd
            WHERE pd.dish_id = :dish_id
            ORDER BY pd.display_order ASC
        ");
        $stmt->execute([':dish_id' =>$dishId]);
        return $stmt->fetchAll();
    }

}