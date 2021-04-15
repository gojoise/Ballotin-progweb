
let Profilename;
init();


function init() { //Quand on lance le site on appelle ces deux fonctions
    autologin();
    showListVot();
}
function isConnected() { // fonction qui lors de la connection change l'affichage des box
    $(".box-init").css("display", "none");
    $(".box-vote").css("display", "initial");
    // Get the element with id="defaultOpen" and click on it
    document.getElementById('defaultOpen').click();//Clique sur create pour avoir cet acceuil
    update()//met à jour les choix de scrutin
}
function update(){ // fonction qui met a jour les selects des "choix du srcutin:"" du site
    $("#votable").html("<option value=''></option>")
    $("#owned").html("<option value=''></option>")
    $("#all").html("<option value=''></option>")
    votableScrutins()
    ownedScrutins()
    ownedScrutins2()
    allScrutins()
}

function autologin() {
    $(document).ready(function () {
        if (localStorage.getItem("mail") != null) {//Si il existe un login dans le localStorage

            Profilename = localStorage.getItem("mail") //on met le profil à jour
            isConnected();//on termine la connexion
        } else {
        }
    })
}

function locStorage(login) {
    localStorage.setItem("mail", login);
    //Pas de date d'expiration !
}

function connect() {
    let mail = $("#mail").val();
    let password = $("#pass").val();
    $.ajax({
        method: "GET",
        url: "connection.php",
        data: { "mail": mail, "password": password }
    }).done(function (e) {
        console.log(e)
        if (e == "Ok.") {
            locStorage(mail);//enregistrement du cookie
            Profilename = mail //enregistrement utilisateur dans le site
            isConnected(); //Actions à réaliser une fois connecté
        }
        if (e == "Erreur")
            $("#message").html("<span class='ko'> Error: mail ou mot de Mot-de-passe incorrect </span> <style> span{ color : red} </style>")

    }).fail(function (e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
    });
}

function disconnect() {
    $(".box-init").css("display", "initial");
    $(".box-vote").css("display", "none");
    localStorage.clear();
    Profilename = null;
    location.reload();
    return false;
}
/*
Inspiré de https://www.w3schools.com/howto/howto_js_vertical_tabs.asp
*/
function openTab(evt, tabName) {
    var i, tabcontent, tablinks; // Création des variables
    tabcontent = document.getElementsByClassName("tabcontent"); // On récupère les elements de la page (les contenus des tab)
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none"; // Pour tout les contenus du tab on passe l'affichage à none
    }
    tablinks = document.getElementsByClassName("tablinks"); // on récup les boutons
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", ""); // on passe leur class active à ""
    }
    //Une fois que tout est remis à 'zéro'
    document.getElementById(tabName).style.display = "block"; //On met le contenu qui nous intéresse affiché == $("#tabName").css("display", "block");
    evt.target.className += " active"; //On met le bouton correspondant en active (le css s'applique alors)
}


function addOption() { // fonction qui ajoute des ligne aux Options
    var ligne = "<tr><td><input class='option' type='text' name='test'><input type='checkbox' name='select'></td><td>";
    $("table.optionlist").append(ligne); // cela ce place dans la table avec pour class optionList et a chaque appel de fonction on insert la ligne declarer ci-dessus
}

function delOption() { // fonction qui supprime des ligne au Option
    $("table.optionlist").find('input[name="select"]').each(function () {
        if ($(this).is(":checked")) {
            $(this).parents("table.optionlist tr").remove();
        }
    });
};

function addElecteur() { // fonction qui ajoute des ligne pour les Electeur
    var ligne = "<tr><td><input class='electeur' type='text' name='test' placeholder ='Veuillez enter un mail'><input type='checkbox' name='select'></td><td></label><select class='Procuration'><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option></select></td></tr>";

    $("table.invit").append(ligne);
}

