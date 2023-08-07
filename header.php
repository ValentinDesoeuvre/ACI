<body>
    <header class="row mx-auto col-8 justify-content-around align-items-center">    
        <h1>AACI</h1>
        <p>
            <?php
            // Ouverture de la session
            session_start();
            

            // Connection à la BDD 
            // ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
            $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
            $bdd->set_charset("utf8");

            
            // Si l'utilisateur n'est pas connecté => redirection vers la page de connexion
            if (!isset($_SESSION["sessionACI_id"])){
                header("Location: connexion.php");
            }


            // Affiche l'id utilisateur dans le p
            $idUtilisateur = $_SESSION["sessionACI_id"];
            echo "<p>" . $idUtilisateur . "</p>";
            ?>
        </p>
        <a href="deconnexion.php"><button>Déconnexion</button></a>
    </header>