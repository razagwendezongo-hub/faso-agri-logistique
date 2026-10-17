<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "faso_agri_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT r.*, c.nom_cooperative, c.region FROM recoltes r JOIN cooperatives c ON r.cooperative_id = c.id ORDER BY r.date_recolte DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#1b4332">
<title>FasoAgri-Logistique - Tableau de Bord & Prévisions</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main>
  <header>
    <div class="logo">🌾 FasoAgri-Logistique</div>
    <div class="badge-pro">TABLEAU DE BORD</div>
  </header>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert-success">✅ Récolte enregistrée avec succès dans la base MySQL !</div>
  <?php endif; ?>

  <section>
    <h2>📊 Suivi des Stocks & Analyse Prédictive</h2>
    <p style="font-size:0.85rem;color:var(--mute);">Évaluation en temps réel des rendements et des risques de gaspillage.</p>
    
    <div style="overflow-x:auto;">
      <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:0.9rem;">
        <thead>
          <tr style="border-bottom:1px solid var(--line); text-align:left; color:var(--mute);">
            <th style="padding:8px;">Coopérative</th>
            <th style="padding:8px;">Produit</th>
            <th style="padding:8px;">Quantité</th>
            <th style="padding:8px;">Date</th>
            <th style="padding:8px;">Prévision / Alerte</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && $result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $produit = $row['produit'];
                  $qte = $row['quantite_kg'];
                  $date_recolte = new DateTime($row['date_recolte']);
                  $aujourdhui = new DateTime();
                  $intervalle = $aujourdhui->diff($date_recolte)->days;

                  $alerte = "🟢 Stock Stable";
                  $style_alerte = "color: #22c55e;";

                  if ($produit == "Mangues Fraîches" && $intervalle > 5) {
                      $alerte = "⚠️ Risque de Perte (Périssable)";
                      $style_alerte = "color: #ef4444;";
                  } elseif ($qte > 2000) {
                      $alerte = "📈 Fort Volume - B2B Requis";
                      $style_alerte = "color: #3b82f6;";
                  }

                  echo "<tr style='border-bottom:1px solid var(--line);'>";
                  echo "<td style='padding:8px;'>" . htmlspecialchars($row['nom_cooperative']) . "</td>";
                  echo "<td style='padding:8px;'>" . htmlspecialchars($produit) . "</td>";
                  echo "<td style='padding:8px;'>" . number_format($qte, 0, ',', ' ') . " Kg</td>";
                  echo "<td style='padding:8px;'>" . $row['date_recolte'] . "</td>";
                  echo "<td style='padding:8px; font-weight:600; $style_alerte'>$alerte</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5' style='padding:12px; text-align:center; color:var(--mute);'>Aucune récolte enregistrée.</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>

    <div style="margin-top:20px; text-align:center;">
      <a href="index.html" style="color:var(--accent); text-decoration:none; font-weight:600; font-size:0.9rem;">&larr; Enregistrer une nouvelle récolte</a>
    </div>
  </section>
</main>
</body>
</html>