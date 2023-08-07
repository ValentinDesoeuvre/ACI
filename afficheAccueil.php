<?php
/*
BUT : Récupérer l'id de la premiere question non répondue de la catégorie en cours.

si niveau = 1 ET avancement du niveau = 0 alors
    Récupère la premiere question par ordre ascendant (du plus petit numéro au plus grand) de la catégorie et de niveau 1

    SELECT idQuestions FROM questions WHERE categories_idCategories = VARIABLE AND niveau = VARIABLE ORDER BY idQuestions ASC LIMIT 1

sinon
    Récupère la premiere question non répondue par l'utilisateur, par ordre ascendant (du plus petit numéro au plus grand) de la catégorie et du niveau en cours

    SELECT idQuestions FROM questions WHERE categories_idCategories = VARIABLE AND niveau = VARIABLE AND idQuestions != (
        SELECT DISTINCT questions_idQuestions FROM reponses WHERE utilisateurs_idUtilisateurs = VARIABLE
    ) ORDER BY idQuestions ASC LIMIT 1
*/



// Affiche les thèmes
$requeteThemes = $bdd->query("SELECT * FROM themes");
while($resultatThemes = $requeteThemes->fetch_assoc()){
    $idTheme = $resultatThemes['idThemes'];
    $nomTheme = $resultatThemes['nom'];
    echo "<div class='div-theme row flex-wrap' id='theme-" . $idTheme . "'>";

    // Affiche les catégories de chaque thème
    $requeteCategories = $bdd->query("SELECT nom, idCategories FROM categories WHERE themes_idThemes = $idTheme");
    while($resultatCategories = $requeteCategories->fetch_assoc()){
        $idCategorie = $resultatCategories['idCategories'];
        $nomCategorie = $resultatCategories['nom'];
        echo "<div class='div-categorie text-center col-3'><a href='question.php?id=" . $toto . "><h3 class='titre-theme'>" . $nomTheme . "</h3><h4 class='titre-categorie'>" . $nomCategorie . "</h4>";
        
        // Affiche le niveau actuel de la catégorie selon l'utilisateur
        $niveau = 0;
        do {
            $niveau ++;
            // Recherche le nombre de questions dans le niveau
            $requeteNbQuestions = $bdd->query("SELECT COUNT(idQuestions) AS 'nbQuestions' FROM questions WHERE niveau = $niveau AND categories_idCategories = $idCategorie");
            $nbQuestions = $requeteNbQuestions->fetch_assoc();;

            // Recherche le nombre de questions répondues dans le niveau
            $requeteNbQuestionsRep = $bdd->query("SELECT COUNT(idQuestions) AS 'nbQuestionsRepondues' FROM questions 
                WHERE niveau = $niveau AND categories_idCategories = $idCategorie AND idQuestions = (
                    SELECT questions_idQuestions FROM reponses WHERE utilisateurs_idUtilisateurs = $idUtilisateur
                )");
            $nbQuestionsRep = $requeteNbQuestionsRep->fetch_assoc();
            

            // ------------>  A SUPPRIMER AVANT RENDU FINAL
            $nbQuestions['nbQuestions'] = 4; $nbQuestionsRep['nbQuestionsRepondues'] = 1;
            // ------------>  A SUPPRIMER AVANT RENDU FINAL

            // Compte le pourcentage actuel de progression dans le niveau, tant qu'il est de 100% on passe au niveau suivant
            $progression = $nbQuestionsRep['nbQuestionsRepondues'] / $nbQuestions['nbQuestions'] * 100 ;
        } while($progression == 100 && $niveau < 5);
        
        // Affiche le niveau et la progression dans ce niveau
        echo "<p>Niveau " . $niveau . "</p>";
        echo "<div class='progress'>
                <div class='progress-bar' role='progressbar' aria-valuenow='" . $progression . "' aria-valuemin='0' aria-valuemax='100' 
                style='width:" . $progression . "%'>" . $nbQuestionsRep['nbQuestionsRepondues'] . " / " . $nbQuestions['nbQuestions'] ."</div>
            </div></a></div>";
    }                
    echo "</div>";
}


/* Requetes SQL
    SELECT * FROM themes
        => id va dans $idTheme
    SELECT nom, idCategories FROM categories WHERE themes_idThemes = $idTheme
        => id va dans $idCategorie


    on veut savoir le niveau actuel, donc il faut regarder les questions répondues dans la catégorie :
    SELECT * FROM questions WHERE categories_idCategories = $idCategorie

    comparer en boucle :  le nb de questions du niveau de la catégorie répondues par l'utilisateur
                $niveau = 0
                Intermédiaire : id des questions répondues par l'utilisateur 
                SELECT questions_idQuestions FROM reponses WHERE utilisateurs_idUtilisateurs = $idUtilisateur
                
                SELECT COUNT(idQuestions) AS 'nbQuestionsRepondues' FROM questions 
                WHERE niveau = $niveau AND categories_idCategories = $idCategorie AND idQuestions = (
                    SELECT questions_idQuestions FROM reponses WHERE utilisateurs_idUtilisateurs = $idUtilisateur
                )
                => va dans $nbQuesRep

                
                au nb de questions du niveau dans la catégorie
                SELECT COUNT(idQuestions) AS 'nbQuestions' FROM questions WHERE niveau = $niveau AND categories_idCategories = $idCategorie
                => va dans $nbQuestCat
    si les deux sont égaux : $niveau ++ et on recommence avec $niveau
    sinon fin de la boucle et on se sert de $nbQuesRep et de la comparaison pour afficher la barre et de $niveau pour le nom du niveau */


    /* 
| ALGO |
Récupérer les thèmes
Pour chaque theme ->
    (Attribuer une couleur/dégradé au thème: via class)
    Créer une div contenant :
        Pour chaque catégorie dans ce thème ->
            Créer une div contenant :
            Le nom du thème dans un h3 
            Le nom de la catégorie dans un h4
            Le niveau actuel du détenu dans cette catégorie de ce theme (dans un h5? trop de h ? => p)
            La progression dans le niveau en cours
*/

//Aller sur ce site :  https://codepen.io/Oreh/pen/JLeLJQ


?>