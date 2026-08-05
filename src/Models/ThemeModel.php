<?php

class ThemeModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createTheme(string $label): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO theme (label)
            VALUES (:label)
        ");
        return $stmt->execute([':label' => $label]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                theme_id,
                label
            FROM theme
            ORDER BY label ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getThemeByMenuId(int $menuId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                t.theme_id,
                t.label
            FROM theme t
            JOIN menu m ON t.theme_id = m.theme_id
            WHERE m.menu_id = :menu_id
        ");
        $stmt->execute([':menu_id' => $menuId]);
        $theme = $stmt->fetch();
        return $theme ?: null;
    }

    public function updateTheme(int $id, string $label): bool
    {
        $stmt = $this->db->prepare("
            UPDATE theme
            SET label = :label
            WHERE theme_id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':label' => $label
        ]);
    }

    public function deleteTheme(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM theme
            WHERE theme_id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }
}
