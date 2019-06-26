<?php

require 'PDO.php';

if (!empty($_POST)) {
    

    $bdd = new PDO('mysql:host=localhost;dbname=ecommerce;charset=utf8;port=8889', 'root', 'root');

    $request = 'INSERT INTO produit (titre, adresse_vendeur, ville_vendeur, cp_vendeur, prix, photo, type, description)
                VALUES (:titre, :adresse_vendeur, :ville_vendeur, :cp_vendeur, :prix, :photo, :type, :description)';

    $ajoutproduit = $bdd->prepare($request);

    $response = $ajoutproduit->execute([
        'titre'             => $_POST['titre'],
        'adresse_vendeur'   => $_POST['adresse_vendeur'],
        'ville_vendeur'     => $_POST['ville_vendeur'],
        'cp_vendeur'        => $_POST['cp_vendeur'],
        'prix'              => $_POST['prix'],
        'photo'             => $_POST['photo']['name'],
        'type'              => $_POST['type'],
        'description'       => $_POST['description'],

    ]);   
}

preg_match("/^(\d{5})$/", $_POST['cp_vendeur'], $codepostal, PREG_OFFSET_CAPTURE);
if (isset($_POST['cp_vendeur']) === 1) {
    if (count($codepostal) === 0 ) 
    {   throw new Exception('Le code postal est invalide.');
        echo "Le code postal est invalide"; }
} 

if (isset($_POST['prix']) === 1) {
    if(!is_int($_POST['Prix']) === 1) {
    throw new Exception('Le prix est invalide.');
    echo "Le prix est invalide";
    }
}

if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0) 
{
if ($_FILES['photo']['size'] <= 1000000)
    {
        $infosfichier = pathinfo($_FILES['photo']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
        
        if (in_array($extension_upload, $extensions_autorisees))

            {
            // On peut valider le fichier et le stocker définitivement
            move_uploaded_file($_FILES['photo']['tmp_name'], 
            'uploads/' . basename($_FILES['photo']['name']));
            echo "Le produit a été bien enregistré";
            }
        }
    }
?>

<!-- // PARTIE HTML -->

<?php include ('Partials/Header.php'); ?>

<form action="Ajout-Produit.php" method="post" class="form mt-3" enctype="multipart/form-data">

    <!-- Nom du produit -->
    <div class="form-group">
        <label for="">Nom du produit</label>
        <input type="text" name="titre" class="form-control">
    </div>

    <!-- PRIX -->
    <div class="form-group">
        <label for="">PRIX</label>
        <input type="text" name="prix" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Description du produit</label><br>
        <textarea name="description" cols="40" rows="10" class="form-group" ></textarea>
    </div>

    <!-- Type d'achat -->
    <div class="form-group">
        <input type="radio" name="type"><label for="">Enchère</label>
        <input type="radio" name="type"><label for="">Vente</label>

    </div>

    <!-- Adresse du vendeur -->
    <div class="form-group">
    <label for="">Adresse du vendeur</label>
    <input type="text" name="adresse_vendeur" class="form-control">
    </div>

    <!-- Ville du vendeur -->
    <div class="form-group">
        <label for="">Ville du vendeur</label>
        <input type="text" name="ville_vendeur" class="form-control">
    </div>

    <!-- Code postal du vendeur -->

    <div class="form-group">
        <label for="">Code postal du vendeur</label>
        <input type="text" name="cp_vendeur" class="form-control">
    </div>

    <!-- PHOTO PRODUIT -->

    <div>
        <label for="content">Envoyer la photo</label><br>
        <input type="file" name="photo" class="btn btn-info float-left" /><br />
    </div>


    <button class="btn btn-danger float-right">Ajouter un produit</button>
       


</form>

<?php include ('Partials/footer.php'); ?>

