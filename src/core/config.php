<?php
require_once __DIR__ . '/env_loader.php';
loadEnv(__DIR__ . '/../../.env');

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('BASE_PATH', dirname(__DIR__, 2)); // remonte à la racine du projet