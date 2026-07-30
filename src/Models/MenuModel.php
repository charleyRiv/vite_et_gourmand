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
}