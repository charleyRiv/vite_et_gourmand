<?php

class ContactModel 
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllWithFilters(array $filters = []): array
    {
        $conditions = [];
        $params     = [];

        if (!empty($filters['date_from'])) {
            $conditions[] = 'sent_at >= :date_from';
            $params[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $conditions[] = 'sent_at <= :date_to';
            $params[':date_to'] = $filters['date_to'] . ' 23:59:59';
        }

        $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        
        $stmt = $this->db->prepare("
        SELECT
            message_id,
            title,
            description,
            sender_email,
            sent_at
        FROM message_contact
        $where
        ORDER BY sent_at DESC
        ");

        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array
    {
        $stmt = $this->db->prepare("
        SELECT
            message_id,
            title,
            description,
            sender_email,
            sent_at
        FROM message_contact
        WHERE message_id = :id
        ");

        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function send(array $data): int
    {
        $stmt = $this->db->prepare("
        INSERT INTO message_contact (
            title,
            description,
            sender_email,
            sent_at
        )
        VALUES(
            :title,
            :description,
            :sender_email,
            CURRENT_TIMESTAMP
        )
        ");

        $stmt->execute([
                ':title' => $data['title'],
                ':description' => $data['content'],
                ':sender_email' => $data['email']
            ]
        );
        return (int) $this->db->lastInsertId();
    }
}