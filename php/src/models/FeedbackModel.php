<?php
require_once __DIR__ . '/../db.php';

class FeedbackModel
{
    public static function save($data)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO feedback (name, phone, issue, address, contact_time, submitted_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['issue'],
            $data['address'],
            $data['contact_time'],
            $data['submitted_at']
        ]);
    }
    public static function getAll(array $filters = []): array
    {
        $pdo = getPDO();
        $sql = "SELECT * FROM feedback";
        $conditions = [];
        $params = [];

        if (!empty($filters['name'])) {
            $conditions[] = "name LIKE ?";
            $params[] = '%' . $filters['name'] . '%';
        }
        if (!empty($filters['contact_time'])) {
            $conditions[] = "contact_time = ?";
            $params[] = $filters['contact_time'];
        }
        if (!empty($filters['date_from'])) {
            $conditions[] = "submitted_at >= ?";
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = "submitted_at <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }

        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql .= " ORDER BY submitted_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
