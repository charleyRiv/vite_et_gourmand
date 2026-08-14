<?php

class ContentModel
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
                content_id,
                page,
                section,
                content,
                updated_at
            FROM page_content
            ORDER BY page ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByFilter(?string $page ,?string $section): ?array
    {
        $conditions = [];
        $params = [];

        if ($page !== null) {
            $conditions[] = 'page = :page';
            $params[':page'] = $page;
        }

        if ($section !== null) {
            $conditions[] = 'section = :section';
            $params[':section'] = $section;
        }

        $where = !empty($conditions)
            ? 'WHERE ' . implode(' AND ', $conditions)
            : '';


        $stmt = $this->db->prepare("
            SELECT
                content_id,
                page,
                section,
                content,
                updated_at
            FROM page_content
            $where
            ORDER BY page ASC
        ");

        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function createContent(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO page_content(
                page,
                section,
                content,
                updated_at
            )
            VALUES(
                :page,
                :section,
                :content,
                CURRENT_TIMESTAMP
            )
        ");

        $stmt->execute([
            ':page' => $data['page'],
            ':section' => $data['section'],
            ':content' => $data['content']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateContent(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE page_content SET
                content = :content,
                updated_at = CURRENT_TIMESTAMP
            WHERE content_id = :id
        ");

        return $stmt->execute([
            ':content' => $data['content'],
            ':id' => $id
        ]);
    }

    public function deleteContent(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM page_content
            WHERE content_id = :id
        ");

        return $stmt->execute([':id' => $id]);
    }
}