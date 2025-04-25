<?php
// File: src/handlers/store_job_application.php
session_start();

require_once __DIR__ . '/../core/database.php';

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect form inputs with default fallback values
    $jobTitle       = trim($_POST['job_title'] ?? '');
    $company        = trim($_POST['company'] ?? '');
    $applicationDate = $_POST['application_date'] ?? null;
    $replyDate      = $_POST['reply_date'] ?? null;
    $status         = $_POST['application_status'] ?? 'not_sent';
    $offerLink      = trim($_POST['offer_link'] ?? '');
    $offerContent   = trim($_POST['offer_content'] ?? '');
    $location       = trim($_POST['location'] ?? '');

    // Check for required fields
    if (!$jobTitle || !$company || !$applicationDate || !$status) {
        echo '❌ Missing required fields.';
        exit;
    }

    // SQL query using named placeholders for secure data binding
    $sql = "INSERT INTO candidatures (
                job_title, company, application_date, reply_date, 
                application_status, offer_link, offer_content, location
            ) VALUES (
                :jobTitle, :company, :applicationDate, :replyDate, 
                :status, :offerLink, :offerContent, :location
            )";

    try {
        // Get the database connection using the new class
        $pdo = Database::getInstance()->getConnection();

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $pdo->prepare($sql);

        // Bind values and execute the query
        $data = [
            ':jobTitle'      => $jobTitle,
            ':company'       => $company,
            ':applicationDate' => $applicationDate,
            ':replyDate'     => $replyDate ?: null,
            ':status'        => $status,
            ':offerLink'     => $offerLink,
            ':offerContent'  => $offerContent,
            ':location'      => $location
        ];

        $stmt->execute($data);

        // Log safely for dev
        error_log("✅ New job application added: " . json_encode($data));

        // Success response
        echo "✅ Insert successful!";

        // Optionally, display a success message and redirect to a success page
        $_SESSION['flash_success'] = "✅ Candidature ajoutée avec succès !";

        // Redirige vers dashboard après 0 seconde (message affiché là-bas)
        header("Location: /dashboard.php");

        exit;
    } catch (PDOException $e) {
        error_log("❌ Database error: " . $e->getMessage());
        echo '❌ An error occurred while storing the application.';
        exit;
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}
