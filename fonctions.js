function afficheResultats(nb) {
    if(!isNAN(nb)) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "afficheAccueil.php", true);
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector("#resultatsDetenu").innerHTML = this.responseText;
            }
        };
        xmlhttp.send();
    }
}



function afficheSelectCat(value, id) { // dans value on récupère l'id du thème choisi
    if (value==0) {
        document.querySelector("#" + id).nextElementSibling.classList.add("cache");
    }
    else{
        document.querySelector("#" + id).nextElementSibling.classList.remove("cache");
        xmlhttp = new XMLHttpRequest();     
        xmlhttp.open("GET","get-cat.php?q="+value,true);           
        xmlhttp.onreadystatechange=function() {                    
            if (this.readyState==4 && this.status==200) {
                document.querySelector("#"+id).nextElementSibling.innerHTML = "<option value='0'>--- Veuillez choisir une catégorie ---</option>" + this.responseText;
            }
        }
        xmlhttp.send();
    }    
}



function afficheSelectLvl(value, id) {
    if (value==0) {
        document.querySelector("#" + id).nextElementSibling.classList.add("cache");
    }
    else{
        document.querySelector("#" + id).nextElementSibling.classList.remove("cache");
    }
}



function afficheContenuQuestionAdd(value) {
    if (value==0){
        document.querySelector("#contenuQuestion").classList.add("cache");  
    }
    else{
        document.querySelector("#contenuQuestion").classList.remove("cache"); 
    }   
}
            

function afficheSelonTypeQ(value) {
    document.querySelector("#urlQuestionAdd").classList.add("cache");
    document.querySelector("#lienQuestionAdd").classList.add("cache");
    if (value == 2 || value ==3){
    document.querySelector("#urlQuestionAdd").classList.remove("cache");        
    }
    else if (value == 4){
        document.querySelector("#lienQuestionAdd").classList.remove("cache");
    }
}


function afficheSelonTypeR(value) {
    document.querySelector("#repPossiblesQuestionAdd").classList.add("cache");
    if (value == 2 || value == 3){
        document.querySelector("#repPossiblesQuestionAdd").classList.remove("cache");
    }
}


function ajouterQuestion() {
    var themeQuestion = document.querySelector('#choixThemeAdd').value,
    catQuestion = document.querySelector('#choixCatAdd').value,
    nivQuestion = document.querySelector('#choixNivAdd').value,
    contenuQuestion = document.querySelector('#contenuQuestionAdd').value,
    typeQ = document.querySelector('#typeQuestionAdd').value,
    urlQ = document.querySelector('#urlQuestionAdd').value,
    lienQ = document.querySelector('#lienQuestionAdd').value,
    typeR = document.querySelector('#typeReponseAdd').value,
    bonneR = document.querySelector('#bonneRepQuestionAdd').value,
    repPossibles = document.querySelector('#repPossiblesQuestionAdd').value,
    reponse = document.querySelector('#reponseAdd');
    
    if (themeQuestion == undefined || themeQuestion == "" || themeQuestion == "0") {
        reponse.innerHTML = "Veuillez indiquer un thème";
    }
    else if(catQuestion == undefined || catQuestion == "" || catQuestion == "0"){
        reponse.innerHTML = "Veuillez indiquer une catégorie";
    }
    else if(nivQuestion == undefined || nivQuestion == "" || nivQuestion == "0"){
        reponse.innerHTML = "Veuillez indiquer un niveau";
    }
    else if(contenuQuestion == undefined || contenuQuestion == ""){
        reponse.innerHTML = "Veuillez indiquer le contenu de la question";
    }
    else if(typeQ == undefined || typeQ == "" || typeQ == "0"){
        reponse.innerHTML = "Veuillez indiquer le type de question";
    }
    else if ((typeQ == "2" || typeQ == "3") && (urlQ == undefined || urlQ == "")){
        reponse.innerHTML = "Veuillez indiquer l'url du supplément";
    }
    else if ((typeQ == "4") && (lienQ == undefined || lienQ == "")){
        reponse.innerHTML = "Veuillez indiquer le lien lié à la question";
    }
    else if(typeR == undefined || typeR == "" || typeR == "0"){
        reponse.innerHTML = "Veuillez indiquer le type de réponse";
    }
    else if(bonneR == undefined || bonneR == ""){
        reponse.innerHTML = "Veuillez indiquer la(les) bonne(s) réponse(s)";
    }
    else if ((typeR == "2" || typeR == "3") && (repPossibles == undefined || repPossibles == "")){
        reponse.innerHTML = "Veuillez indiquer les différentes réponses possibles";
    }
    else{
        xmlhttp = new XMLHttpRequest();   
        xmlhttp.open("GET","ajouter-question.php?cat=" + catQuestion + "&niv=" + nivQuestion + "&contenu=" + contenuQuestion + "&typeQ=" + typeQ + "&typeR=" + typeR + "&urlQ=" + urlQ + "&lienQ=" + lienQ + "&bonneR=" + bonneR + "&repPossibles=" + repPossibles, true);             
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                reponse.innerHTML = this.responseText;
                if (this.responseText == "La question a bien été enregistrée") {
                    resetForm("ajouter");
                }
            }
        }
        xmlhttp.send();    
    }
}





function afficheQuestions(value, id){
    if (value==0) {
        document.querySelector("#" + id).nextElementSibling.classList.add("cache");
        return;
    }
    document.querySelector("#" + id).nextElementSibling.classList.remove("cache");
    xmlhttp = new XMLHttpRequest();     
    xmlhttp.open("GET","affiche-questions.php?q="+value,true);           
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            document.querySelector("#"+id).nextElementSibling.innerHTML = "<option value='0'>--- Veuillez choisir la question à supprimer ---</option>" + this.responseText;
        }
    }
    xmlhttp.send();
}


function afficheBtnSuppr(value){
    if (value==0) {
        document.querySelector("#btnSuppr").classList.add("cache");
        return;
    }
    else {
        document.querySelector("#btnSuppr").classList.remove("cache");
    }
}


function supprimerQuestion(){
    var idQ = document.querySelector('#choixQuestionSuppr').value,
    reponse = document.querySelector('#reponseSuppr');
    if (idQ == undefined || idQ == "" || idQ == "0") {
        reponse.innerHTML = "Choisissez une question";
    }
    else{
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET","supprimer-question.php?q="+idQ, true);             
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {  
                reponse.innerHTML = this.responseText;
                if (this.responseText == "La question a bien été supprimée"){
                    resetForm("supprimer");
                }
            }
        }
        xmlhttp.send();
    }
}



function resetForm(type){
    if (type == "ajouter"){
        document.querySelector("#choixCatAdd").classList.add("cache");
        document.querySelector("#choixNivAdd").classList.add("cache");
        document.querySelector("#contenuQuestion").classList.add("cache");
        document.querySelector("#formAjout").reset();
    }
    else if(type == "supprimer"){
        document.querySelector("#choixCatSuppr").classList.add("cache");
        document.querySelector("#choixQuestionSuppr").classList.add("cache");        
        document.querySelector("#btnSuppr").classList.add("cache");
        document.querySelector('#formSuppr').reset();
    }
}
