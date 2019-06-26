<?php

$bdd = new PDO('mysql:host=localhost;dbname=ecommerce;charset=utf8;port=8889', 'root', 'root');
$request = 'SELECT 
            id,
            titre,
            adresse_vendeur,
            ville_vendeur,
            cp_vendeur,
            prix,
            photo,
            type,
            description
            FROM produit';
$response = $bdd->query($request);

$produits = $response->fetchAll(PDO::FETCH_ASSOC);



?>
<?php include ('partials/Header.php'); ?>

    <table class="table">
        <thead>
            <tr>
                <th>photo</th>
                <th>Référence</th>
                <th>Nom du produit</th>
                <th>Nature du produit</th>
                <th>Prix</th>
                <th>Vendeur</th>
                <th>Adresse du vendeur</th>
                <th>Code postal du vendeur</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($produits as $produit) : ?>
                <tr>
                    <td><img src= "uploads/<?= basename($_FILES['picture']['name']) . $extension_upload ?>" alt="picture"></td>
                    <td><?= $media['id'] ?></td>
                    <td><?= $media['titre'] ?></td>
                    <td><?= $media['type'] ?></td>
                    <td><?= $media['prix'] ?></td>
                    <td><?= $media['adresse_vendeur'] ?></td>
                    <td><?= $media['ville_vendeur'] ?></td>
                    <td><?= $media['cp_vendeur'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<?php include ('partials/Footer.php'); ?>