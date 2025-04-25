<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MyJobTracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <header class="site-header">
        <div class="logo">
            <a href="/index.php">💼 MyJobTracker</a>
        </div>
        <nav class="nav-menu">
            <a href="/index.php" class="<?= ($currentPage ?? '') === 'home' ? 'active' : '' ?>">Accueil</a>
            <a href="/form.php" class="<?= ($currentPage ?? '') === 'form' ? 'active' : '' ?>">Ajouter une entrée</a>
            <a href="/dashboard.php" class="<?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">Tableau de bord</a>
        </nav>
    </header>

    <main class="main-content">