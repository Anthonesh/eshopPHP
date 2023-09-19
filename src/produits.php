<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Produits</title>
</head>
<body>
<header>
        <h1>E-choppe</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="#">Produits</a></li>
                <li><a href="panier.php">Panier</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

<main>

<?php

include 'connect.php';

function ajouterAuPanier($produit) {
    global $db;
    
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    
    $_SESSION['panier'][] = $produit;

    
    $produit_id = $produit['produit_id'];
    $affiche_produit = $produit ['affiche_produit'];
    $name_produit = $produit['name_produit'];
    $prix_produit = $produit['prix_produit'];
    $qte_stock_produit = $produit['qte_stock_produit'];

    $stmt = $db->prepare("INSERT INTO panier (produit_id, name_panier, prix_panier, qte_stock_panier) VALUES (?, ?, ?, ?)");
    $stmt =([$produit_id, $affiche_produit, $name_produit, $prix_produit, $qte_stock_produit]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $produit_id = $_POST['produit_id'];
    $affiche_produit = $_POST ['affiche_produit'];
    $name_produit = $_POST['name_produit'];
    $prix_produit = $_POST['prix_produit'];
    $qte_stock_produit = $_POST['qte_stock_produit'];

    ajouterAuPanier(array(
        'produit_id' => $produit_id,
        'affiche_produit' => $affiche_produit,
        'name_produit' => $name_produit,
        'prix_produit' => $prix_produit,
        'qte_stock_produit' => $qte_stock_produit,
    ));
}

while ($product = $selectProducts->fetch(PDO::FETCH_ASSOC)) {

    echo '<section class="product">';
    echo '<img src="../imgs/' . $product['affiche_produit'] . '" alt="' . $product['affiche_produit'] . '">';
    echo '<h2>' . $product['name_produit'] . '</h2>';
    echo '<p>' . $product['description_produit'] . '</p>';
    echo '<p>Prix : $' . $product['prix_produit'] . '</p>';
    echo '<p>Quantité en stock :' . $product['qte_stock_produit'] . '</p>';
    echo '<form method="POST" action="produits.php">';
    echo '<input type="hidden" name="produit_id" value="' . $product['id_produit'] . '">';
    echo '<input type="hidden" name="name_produit" value="' . $product['name_produit'] . '">';
    echo '<input type="hidden" name="affiche_produit" value="' . $product['affiche_produit'] . '">';
    echo '<input type="hidden" name="prix_produit" value="' . $product['prix_produit'] . '">';
    echo '<input type="hidden" name="qte_stock_produit" value="' . $product['qte_stock_produit'] . '">';
    echo '<button type="submit" name="ajouter">Ajouter au Panier</button>';
    echo '</form>';
    echo '</section>';
}

?>
    </main>

    <footer>
        <p>&copy; 2023 Mon Site E-Commerce</p>
    </footer>

</body>
</html>