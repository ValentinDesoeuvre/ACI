<?php
// Connection à la BDD ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
    $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
    $bdd->set_charset("utf8");

// récupération de l'id
$id = $_REQUEST["q"];
$requeteLvl=$bdd->query("SELECT DISTINCT niveau FROM questions WHERE categories_idCategories = $id ");
if ($requeteLvl->fetch_assoc() == ""){
    echo "<option value='1'>Niveau 1</option>";
}
else{
    while($resultatLvl = $requeteLvl->fetch_assoc()){
        echo "<option value='" . $resultatLvl['niveau'] ."'>Niveau " . $resultatLvl['niveau'] ."</option>";
    }
}

?>