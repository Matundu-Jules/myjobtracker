<?php
// src/models/ApplicationModel.php

require_once __DIR__ . '/../core/database.php';

class ApplicationModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllApplications(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM candidatures ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
