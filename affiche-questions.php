<?php
// Connection à la BDD ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
    $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
    $bdd->set_charset("utf8");

// récupération des infos
$cat = $_REQUEST["q"];


// Ajout de la question
$requeteQ = $bdd->query("SELECT * FROM questions WHERE categories_idCategories = '$cat'");

while($resultatQ = $requeteQ->fetch_assoc()){
    echo "<option value='" . $resultatQ['idQuestions'] ."'>" . $resultatQ['intitule'] ."</option>";
}
?>