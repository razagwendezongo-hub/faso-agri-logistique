<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "faso_agri_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Gestion de l'export CSV si demandé
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=recoltes_faso_agri.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'Cooperative', 'Region', 'Produit', 'Quantite (Kg)', 'Date Recolte', 'Statut'));
    
    $query = "SELECT r.*, c.nom_cooperative, c.region FROM recoltes r JOIN cooperatives c ON r.cooperative_id = c.id";
    $res = $conn->query($query);
    while ($row = $res->fetch_assoc()) {
        fputcsv($output, array($row['id'], $row['nom_cooperative'], $row['region'], $row['produit'], $row['quantite_kg'], $row['date_recolte'], $row['statut']));
    }
    fclose($output);
    exit();
}

// Calcul des indicateurs globaux
$total_volume = $conn->query("SELECT SUM(quantite_kg) as total FROM recoltes")->fetch_assoc()['total'] ?? 0;
$total_recoltes = $conn->query("SELECT COUNT(*) as total FROM recoltes")->fetch_assoc()['total'] ?? 0;
$top_produit = $conn->query("SELECT produit, SUM(quantite_kg) as somme FROM recoltes GROUP BY produit ORDER BY somme DESC LIMIT 1")->fetch_assoc();
$conn->close();
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#1b4332">
<title>FasoAgri-Logistique - Statistiques & Export</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main>
  <header>
    <div class="logo">🌾 FasoAgri-Logistique</div>
    <div class="badge-pro">ANALYSE & EXPORT</div>
  </header>

  <section>
    <h2>📈 Indicateurs Globaux de la Supply Chain</h2>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-bottom:20px;">
      <div style="background:var(--bg); padding:14px; border-radius:8px; border:1px solid var(--line);">
        <span style="font-size:0.8rem; color:var(--mute);">Volume Total Enregistré</span>
        <div style="font-size:1.4rem; font-weight:800; color:var(--accent);"><?php echo number_format($total_volume, 0, ',', ' '); ?> Kg</div>
      </div>
      <div style="background:var(--bg); padding:14px; border-radius:8px; border:1px solid var(--line);">
        <span style="font-size:0.8rem; color:var(--mute);">Produit le Plus Récolté</span>
        <div style="font-size:1.1rem; font-weight:800; color:var(--ink);"><?php echo $top_produit ? htmlspecialchars($top_produit['produit']) : 'N/A'; ?></div>
      </div>
    </div>

    <div style="text-align:center; margin-top:20px;">
      <a href="export_stats.php?export=csv" class="go" style="display:inline-block; text-decoration:none; padding:12px 24px;">📥 Télécharger le rapport CSV complet</a>
    </div>

    <div style="margin-top:20px; text-align:center;">
      <a href="dashboard.php" style="color:var(--accent); text-decoration:none; font-weight:600; font-size:0.9rem;">&larr; Retour au tableau de bord</a>
    </div>
  </section>
</main>
</body>
</html>