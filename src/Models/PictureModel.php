<?php

class PictureModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // -- Photos des plats --

    public function addPictureToDish(int $dishId,array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO picture_dish (
            url, 
            title, 
            alt_text, 
            slug, 
            display_order, 
            dish_id)
            VALUES (
            :url, 
            :title, 
            :alt_text, 
            :slug, 
            :display_order, 
            :dish_id)
            ");
            $stmt->execute([
                ':url' => $data['url'],
                ':title' => $data['title'],
                ':alt_text' => $data['alt_text'],
                ':slug' => $data['slug'],
                ':display_order' => $data['display_order'] ?? 0,
                ':dish_id' => $dishId
            ]);
            return (int)$this->db->lastInsertId();
    }

    public function getByDishId(int $dishId): array
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

    public function deleteFromDish(int $pictureId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM picture_dish
            WHERE picture_id = :picture_id
        ");
        return $stmt->execute([':picture_id' => $pictureId]);
    }


    public function updateDishPictureMeta(int $pictureId, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE picture_dish
            SET 
                title = :title,
                alt_text = :alt_text,
                slug = :slug,
                display_order = :display_order
            WHERE picture_id = :picture_id
        ");
        return $stmt->execute([
            ':title' => $data['title'],
            ':alt_text' => $data['alt_text'],
            ':slug' => $data['slug'],
            ':display_order' => $data['display_order'],
            ':picture_id' => $pictureId
        ]);
    }
    // -- Photos des menus --

    public function addPictureToMenu(int $menuId,array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO picture_menu (
            url, 
            title, 
            alt_text, 
            slug, 
            display_order, 
            menu_id)
            VALUES (
            :url, 
            :title, 
            :alt_text, 
            :slug, 
            :display_order, 
            :menu_id)
            ");
            $stmt->execute([
                ':url' => $data['url'],
                ':title' => $data['title'],
                ':alt_text' => $data['alt_text'],
                ':slug' => $data['slug'],
                ':display_order' => $data['display_order'] ?? 0,
                ':menu_id' => $menuId
            ]);
            return (int)$this->db->lastInsertId();
    }

    public function getByMenuId(int $menuId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                pm.picture_id,
                pm.url,
                pm.title,
                pm.alt_text,
                pm.slug,
                pm.display_order,
                pm.menu_id
            FROM picture_menu pm
            WHERE pm.menu_id = :menu_id
            ORDER BY pm.display_order ASC
        ");
        $stmt->execute([':menu_id' => $menuId]);
        return $stmt->fetchAll();
    }

    public function deleteFromMenu(int $pictureId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM picture_menu
            WHERE picture_id = :picture_id
        ");
        return $stmt->execute([':picture_id' => $pictureId]);
    }


    public function updateMenuPictureMeta(int $pictureId, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE picture_menu
            SET 
                title = :title,
                alt_text = :alt_text,
                slug = :slug,
                display_order = :display_order
            WHERE picture_id = :picture_id
        ");
        return $stmt->execute([
            ':title' => $data['title'],
            ':alt_text' => $data['alt_text'],
            ':slug' => $data['slug'],
            ':display_order' => $data['display_order'],
            ':picture_id' => $pictureId
        ]);
    }
}