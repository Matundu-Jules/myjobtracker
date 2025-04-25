<?php
session_start();
require_once __DIR__ . '/../core/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $field = $data['field'] ?? null;
    $value = $data['value'] ?? null;

    // Security: check allowed fields
    $allowedFields = [
        'job_title',
        'company',
        'location',
        'offer_link',
        'application_status',
        'application_date',
        'reply_date'
    ];

    if (!$id || !$field || !$value || !in_array($field, $allowedFields)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
        exit;
    }

    try {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE candidatures SET {$field} = :value WHERE id = :id");
        $stmt->execute([
            ':value' => $value,
            ':id' => (int)$id
        ]);

        echo json_encode(['success' => true]);
        exit;
    } catch (PDOException $e) {
        error_log("Update error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error.']);
        exit;
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}