function delElecteur() { // fonction qui supprimeqzzssss des ligne pour les Electeur
    $("table.invit").find('input[name="select"]').each(function () {
        if ($(this).is(":checked")) {
            $(this).parents("table.invit tr").remove();
        }
    });
};
//Sauvegarde le scrutin
function recupererScutin() {
    //Récupère les champs de HTML dans des variables
    let name = $("#ScrutinName").val();
    let ques = $("#Question").val();
    let opt = []
    var inputs = $(".option");
    for (var i = 0; i < inputs.length; i++) {
        opt.push($(inputs[i]).val());
    }
    $.ajax({
        method: "GET",
        url: "valid.php",
        data: { "profile": Profilename, "name": name, "question": ques, "options": opt }
    }).done(function (e) {
        alert("Le scrutin a été enregistré")
        let nom = "<input type='name' id='ScrutinName' name='name' placeholder='Le nom du scrutin'><br>";

        let question = "<b>B) Question : </b><textarea placeholder='Quel est votre Question?' rows='3' cols='40' id='Question'></textarea>";

        let option = "<b>C) Option</b> <br><input type='button' class='add' value='Ajouter une ligne' onclick='addOption()'><button type='button' class='delete' onclick='delOption()'>Supprimer une ligne</button><table class='optionlist'><th>Sélectionner vos Option</th><tr><td><input class='option' type='text' name='test'><input type='checkbox' name='select'></td><td> </tr></table>";

        //Reset de champs de l'html
        $("#nom").html(nom);
        $("#question").html(question);
        $("#opti").html(option);
        //on envoie l'utilisateur dans le menu inviter
        $("#invite").click();
        //On refresh la liste des scrutins dans choix scrutin:
        update()

    }).fail(function (e) {
        console.log(e);
        $("#message").html("<span class='ko'> Error: network problem </span>");
    });
}
var flag = false
var flag2 = false
function rajoutElecteur() {
    /*
    [{nom:hamza,vote:1},...] // données à envoyer à PHP
    */
    //Recupération des données dans HTML

    let nameScr=$("#owned").find(":selected").text()
    let elect = []
    var inputs = $(".electeur");
    for (var i = 0; i < inputs.length; i++) {
        elect.push($(inputs[i]).val());
    }
    let procus = []
    var selects = $(".Procuration");
    for (var i = 0; i < selects.length; i++) {
        procus.push($(selects[i]).find(":selected").text());
    }
    $.ajax({
        method: "GET",
        url: "votants.php",
        data: { "name":nameScr, "electeurs": elect, "procurations": procus }
    }).done(function (e) {
        if(flag){if(flag2){}else{
            $("#reussi").html("")
            $("#rate").append("Vous ne pouvez plus rajouter d'électeurs")
            flag2 = true
        }
    }else{
        update();

        $("#reussi").append("Les électeurs ont bien été enregistré")

    }
    flag = true
    }).fail(function (e) {
    });
}
// inspiré de https://stackoverflow.com/questions/19706046/how-to-read-an-external-local-json-file-in-javascript
function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}
function showElec() { // cette fonction montre les electeur par rapport au scrutin choisit
    $("#showElec").html("")
        readTextFile("scrutins.json", function (text) { // cette ligne lit le fichier scrutin.json ou est stockée toutes nos scrutin
            var data = JSON.parse(text);
            let nameScr=$("#all").find(":selected").text() // selectionne le scrutin choisit dans le input
            data.forEach((data) => { // notre scrutin etant un tableau on verrifie dans l'ensemble des scrutin
                data["votants"].forEach((elec) => { // est dans l'ensemble des votants
                        if(nameScr == data["name"]){ // Si le nom du scrutin a le meme nom que celui selectionner
                $("#showElec").append("<input type='text' name='les_options' value ='" + elec["name"] + "'readonly><button class='but-elec'>"+elec["nbVotes"]+"</button><br>"); // on affiche le scrutin
           }
            })
            })

        });

}
var scrutinsaffiche = false;
function showListVot() {
    if (scrutinsaffiche) { } else {
        readTextFile("listepredef.json", function (text) {
            var data = JSON.parse(text);
            data.forEach((data) => {
                var keys = Object.keys(data);
                console.log(keys[0])
                $("#Choix").append("<option  value='" + keys[0] + "'>" + keys[0] + "</option>")
            })
            scrutinsaffiche = true;
        });
    }
}
//Recupère la liste predef de votants demandée pour préremplir les champs
function validListVot() {
    let nameList = $("#Choix").find(":selected").text();
    $.ajax({
        method: "GET",
        url: "preVot.php",
        data: { "name": nameList }
    }).done(function (e) {
        if (e == "") {}else{ //Protection pour éviter l'erreur quand le select est vide
        let array = JSON.parse(e)
        $("table.invit").html("")
        $("table.invit").append(" <tr><th>Nom</th><th>Procuration</th></tr><tr><div id ='check'></div></tr>")
        array.forEach((elements) => {

            $("table.invit").append("<tr><td><input value = '" + elements + "' class='electeur' type='text' name='test'><input type='checkbox' name='select'></td><td></label><select class='Procuration'><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option></select></td></tr>")
        })
    }
    }).fail(function (e) {
    });

}
/*votableScrutins ownedScrutins ownedScrutins2et allScrutins sont des fonctions qui font toutes la même chose
un changement la requete ajax différente pour que le PHP renvoie une partie des scrutins différente
autre changement l'id où l'on met le resultat
*/
function votableScrutins(){
    $.ajax({
        method: "GET",
        url: "getScrutin.php",
        data: { "profile": Profilename,"action" : "votable"}
    }).done(function (e) {
        let array = JSON.parse(e)
        array.forEach((elements) => {
            $("#votable").append("<option  value='" + elements["name"] + "'>" + elements["name"] + "</option>")
        })
    }).fail(function (e) {
    });
}
function ownedScrutins(){
    $.ajax({
        method: "GET",
        url: "getScrutin.php",
        data: { "profile": Profilename,"action" : "owner"}
    }).done(function (e) {
        let array = JSON.parse(e)
        array.forEach((elements) => {
            $("#owned").append("<option  value='" + elements["name"] + "'>" + elements["name"] + "</option>")
        })
    }).fail(function (e) {
    });
}


