<?php
// Paramètres de connexion MySQL (XAMPP par défaut)
$host = "localhost";
$user = "root";
$password = "";
$dbname = "faso_agri_db";

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cooperative_id = intval($_POST['cooperative_id']);
    $produit = $conn->real_escape_string($_POST['produit']);
    $quantite_kg = floatval($_POST['quantite_kg']);
    $date_recolte = $conn->real_escape_string($_POST['date_recolte']);
    $statut = "Disponible";

    // Insertion sécurisée dans la table 'recoltes'
    $sql = "INSERT INTO recoltes (cooperative_id, produit, quantite_kg, date_recolte, statut) 
            VALUES ('$cooperative_id', '$produit', '$quantite_kg', '$date_recolte', '$statut')";

    if ($conn->query(TP_QUERY_SUCCESS_CHECK = TRUE) === TRUE) {
        // Redirection avec un message de succès
        header("Location: index.html?success=1");
        exit();
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>