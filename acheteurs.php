<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "faso_agri_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Traitement de la commande B2B
$message_confirmation = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['commander'])) {
    $recolte_id = intval($_POST['recolte_id']);
    $acheteur_nom = $conn->real_escape_string($_POST['acheteur_nom']);
    $quantite_commandee = floatval($_POST['quantite_commandee']);
    $statut_commande = "Confirmée";

    $sql_cmd = "INSERT INTO commandes_b2b (recolte_id, acheteur_nom, quantite_commandee, statut_commande) 
                VALUES ('$recolte_id', '$acheteur_nom', '$quantite_commandee', '$statut_commande')";
    if ($conn->query($sql_cmd) === TRUE) {
        $message_confirmation = "✅ Commande B2B enregistrée avec succès ! Stock réservé.";
    } else {
        $message_confirmation = "❌ Erreur lors de la commande : " . $conn->error;
    }
}

// Récupérer les récoltes disponibles
$sql = "SELECT r.*, c.nom_cooperative, c.region FROM recoltes r JOIN cooperatives c ON r.cooperative_id = c.id WHERE r.statut = 'Disponible'";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#1b4332">
<title>FasoAgri-Logistique - Espace Acheteurs B2B</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main>
  <header>
    <div class="logo">🌾 FasoAgri-Logistique</div>
    <div class="badge-pro">ESPACE MARCHÉ B2B</div>
  </header>

  <?php if (!empty($message_confirmation)): ?>
    <div class="alert-success"><?php echo $message_confirmation; ?></div>
  <?php endif; ?>

  <section>
    <h2>🛒 Stocks Disponibles & Commandes en Ligne</h2>
    <p style="font-size:0.85rem;color:var(--mute);">Réservez directement les volumes auprès des coopératives agricoles.</p>
    
    <div style="overflow-x:auto;">
      <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:0.9rem;">
        <thead>
          <tr style="border-bottom:1px solid var(--line); text-align:left; color:var(--mute);">
            <th style="padding:8px;">Coopérative (Région)</th>
            <th style="padding:8px;">Produit</th>
            <th style="padding:8px;">Qté Dispo</th>
            <th style="padding:8px;">Action / Réserver</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && $result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr style='border-bottom:1px solid var(--line);'>";
                  echo "<td style='padding:8px;'>" . htmlspecialchars($row['nom_cooperative']) . " (" . htmlspecialchars($row['region']) . ")</td>";
                  echo "<td style='padding:8px;'>" . htmlspecialchars($row['produit']) . "</td>";
                  echo "<td style='padding:8px;'>" . number_format($row['quantite_kg'], 0, ',', ' ') . " Kg</td>";
                  echo "<td style='padding:8px;'>";
                  echo "<form action='acheteurs.php' method='POST' style='display:flex; gap:6px;'>";
                  echo "<input type='hidden' name='recolte_id' value='" . $row['id'] . "'>";
                  echo "<input type='text' name='acheteur_nom' placeholder='Votre Nom/Société' required style='padding:6px; font-size:0.8rem;'>";
                  echo "<input type='number' name='quantite_commandee' placeholder='Qté (Kg)' max='" . $row['quantite_kg'] . "' required style='width:90px; padding:6px; font-size:0.8rem;'>";
                  echo "<button type='submit' name='commander' class='go' style='margin-top:0; padding:6px 12px; font-size:0.8rem;'>Réserver</button>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='4' style='padding:12px; text-align:center; color:var(--mute);'>Aucun stock disponible pour le moment.</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>

    <div style="margin-top:20px; text-align:center; display:flex; justify-content:center; gap:20px;">
      <a href="dashboard.php" style="color:var(--accent); text-decoration:none; font-weight:600; font-size:0.9rem;">📊 Tableau de bord</a>
      <a href="index.html" style="color:var(--accent); text-decoration:none; font-weight:600; font-size:0.9rem;">📦 Saisir une récolte</a>
    </div>
  </section>
</main>
</body>
</html>