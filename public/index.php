<?php
$currentPage = 'home';
require_once __DIR__ . '/../templates/header.php';
?>

<link rel="stylesheet" href="/assets/css/style.css">

<main class="home-container">
    <h1>Bienvenue sur <span class="highlight">MyJobTracker</span></h1>
    <p class="intro-text">Suivez toutes vos candidatures facilement grâce à une interface claire et intuitive.</p>

    <div class="card-menu">
        <a href="/form.php" class="menu-card">
            📄 Nouvelle candidature
        </a>
        <a href="/dashboard.php" class="menu-card">
            📊 Suivi des candidatures
        </a>
        <a href="#" class="menu-card disabled">
            🧠 IA (à venir)
        </a>
        <a href="#" class="menu-card disabled">
            📈 Statistiques (à venir)
        </a>
    </div>
</main>

<?php
require_once __DIR__ . '/../templates/footer.php';
?>