<?php
require_once('../../ressources/includes/connexion-bdd.php');

$listeMessagesCommande = $clientMySQL->prepare('SELECT * FROM message');
$listeMessagesCommande->execute();
$listeMessages = $listeMessagesCommande->fetchAll();

$pageCourante = "messages";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>

    <!-- ajout d'un favicon --> 
    <link rel="shortcut icon" type="image/png" href="https://lptm.cyu.fr/uas/cylptm/FAVICON/favicon-LPTM_400x400px.png" alt="logo">
    
    <title>Liste messages - Administration</title>
</head>

<body>
    <div class="d-flex h-100">
        <?php include_once("../ressources/includes/menu-lateral.php"); ?>
        <div class="b-example-divider"></div>
        <main class="flex-fill">
            <header class="d-flex justify-content-between align-items-center p-3">
                <p class="fs-1">Liste messages reçus</p>
            </header>

            <table class="table align-middle table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Adresse email</th>
                        <th scope="col">Message</th>
                        <th scope="col">Situation</th>
                        <th scope="col">Date</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($listeMessages as $message) { 
                    ?>
                        <tr>
                            <td scope='row'><?php echo $message["id"]; ?></td>
                            <td><?php echo $message["nom"]; ?></td>
                            <td><?php echo $message["prenom"]; ?></td>
                            <td><?php echo $message["email"]; ?></td>
                            <td><?php echo $message["contenu"]; ?></td>
                            <td><?php echo $message["type"]; ?></td>
                            <td><?php echo $message["date_creation"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>