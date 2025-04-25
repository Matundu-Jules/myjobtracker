<?php
session_start();

require_once BASE_PATH . '/src/models/ApplicationModel.php';

$model = new ApplicationModel();
$applications = $model->getAllApplications();

$flashMessage = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_success']);

$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_error']);

$statusLabels = [
    'not_sent' => 'Non envoyée',
    'sent' => 'Envoyée',
    'pending' => 'En attente de réponse',
    'rejected' => 'Rejetée',
    'interview' => 'Entretien',
    'offer' => 'Offre reçue',
];
?>

<link rel="stylesheet" href="/assets/css/style.css">

<section class="dashboard-container">
    <!-- <h1>Tableau de suivi des candidatures</h1> -->

    <?php if ($flashMessage): ?>
        <div class="flash-message success"><?= htmlspecialchars($flashMessage) ?></div>
        <script>
            setTimeout(() => {
                document.querySelector('.flash-message')?.remove();
            }, 4000);
        </script>
    <?php endif; ?>

    <?php if ($flashError): ?>
        <div class="flash-message error"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

    <input type="text" id="searchInput" placeholder="🔍 Rechercher un poste ou une entreprise..." class="search-bar">

    <div class="table-wrapper">
        <table id="applicationsTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Poste ⬍</th>
                    <th onclick="sortTable(1)">Lieu ⬍</th>
                    <th onclick="sortTable(2)">Lien ⬍</th>
                    <th onclick="sortTable(3)">Statut ⬍</th>
                    <th onclick="sortTable(4)">Date d'envoi ⬍</th>
                    <th onclick="sortTable(5)">Date de réponse ⬍</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                    <tr>
                        <td data-label="Poste" class="editable" data-id="<?= (int)$app['id'] ?>" data-field="job_title">
                            <?= htmlspecialchars($app['job_title']) ?>
                        </td>
                        <td data-label="Lieu" class="editable" data-id="<?= (int)$app['id'] ?>" data-field="location">
                            <?= htmlspecialchars($app['location']) ?>
                        </td>
                        <td data-label="Lien" class="editable" data-id="<?= (int)$app['id'] ?>" data-field="offer_link">
                            <span class="editable-link" title="Double-cliquez pour modifier">
                                <?php if (!empty($app['offer_link']) && filter_var($app['offer_link'], FILTER_VALIDATE_URL)): ?>
                                    <a href="<?= htmlspecialchars($app['offer_link']) ?>" target="_blank" style="display:inline-block; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        <?= htmlspecialchars($app['offer_link']) ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999;">Lien invalide</span>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td data-label="Statut" class="editable" data-id="<?= (int)$app['id'] ?>" data-field="application_status">
                            <?= $statusLabels[$app['application_status']] ?? htmlspecialchars($app['application_status']) ?>
                        </td>
                        <td data-label="Date d'envoi" class="editable" data-id="<?= (int)$app['id'] ?>" data-field="application_date">
                            <?= $app['application_date'] ? htmlspecialchars(date('d/m/Y', strtotime($app['application_date']))) : '-' ?>
                        </td>
                        <td data-label="Date de réponse" class="editable" data-id="<?= (int)$app['id'] ?>" data-field="reply_date">
                            <?= $app['reply_date'] ? htmlspecialchars(date('d/m/Y', strtotime($app['reply_date']))) : '-' ?>
                        </td>
                        <td data-label="Actions">
                            <form method="POST" action="/delete_application.php" style="display:inline;" onsubmit="return confirm('Supprimer cette candidature ?');">
                                <input type="hidden" name="id" value="<?= (int)$app['id'] ?>">
                                <button type="submit" class="action-btn delete-btn">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<div id="toast" class="toast hidden"></div>


<script src="/assets/js/dashboard.js"></script>