function ownedScrutins2(){
    $.ajax({
        method: "GET",
        url: "getScrutin.php",
        data: { "profile": Profilename,"action" : "owner"}
    }).done(function (e) {
        let array = JSON.parse(e)
        array.forEach((elements) => {
            $("#owned2").append("<option  value='" + elements["name"] + "'>" + elements["name"] + "</option>")
        })
    }).fail(function (e) {
    });
}

function allScrutins(){
    $.ajax({
        method: "GET",
        url: "getScrutin.php",
        data: { "profile": Profilename,"action" : "all"}
    }).done(function (e) {
        let array = JSON.parse(e)
        array.forEach((elements) => {
            $("#all").append("<option  value='" + elements["name"] + "'>" + elements["name"] + "</option>")
        })
    }).fail(function (e) {
    });
}
function closeScrutin() { // fonction qui ferme le scrutin

    readTextFile("results.json", function (text) {
        var data = JSON.parse(text);
        let nameScr=$("#owned2").find(":selected").text()
        if (nameScr == ""){}else{ // cas ou le scrutin selectionner est vide (le cas ou il y a pas de scrutin)
            $("#fini").html("")
            $("#fini").append("<tr><th>Option</th><th>Reponses</th></tr><tr><div id ='fini'></div></tr>")
        data.forEach((data) => { // on parcours tous les scrutin disponible
            if (nameScr == data["name"]) { // Si le scrutin selectionner correspond au scrutin de notre json

                data["res"].forEach((opt) =>{
                   console.log(opt[Object.keys(opt)])
                   $("#fini").append("<tr><td><input type='text' name='les_options' value ='" + Object.keys(opt) + "'readonly><button class='but-elec'>"+opt[Object.keys(opt)]+"</button></td></tr>") // on affiche les resultat du scrutin
                })

            }
        })
    }
    })
}


function inputElement(){ // fonction qui affiche tous les options du scrutin disponibles dans le input assosier a l'id showElem
    $("#showElem").html("")
    readTextFile("scrutins.json", function (text) {
        var data = JSON.parse(text);
        let nameScr=$("#votable").find(":selected").text()
        data.forEach((data) => {
            if(nameScr == data["name"]){
            data["options"].forEach((opt) => {

            $("#showElem").append("<input type='radio' id="+opt+" name='opt'><label for="+opt+"> "+opt+"</label><br>");
        })
        }
       });


    });

}

var err = false;
function vote(){ // fonction qui permet au Electeur de vote
    var ele = document.getElementsByName('opt');
        let nameOpt;
        for(i = 0; i < ele.length; i++) {  // prend l'option selectionner
                if(ele[i].checked){
                nameOpt = ele[i].id;
                }

            }
        let nameScr=$("#votable").find(":selected").text();

        $.ajax({
            method: "GET",
            url: "vote.php",
            data: { "profile": Profilename,"opt" : nameOpt,"Scrutin":nameScr}
        }).done(function (e) {
            $("#err").html("")
            $("#err").append("<b>"+e+"</b>")
    }).fail(function (e) {
    });
}
