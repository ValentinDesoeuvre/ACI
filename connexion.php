<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link href="bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" rel="stylesheet">
</head>
    <style>
    body {
        background-image: url(ressources/Fond%20-%20Connexion.svg);
        background-size: cover;
        background-position: bottom;
        }</style>




<body class="container col-12 vh-100 d-flex justify-content-center">
    <form class="row col-8 col-md-4 col-lg-3 p-0 my-auto" method="post" action="connexion.php">
        <h1 class="mx-auto text-center">CONNEXION</h1>
        <input class="col-12 col-push-3 col-pull-3 mb-3 py-1" type="text" name="login" placeholder="Pseudo" required/><br>
        <input class="col-12 mb-3 py-1" type="password" name="mdp" placeholder="Mot de passe" required/><br>
        <button class="bouton col-6 mx-auto" id="submit" type="submit" value="Connexion">Valider</button>
	</form>



    <?php 
        // Ouverture de la session
        session_start();        

        // Connection à la BDD ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
        $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
        $bdd->set_charset("utf8");
        
      
        // Si les champs login et mdp ne sont pas vides alors...
        if (isset($_POST['login']) && isset($_POST['mdp'])){
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];

            // Récupération de l'id et du mot de passe dans la base de données
            $requete_sql = $bdd->query("SELECT idUtilisateurs, mdp, ifAdmin FROM utilisateurs WHERE idUtilisateurs='$login'");
            $resultat = $requete_sql->fetch_assoc();

            // Si le mot de passe entré est le même que le mot de passe dans la base de données alors...
            if (password_verify($mdp, $resultat['mdp'])){                    
                $_SESSION["sessionACI_id"] = $login;
                $_SESSION["sessionACI_mdp"] = $resultat['idUtilisateurs'];
                $_SESSION["sessionACI_ifAdmin"] = $resultat['ifAdmin'];

                // Redirection vers la page accueil ou admin selon l'utilisateur
                if ($_SESSION["sessionACI_ifAdmin"]){
                    header('Location: admin.php');
                }
                else{
                    header('Location: accueil.php');
                }
                exit();
            }

            // Sinon message d'erreur
            else {
                echo "<script>alert('Login ou mot de passe incorrect.')</script>";
            }
        }


        // Déconnexion de la base de données
        $bdd -> close();
    ?>
    


    <!-- Scripts bootstrap -->
    <script src="bootstrap-4.3.1-dist/js/jquery.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</body>
</html>