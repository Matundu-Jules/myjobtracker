<?php
require_once __DIR__ . '/../src/core/database.php';

$sql = "
CREATE TABLE IF NOT EXISTS candidatures (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_title VARCHAR(255) NOT NULL,
  company VARCHAR(255) NOT NULL,
  application_date DATE NOT NULL,
  reply_date DATE DEFAULT NULL,
  application_status ENUM('not_sent', 'sent', 'pending', 'rejected', 'interview', 'offer') NOT NULL DEFAULT 'not_sent',
  offer_link TEXT,
  offer_content TEXT,
  location VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
  $pdo->exec($sql);
  echo "✅ Table 'candidatures' created successfully.";
} catch (PDOException $e) {
  echo "❌ Error creating table: " . $e->getMessage();
}
