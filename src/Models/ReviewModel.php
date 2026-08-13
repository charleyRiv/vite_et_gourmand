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
            JOIN order o ON r.order_id = o.order_id
            JOIN user u ON r.user_id = u_user_id
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

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("
            UPDATE review SET
                validation_status = :status,
                reviewed_at = CURRENT_TIMESTAMP
            WHERE review_id = :id
        ");

        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
}