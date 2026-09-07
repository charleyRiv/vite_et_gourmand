<?php

class ReviewModel
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
                r.review_id,
                r.rating,
                r.comment,
                r.validation_status,
                r.reviewed_at,
                r.order_id,
                r.user_id,
                u.last_name,
                u.first_name
            FROM review r
            JOIN customer_order co ON r.order_id = co.order_id
            JOIN user u ON r.user_id = u.user_id
            ORDER BY reviewed_at ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllWithFilters(array $filters = [], int $limit = 4, int $offset = 0): ?array
    {
        $conditions = [];
        $params     = [];

        //Filtre par statut
        if (!empty($filters['status'])) {
            $placeholders = implode(',', array_map(fn($i) => ':status_' . $i, array_keys($filters['status'])));
            $conditions[] = 'r.validation_status IN (' . $placeholders . ')';
            foreach ($filters['status'] as $i => $status) {
                $params[':status_' . $i] = $status;
            }
        }

        //Filtre par note
        if (!empty($filters['rate'])) {
            $placeholders = implode(',', array_map(fn($i) => ':rate_' . $i, array_keys($filters['rate'])));
            $conditions[] = 'r.rating IN (' . $placeholders . ')';
            foreach ($filters['rate'] as $i => $rate) {
                $params[':rate_' . $i] = (int) $rate;
            }
        }

        //Filtre par date
        if (!empty($filters['date_from'])) {
            $conditions[] = 'r.reviewed_at >= :date_from ';
            $params[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $conditions[] = 'r.reviewed_at <= :date_to ';
            $params[':date_to'] = $filters['date_to'];
        }


        $where = !empty($conditions)
            ? 'WHERE ' . implode(' AND ', $conditions) 
            : '' ;


        $stmt = $this->db->prepare("
            SELECT
                r.review_id,
                r.rating,
                r.comment,
                r.validation_status,
                r.reviewed_at,
                r.order_id,
                r.user_id,
                u.last_name,
                u.first_name
            FROM review r
            JOIN customer_order co ON r.order_id = co.order_id
            JOIN user u ON r.user_id = u.user_id
            $where
            ORDER BY reviewed_at ASC
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

    public function countWithFilters(array $filters = []): int
    {
        $conditions = [];
        $params     = [];
        
        //Filtre par statut
        if (!empty($filters['status'])) {
            $placeholders = implode(',', array_map(fn($i) => ':status_' . $i, array_keys($filters['status'])));
            $conditions[] = 'r.validation_status IN (' . $placeholders . ')';
            foreach ($filters['status'] as $i => $status) {
                $params[':status_' . $i] = $status;
            }
        }

        //Filtre par note
        if (!empty($filters['rate'])) {
            $placeholders = implode(',', array_map(fn($i) => ':rate_' . $i, array_keys($filters['rate'])));
            $conditions[] = 'r.rating IN (' . $placeholders . ')';
            foreach ($filters['rate'] as $i => $rate) {
                $params[':rate_' . $i] = (int) $rate;
            }
        }

        //Filtre par date
        if (!empty($filters['date_from'])) {
            $conditions[] = 'r.reviewed_at >= :date_from ';
            $params[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $conditions[] = 'r.reviewed_at <= :date_to ';
            $params[':date_to'] = $filters['date_to'];
        }


        $where = !empty($conditions)
            ? 'WHERE ' . implode(' AND ', $conditions) 
            : '' ;

        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total 
            FROM review r
            JOIN customer_order co ON r.order_id = co.order_id
            JOIN user u ON r.user_id = u.user_id
            $where
        ");
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $type);
        }

        $stmt->execute();
        return (int) $stmt->fetch()['total'];
    }

    public function getByOrderId(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                r.review_id,
                r.rating,
                r.comment,
                r.validation_status,
                r.reviewed_at,
                r.order_id,
                r.user_id,
                u.last_name,
                u.first_name
            FROM review r
            JOIN customer_order o ON r.order_id = o.order_id
            JOIN user u ON r.user_id = u.user_id
            WHERE r.order_id = :order_id
            ORDER BY reviewed_at ASC
        ");

        $stmt->execute([
            ':order_id' => $id
        ]);

        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getAllValidated(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                r.review_id,
                r.rating,
                r.comment,
                r.validation_status,
                r.reviewed_at,
                r.order_id,
                r.user_id,
                u.last_name,
                u.first_name,
                co.menu_id
            FROM review r
            JOIN customer_order co ON r.order_id = co.order_id
            JOIN user u ON r.user_id = u.user_id
            WHERE r.validation_status = 'validated'
            ORDER BY reviewed_at DESC
            LIMIT 3
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createReview(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO review (
                rating,
                comment,
                order_id,
                user_id
            ) VALUES (
                :rating,
                :comment,
                :order_id,
                :user_id
            )
        ");

        $stmt->execute([
            ':rating' => $data['rating'],
            ':comment' => $data['comment'],
            ':order_id' => $data['order_id'],
            ':user_id' => $data['user_id']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function validateReview(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE review SET
                validation_status = 'validated',
                reviewed_at = CURRENT_TIMESTAMP
            WHERE review_id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function refuseReview(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE review SET
                validation_status = 'refused',
                reviewed_at = CURRENT_TIMESTAMP
            WHERE review_id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    //Fonctions utilitaires
    public function formatDiffDate(string $date): string
    {
        $diff = date_diff(date_create($date), date_create('now'));

        if ($diff->days === 0)   return "Aujourd'hui";
        if ($diff->days === 1)   return "Hier";
        if ($diff->days < 30)    return $diff->days . ' jours';
        if ($diff->m < 12)  return $diff->m . ' mois';

        return $diff->y . ' an(s)';
    }
}