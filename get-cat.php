<?php
// Connection à la BDD ---- IMPORTANT : changer l'ip lors de la mise en place ! -----
    $bdd = new mysqli("127.0.0.1", "root", "root", "mydb"); 
    $bdd->set_charset("utf8");

// récupération de l'id
$id = $_REQUEST["q"];
$requeteCat=$bdd->query("SELECT * FROM categories WHERE themes_idThemes = $id ");
while($resultatCat = $requeteCat->fetch_assoc()){
    echo "<option value='" . $resultatCat['idCategories'] ."'>" . $resultatCat['nom'] ."</option>";
}
?>