<?php
session_start();

require_once BASE_PATH . '/src/models/ApplicationModel.php';

$model = new ApplicationModel();
$applications = $model->getAllApplications();

// Récupérer et effacer le message flash
$flashMessage = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_success']);
?>

<link rel="stylesheet" href="/assets/css/style.css">

<section class="dashboard-container">
    <h1>Tableau de suivi des candidatures</h1>

    <?php if ($flashMessage): ?>
        <div class="flash-message"><?= htmlspecialchars($flashMessage) ?></div>

        <script>
            setTimeout(() => {
                document.querySelector('.flash-message')?.remove();
            }, 4000); // Cache le message après 4 secondes
        </script>
    <?php endif; ?>

    <input type="text" id="searchInput" placeholder="🔍 Rechercher un poste ou une entreprise..." class="search-bar">

    <div class="table-wrapper">
        <table id="applicationsTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Poste ⬍</th>
                    <th onclick="sortTable(1)">Entreprise ⬍</th>
                    <th onclick="sortTable(2)">Statut ⬍</th>
                    <th onclick="sortTable(3)">Date ⬍</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                    <tr>
                        <td data-label="Poste"><?= htmlspecialchars($app['job_title']) ?></td>
                        <td data-label="Entreprise"><?= htmlspecialchars($app['company']) ?></td>
                        <td data-label="Statut"><?= htmlspecialchars($app['application_status']) ?></td>
                        <td data-label="Date"><?= htmlspecialchars(date('d/m/Y', strtotime($app['created_at']))) ?></td>
                        <td data-label="Actions">
                            <!-- Future buttons -->
                            <button class="action-btn">✏️</button>
                            <button class="action-btn">🗑️</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    // Filtrage simple
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#applicationsTable tbody tr");

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Tri de colonnes
    function sortTable(colIndex) {
        const table = document.getElementById("applicationsTable");
        const rows = Array.from(table.rows).slice(1); // skip thead
        const ascending = table.getAttribute("data-sort-dir") !== "asc";
        rows.sort((a, b) => {
            const valA = a.cells[colIndex].textContent.trim().toLowerCase();
            const valB = b.cells[colIndex].textContent.trim().toLowerCase();
            return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });
        rows.forEach(row => table.tBodies[0].appendChild(row));
        table.setAttribute("data-sort-dir", ascending ? "asc" : "desc");
    }
</script>