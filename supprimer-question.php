<?php
// Connection à la BDD ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
    $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
    $bdd->set_charset("utf8");

// récupération des infos
$idQ = $_REQUEST["q"];

// Ajout de la question
if ($requeteAdd = $bdd->query("DELETE FROM questions WHERE idQuestions = '$idQ'")){
    echo "La question a bien été supprimée";
}
// Sinon afficher un msg d'erreur
else {
    echo "Erreur";
}
?>