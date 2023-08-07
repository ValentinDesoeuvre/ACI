<?php
include "head.php";
include "header.php";
if (!$_SESSION["sessionACI_ifAdmin"]){
    header("Location: connexion.php");
}
?>


<div class="container admin">

    <!-- AFFICHER LES RESULTATS SELON L'ID https://www.w3schools.com/pHP/php_ajax_php.asp -->
    <div>
        <!-- Choix de l'idDetenu -->
        <form class="input-group mb-3" method="post" action ="admin.php">
            <input type="text" required name="idUtilisateur" onkeyup="afficheResultats(this.value)" placeholder="Notez un id utilisateur pour voir son avancement">
            <button type="submit">Afficher les résultats</button>
        </form>

        <div id="resultatsDetenu">
            <?php
            if(isset($_POST["idUtilisateur"])){
                $idUtilisateur = $_POST["idUtilisateur"];
                include "afficheAccueil.php";
                $idUtilisateur = $_SESSION["sessionACI_id"];
            }
            ?>
        </div>
    </div>



    <!-- AJOUTER UNE QUESTION -->
    <div class="ajoutQuestion">
        <h2>Ajouter une question</h2>
        <form id="formAjout" method="post" action ="admin.php">
            <!-- liste déroulante des thèmes -->
            <select class="custom-select" id="choixThemeAdd" onchange="afficheSelectCat(this.value, this.id)">
                <option value="0">--- Veuillez choisir un thème ---</option>
                <?php
                $requeteThemes = $bdd->query("SELECT * FROM themes");
                while($resultatThemes = $requeteThemes->fetch_assoc()){
                    echo "<option value='" . $resultatThemes['idThemes'] ."'>" . $resultatThemes['nom'] ."</option>";
                }
                ?>                    
            </select>


            <!-- liste déroulante des catégories en fonction du thème choisi -->
            <select class="custom-select cache" id="choixCatAdd" onchange="afficheSelectLvl(this.value, this.id)">
                <option value="0">--- Veuillez choisir une catégorie ---</option>
            </select>


            <!-- liste déroulante des niveaux //en fonction de la catégorie choisie -->
            <select class="custom-select cache" id="choixNivAdd" onchange="afficheContenuQuestionAdd(this.value)">
                <option value="0">--- Veuillez choisir un niveau ---</option>
                <option value='1'>Niveau 1</option>
                <option value='2'>Niveau 2</option>
                <option value='3'>Niveau 3</option>
            </select>
            

            <div class="cache" id="contenuQuestion">
                <!-- liste déroulante pour indiquer le type de question -->
                <select class="custom-select" id="typeQuestionAdd" onchange="afficheSelonTypeQ(this.value)">
                    <option value="0">--- Type de question ---</option>
                    <option value="1">Texte seul</option>
                    <option value="2">Texte et image</option>
                    <option value="3">Texte et fichier</option>
                    <option value="4">Texte et lien</option>
                </select>

                <!-- zone de texte pour indiquer le détail de la question -->
                <input type="text" id="contenuQuestionAdd" size="50" placeholder="Contenu de la question">

                <!-- zone pour indiquer l'URL du fichier / de l'image -->
                <input class="cache" type="text" id="urlQuestionAdd" size="50" placeholder="Nom du fichier">

                <!-- zone de texte pour indiquer le lien -->
                <input class="cache" type="text" id="lienQuestionAdd" size="50" placeholder="Lien">


                <!-- liste déroulante pour indiquer le type de réponse -->
                <select class="custom-select" id="typeReponseAdd" onchange="afficheSelonTypeR(this.value)">
                    <option value="0">--- Type de réponse ---</option>
                    <option value="1">Texte simple</option>
                    <option value="2">QCM choix unique</option>
                    <option value="3">QCM choix multiples</option>
                </select>
                
                <!-- zone de texte pour indiquer les réponses possibles -->
                <input type="text" class="cache" id="repPossiblesQuestionAdd" size="50" placeholder="Réponses possibles">

                <!-- zone de texte pour indiquer la bonne réponse -->
                <input type="text" id="bonneRepQuestionAdd" size="50" placeholder="Bonne(s) réponse(s)">
                <legend>Séparer par les différentes réponses (possibles et/ou bonnes) par un point-virgule -> ";"</legend>     
                <button type="button" onclick="ajouterQuestion()">Ajouter</button>
            </div>
            <p id="reponseAdd"></p>
        </form>
    </div>
        



    <!-- SUPRIMER UNE QUESTION -->
    <div class="supprQuestion">
        <h2>Supprimer une question</h2>
        <form id="formSuppr">
            <!-- liste déroulante des thèmes -->
            <select class="custom-select" id="choixThemeSuppr" onchange="afficheSelectCat(this.value, this.id)">
                <option value="0">--- Veuillez choisir un thème ---</option>
                <?php
                $requeteThemes = $bdd->query("SELECT * FROM themes");
                while($resultatThemes = $requeteThemes->fetch_assoc()){
                    echo "<option value='" . $resultatThemes['idThemes'] ."'>" . $resultatThemes['nom'] ."</option>";
                }
                ?>                    
            </select>

            <!-- liste déroulante des catégories en fonction du thème choisi -->
            <select class="custom-select cache" id="choixCatSuppr" onchange="afficheQuestions(this.value, this.id)">
                <option value="0">--- Veuillez choisir une catégorie ---</option>
            </select>
            
            <!-- liste déroulante des questions en fonction de la catégorie choisie -->
            <select class="custom-select cache" id="choixQuestionSuppr" onchange="afficheBtnSuppr(this.value)">
                <option value="0">--- Veuillez choisir la question ---</option>
            </select>
            
            <button class="cache" id="btnSuppr" type="button" onclick="supprimerQuestion()">Supprimer la question</button>
            <p id="reponseSuppr"></p>
        </form>        
    </div>



    <!-- REININITALISER UN COMPTE/ID-->
    <div class="supprCompte">
        <h2>Réinitialiser un compte</h2>
        <form class="input-group mb-3" method="post" action="admin.php">
            <input type="text" placeholer="id du compte à supprimer" name="suprId">                
            <button type="submit">Réinitialiser</button>
        </form>

        <?php
        // Supprime les réponses de l'utilisateur et le met en non actif.
        if(isset($_POST["suprId"])){
            $suprId = $_POST["suprId"];
            if($bdd->query("UPDATE utilisateurs SET actif = '0' WHERE idUtilisateurs = '$suprId'") && $bdd->query("DELETE FROM reponses WHERE utilisateurs_idUtilisateurs = '$suprId'")){
                echo "<p class='msg-form-ok'>Le compte " . $suprId . " a été remis à zéro<p>";
            }
            else{
                echo "Erreur";
            }
        }
        ?>
    </div>



    <!-- ACTIVER/CREER UN COMPTE/ID-->
    <div class="ajouterCompte">
        <h2>Créer/activer un compte (l'id sera donné après création)</h2>
        <form class="menuAjoutCompte" method="post" action="admin.php">
            <input class="mdpAjout" type="password" placeholder="Mot de passe" name="mdp">
            <input class="mdpAjout" type="password" placeholder="Répéter le mot de passe" name="mdpVerif">
            <button type="submit">Créer le compte</button>
        </form>

        <?php
        // recherche si un compte est non actif -> si oui on l'active + change mdp -> si non on en crée un + change mdp

        // vérifie si les champs ont été remplis
        if(isset($_POST["mdp"]) && isset($_POST["mdpVerif"])){
            //vérifie si le mdp et la confirmation de mdp sont identiques
            if(($_POST["mdp"] === $_POST["mdpVerif"])){
                $mdp = password_hash(mysqli_real_escape_string($bdd, $_POST['mdp']), PASSWORD_DEFAULT);
                // récupère le premier numéro de compte non actif s'il existe
                $idNonActif = mysqli_fetch_assoc($bdd->query("SELECT idUtilisateurs FROM utilisateurs WHERE actif = '0' ORDER BY idUtilisateurs ASC"));
                $idNonActif = $idNonActif['idUtilisateurs'];
                var_dump($idNonActif);
                // si il existe, on l'active et on change le mdp
                if($idNonActif != null){
                    if($bdd->query("UPDATE utilisateurs SET mdp ='$mdp' , actif = '1' WHERE idUtilisateurs = '$idNonActif' ")){
                        echo "<p class='msg-form-ok'>Le compte " . $idNonActif . " a été réactivé<p>";
                    }
                }
                // sinon on en crée un avec un mdp
                else{
                    if($bdd->query("INSERT INTO utilisateurs (mdp) VALUES ('$mdp')")){
                        echo "<p class='msg-form-ok'>Le compte " . mysqli_insert_id($bdd) . " a été créé et activé<p>";
                    }
                }   
            }
            // Si les champs de mdp sont différents : on envoie un msg d'erreur
            else{
                echo "<p class='msg-form-fail'>Les mots de passe ne sont pas identiques !</p>";
            }
        }         
        ?>
    </div>
</div>

<?php include "footer.php"; ?>





<!--
    1 : problème d'apostrophes dans les inputs


 -->