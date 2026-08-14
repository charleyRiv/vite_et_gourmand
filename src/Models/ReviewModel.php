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

    public function getByOrderId(int $id): array
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
            JOIN order o ON r.order_id = o.order_id
            JOIN user u ON r.user_id = u_user_id
            WHERE r.order_id = :order_id
            ORDER BY reviewed_at ASC
        ");

        $stmt->execute([
            ':order_id' => $id
        ]);

        return $stmt->fetch();
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
}