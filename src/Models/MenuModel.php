<?php

class MenuModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                m.menu_id,
                m.title,
                m.description,
                m.min_persons,
                m.price_per_person,
                m.remaining_stock,
                m.conditions,
                m.is_active,
                t.label AS theme,
                d.label AS diet
            FROM menu m
            JOIN theme t ON m.theme_id = t.theme_id
            JOIN diet d ON m.diet_id = d.diet_id
            WHERE m.is_active = 1
            ORDER BY m.title ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllAdmin(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                m.menu_id,
                m.title,
                m.description,
                m.min_persons,
                m.price_per_person,
                m.remaining_stock,
                m.conditions,
                m.is_active,
                t.label AS theme,
                d.label AS diet
            FROM menu m
            JOIN theme t ON m.theme_id = t.theme_id
            JOIN diet d ON m.diet_id = d.diet_id
            ORDER BY m.title ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                m.menu_id,
                m.title,
                m.description,
                m.min_persons,
                m.price_per_person,
                m.remaining_stock,
                m.conditions,
                m.is_active,
                t.label AS theme,
                d.label AS diet
            FROM menu m
            JOIN theme t ON m.theme_id = t.theme_id
            JOIN diet d ON m.diet_id = d.diet_id
            WHERE m.menu_id = :id
            AND m.is_active = 1
        ");
        $stmt->execute([':id' => $id]);
        $menu = $stmt->fetch();

        return $menu ?: null;
    }


    public function getByIdAdmin(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                m.menu_id,
                m.title,
                m.description,
                m.min_persons,
                m.price_per_person,
                m.remaining_stock,
                m.conditions,
                m.is_active,
                m.theme_id,
                m.diet_id,
                t.label AS theme,
                d.label AS diet
            FROM menu m
            JOIN theme t ON m.theme_id = t.theme_id
            JOIN diet d ON m.diet_id = d.diet_id
            WHERE m.menu_id = :id
        ");
        $stmt->execute([':id' => $id]);
        $menu = $stmt->fetch();

        return $menu ?: null;
    }
    public function getMenuPicture(int $menuId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                pm.url,
                pm.alt_text
            FROM picture_menu pm
            WHERE pm.menu_id = :menu_id
            ORDER BY pm.display_order ASC
        ");
        $stmt->execute([':menu_id' => $menuId]);
        $picture = $stmt->fetch();

    return $picture ?: null;
    }


    public function getDishesByMenuId(int $menuId): array
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
        $stmt->execute([':menu_id' => $menuId]);
        return $stmt->fetchAll();
    }

    public function createMenu(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO menu (
                title,
                description,
                min_persons,
                price_per_person,
                remaining_stock,
                conditions,
                is_active,
                theme_id,
                diet_id
            ) VALUES (
                :title,
                :description,
                :min_persons,
                :price_per_person,
                :remaining_stock,
                :conditions,
                :is_active,
                :theme_id,
                :diet_id
            )
        ");

        $stmt->execute([
            ':title' => $data['title'],
            ':description'=> $data['description'],
            ':min_persons'=> $data['min_persons'],
            ':price_per_person'=> $data['price_per_person'],
            ':remaining_stock'=> $data['remaining_stock'],
            ':conditions'=> $data['conditions'] ?? null,
            ':is_active'=> $data['is_active'] ?? 1,
            ':theme_id'=> $data['theme_id'],
            ':diet_id'=> $data['diet_id']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateMenu(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE menu SET
                title = :title,
                description = :description,
                min_persons = :min_persons,
                price_per_person = :price_per_person,
                remaining_stock = :remaining_stock,
                conditions = :conditions,
                is_active = :is_active,
                theme_id = :theme_id,
                diet_id = :diet_id
            WHERE menu_id = :id
        ");

        return $stmt->execute([
            ':title' => $data['title'],
            ':description'=> $data['description'],
            ':min_persons'=> $data['min_persons'],
            ':price_per_person'=> $data['price_per_person'],
            ':remaining_stock'=> $data['remaining_stock'],
            ':conditions'=> $data['conditions'] ?? null,
            ':is_active'=> $data['is_active'] ?? 1,
            ':theme_id'=> $data['theme_id'],
            ':diet_id'=> $data['diet_id'],
            ':id' => $id 
        ]);
    }

    public function addDishToMenu(int $menuId, int $dishId): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO menu_dish (menu_id, dish_id)
            VALUES (:menu_id, :dish_id)
        ");
        return $stmt->execute([
            ':menu_id' => $menuId,
            ':dish_id' => $dishId
        ]);
    }

    public function desactivateMenu(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE menu 
            SET is_active = 0
            WHERE menu_id = :id
        ");

        return $stmt->execute([':id' => $id]);
    }

    public function activateMenu(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE menu 
            SET is_active = 1
            WHERE menu_id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }
    public function setMenuActive(int $id, bool $isActive): bool
    {
        $stmt = $this->db->prepare("
            UPDATE menu 
            SET is_active = :is_active
            WHERE menu_id = :id
        ");

        return $stmt->execute([
            ':is_active' => $isActive ? 1 : 0,
            ':id' => $id
        ]);
    }

    public function deleteMenu(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM menu WHERE menu_id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }

    public function deleteMenuDishes(int $menuId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM menu_dish WHERE menu_id = :menu_id
        ");
        return $stmt->execute([':menu_id' => $menuId]);
    }

}