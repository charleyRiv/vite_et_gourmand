<?php

class DishModel
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
                d.dish_id,
                d.title,
                d.description,
                d.dish_type
            FROM dish d
            ORDER BY d.title ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllWithFilters(array $filters = [], int $limit = 6, int $offset = 0): array
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['dish_type'])) {
            $placeholders = implode(',', array_map(fn($i) => ':dish_type' . $i, array_keys($filters['dish_type'])));
            $conditions[] = 'd.dish_type IN (' . $placeholders . ')';
            foreach ($filters['dish_type'] as $i => $dishType) {
                $params[':dish_type' . $i] = $dishType;
            }
        }

        if (!empty($filters['allergen'])) {
            $placeholders = implode(',', array_map(fn($i) => ':allergen_' . $i, array_keys($filters['allergen'])));
            $conditions[] = 'da.allergen_id IN (' . $placeholders . ')';
            foreach ($filters['allergen'] as $i => $allergenId) {
                $params[':allergen_' . $i] = (int) $allergenId;
            }
        }

        if (!empty($filters['search'])) {
            $conditions[] = 'd.title LIKE :search';
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        $where = !empty($conditions)
        ? 'WHERE ' . implode(' AND ', $conditions)
        : '';

        $stmt = $this->db->prepare("
            SELECT 
                d.dish_id,
                d.title,
                d.description,
                d.dish_type,
                GROUP_CONCAT(DISTINCT a.label SEPARATOR ', ') AS allergens_labels,
                GROUP_CONCAT(DISTINCT a.allergen_id SEPARATOR ', ') AS allergens_ids,
                COUNT(DISTINCT md.menu_id) AS menu_count
            FROM dish d
            LEFT JOIN dish_allergen da ON d.dish_id = da.dish_id
            LEFT JOIN allergen a ON da.allergen_id = a.allergen_id
            LEFT JOIN menu_dish md ON d.dish_id = md.dish_id
            $where
            GROUP BY d.dish_id
            ORDER BY d.title ASC
            LIMIT :limit
            OFFSET :offset
        ");

        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $type);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByID(int $id): array
    {
        $stmt = $this->db->prepare("
            SELECT
                d.dish_id,
                d.title,
                d.description,
                d.dish_type
            FROM dish d
            WHERE d.dish_id = :id
        ");
        $stmt->execute([':id' => $id]);
        $dish = $stmt->fetch();
        return $dish ?: null;
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

    public function createDish(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO dish (
                title,
                description,
                dish_type
            )
            VALUES (
                :title, 
                :description, 
                :dish_type)
        ");
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':dish_type' => $data['dish_type']
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function updateDish(int $id, array $data): void
    {
        $stmt = $this->db->prepare("
            UPDATE dish
            SET 
                title = :title,
                description = :description,
                dish_type = :dish_type
            WHERE dish_id = :id
        ");
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':dish_type' => $data['dish_type'],
            ':id' => $id
        ]);
    }

    public function deleteDish(int $id): void
    {
        $stmt = $this->db->prepare("
        DELETE FROM dish 
        WHERE dish_id = :id
        ");

        $stmt->execute([':id' => $id]);
    }

    public function getDishTypes(): array
    {
        $stmt = $this->db->prepare("
            SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'dish'
            AND COLUMN_NAME = 'dish_type'
            AND TABLE_SCHEMA = :dbname
        ");
        $stmt->execute([':dbname' => $_ENV['DB_NAME']]);
        $result = $stmt->fetch();


        if (!$result) return []; 
        // Extraire les valeurs de l'ENUM
        // COLUMN_TYPE retourne : enum('starter','main','dessert')
        preg_match_all("/'([^']+)'/", $result['COLUMN_TYPE'], $matches);
        return $matches[1]; // ['starter', 'main', 'dessert']
    }

    public function getCountDishByMenus(int $dishId): int
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS total
        FROM menu_dish
        WHERE dish_id = :dish_id
        ");

        $stmt->execute([':dish_id' => $dishId]);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function getCountWithFilters(array $filters = []): int
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['dish_type'])) {
            $placeholders = implode(',', array_map(fn($i) => ':dish_type' . $i, array_keys($filters['dish_type'])));
            $conditions[] = 'd.dish_type IN (' . $placeholders . ')';
            foreach ($filters['dish_type'] as $i => $dishType) {
                $params[':dish_type' . $i] = (int) $dishType;
            }
        }

        if (!empty($filters['allergen'])) {
            $placeholders = implode(',', array_map(fn($i) => ':allergen_' . $i, array_keys($filters['allergen'])));
            $conditions[] = 'da.allergen_id IN (' . $placeholders . ')';
            foreach ($filters['allergen'] as $i => $allergenId) {
                $params[':allergen_' . $i] = (int) $allergenId;
            }
        }

        if (!empty($filters['search'])) {
            $conditions[] = 'd.title LIKE :search';
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        $where = !empty($conditions)
        ? 'WHERE ' . implode(' AND ', $conditions)
        : '';

        $stmt = $this->db->prepare("
            SELECT COUNT(DISTINCT d.dish_id) AS total
            FROM dish d
            LEFT JOIN dish_allergen da ON d.dish_id = da.dish_id
            LEFT JOIN allergen a ON da.allergen_id = a.allergen_id
            LEFT JOIN menu_dish md ON d.dish_id = md.dish_id
            $where
        ");

        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $type);
        }

        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }
}