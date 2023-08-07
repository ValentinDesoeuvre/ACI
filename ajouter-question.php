<?php
// Connection à la BDD ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
    $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
    $bdd->set_charset("utf8");

// récupération des infos
$cat = $_REQUEST["cat"];
$niv = $_REQUEST["niv"];
$contenu = $_REQUEST["contenu"];
$typeQ = $_REQUEST["typeQ"];
$urlQ = $_REQUEST["urlQ"];
$lienQ = $_REQUEST["lienQ"];
$typeR = $_REQUEST["typeR"];
$bonneR = $_REQUEST["bonneR"];
$repPossibles = $_REQUEST["repPossibles"];

// Ajout de la question
if ($requeteAdd = $bdd->query("INSERT INTO questions(contenu, typeQuestion, urlQuestion, lienQuestion, typeReponse, bonneReponse, reponsesPossibles, niveau, categories_idCategories) VALUES('$contenu', '$typeQ', '$urlQ', '$lienQ', '$typeR', '$bonneR', '$repPossibles', '$niv', '$cat')")){
    echo "La question a bien été enregistrée";
}
// Sinon afficher un msg d'erreur
else {
    echo "Erreur";
}
?>