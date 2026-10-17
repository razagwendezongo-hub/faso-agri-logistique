# 🌾 FasoAgri-Logistique : Supply Chain & Traçabilité Agricole Intelligente

Plateforme web B2B conçue pour optimiser la chaîne d'approvisionnement, la traçabilité et la prévision des stocks de produits agricoles (mangues, oignons, céréales) en Afrique de l'Ouest (Burkina Faso).

## 📌 Le Contexte & Le Problème
En Afrique de l'Ouest, la chaîne d'approvisionnement entre les producteurs, les coopératives (régions de Banfora, Dédougou, etc.) et les marchés urbains souffre d'énormes pertes post-récolte. Cela est principalement dû à :
- Un manque de suivi en temps réel des volumes récoltés.
- L'absence de traçabilité claire entre acteurs B2B.
- Un déficit d'anticipation sur la péremption des produits frais (comme les mangues).

## 🚀 Fonctionnalités Clés de la Plateforme
1. **Enregistrement en Temps Réel (`index.html` & `enregistrer.php`) :** Interface dédiée aux coopératives pour déclarer leurs stocks de manière sécurisée dans une base de données relationnelle.
2. **Tableau de Bord & Module Prédictif (`dashboard.php`) :** Analyse algorithmique automatisée détectant les risques de gaspillage (ex: produits périssables dépassent le délai critique) et suggérant des actions logistiques.
3. **Espace Marché B2B (`acheteurs.php`) :** Vitrine interactive permettant aux acheteurs urbains de consulter les volumes disponibles et de réserver des lots en direct.
4. **Analytique & Export (`export_stats.php`) :** Calcul d'indicateurs globaux de rendement et génération de rapports logistiques exportables au format CSV.

## 🛠️ Stack Technologique
- **Front-end :** HTML5, CSS3 (Design moderne, épuré, responsive et orienté expérience utilisateur).
- **Back-end :** PHP (Traitement des formulaires, requêtes sécurisées et logique métier).
- **Base de données :** MySQL (Hébergé localement via l'environnement XAMPP).

## 📂 Organisation du Code Source
- `index.html` : Formulaire de déclaration des récoltes.
- `enregistrer.php` : Traitement de la connexion et insertion MySQL.
- `dashboard.php` : Affichage des stocks et alertes de prévision.
- `acheteurs.php` : Gestion des commandes et réservations B2B.
- `export_stats.php` : Statistiques globales et export CSV.
- `style.css` : Feuille de style globale de l'application.

## 👤 Auteur
Projet développé par **ZONGO Razagwende Alfred** dans le cadre du renforcement des compétences en développement web full-stack et gestion de projets logistiques.