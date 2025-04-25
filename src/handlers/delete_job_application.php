<?php
session_start();
require_once __DIR__ . '/../core/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        $_SESSION['flash_error'] = "❌ ID invalide.";
        header("Location: /dashboard.php");
        exit;
    }

    try {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("DELETE FROM candidatures WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $_SESSION['flash_success'] = "🗑️ Candidature supprimée avec succès.";
    } catch (PDOException $e) {
        error_log("❌ Delete error: " . $e->getMessage());
        $_SESSION['flash_error'] = "❌ Erreur lors de la suppression.";
    }

    header("Location: /dashboard.php");
    exit;
} else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}
