<?php
// form.php (located in the 'views' folder)
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter une candidature</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <div class="container">
    <h1>Ajouter une candidature</h1>
    <form action="/post_application.php" method="POST" class="job-application-form">

      <label for="job_title">Intitulé du poste</label>
      <input type="text" id="job_title" name="job_title" class="form-input" required>

      <label for="company">Nom de la société</label>
      <input type="text" id="company" name="company" class="form-input" required>

      <label for="application_date">Date de candidature</label>
      <input type="date" id="application_date" name="application_date" class="form-input" required>

      <label for="reply_date">Date du 1er retour</label>
      <input type="date" id="reply_date" name="reply_date" class="form-input">

      <label for="application_status">Statut de la candidature</label>
      <select id="application_status" name="application_status" class="form-input" required>
        <option value="not_sent">Non envoyée</option>
        <option value="sent">Envoyée</option>
        <option value="pending">En attente de réponse</option>
        <option value="rejected">Rejetée</option>
        <option value="interview">Entretien</option>
        <option value="offer">Offre reçue</option>
      </select>

      <label for="offer_link">Lien de l'offre</label>
      <input type="url" id="offer_link" name="offer_link" class="form-input">

      <label for="offer_content">Contenu de l'offre (copié/collé)</label>
      <textarea id="offer_content" name="offer_content" class="form-textarea"></textarea>

      <label for="location">Lieu du poste</label>
      <input type="text" id="location" name="location" class="form-input">

      <button type="submit" class="form-button">Enregistrer</button>
    </form>
  </div>
</body>

</html>