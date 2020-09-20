
$(document).ready(function()
{
    // Variables
    var vies = 3;
    var scoreJeu = 0;
    var tours = 0;
    var boolean = false;

    // Cacher GameOver, Recommener, Retour et la taupe finale
    $('#gameover').hide();
    $('#recommencer').hide();
    $('#retour').hide();
    $('#taupeFinal').hide();

    /// Compte à rebour du départ
    var cpt = 3;
    var myVar = setInterval(myTimer, 1010);

    function myTimer() {
        cpt--;
        if(cpt===0){
            document.getElementById("depart").innerHTML = "GO";
            var myVar2 = setInterval(myTimer2, 950);
            function myTimer2(){
                $('#depart').hide();
                myStopFunction();
            }
        } else {
            document.getElementById("depart").innerHTML = cpt;
        }
    }

    function myStopFunction() {
        clearInterval(myVar);
    }

//// TOUT CACHER ///////
    $('.bombe').hide();
    $('.taupe').hide();
    $('.taupeArriere').hide();

    //// COMMENCER LE JEU ///////

    commencerJeu();

   //////// COMPTER LE SCORE ///////
        /// TAUPE ////

    $(".taupe" ).click(function()
    {
        scoreJeu = scoreJeu +10;
        boolean = true;
        //augmentation du score lorsque l'on clique sur la taupe
        $("#score").html("Score: " + scoreJeu);
        $('.taupe').hide();
        $(".taupe").delay(1000);
    });

        /////// BOMBE //////////

    $(".bombe" ).click(function()
    {
        scoreJeu = scoreJeu-10;
        vies = vies-1;

        //// CHECKER LES TONNEAUX ///////
        document.getElementById('tonneauP').className="tonneau";
        document.getElementById('tonneau2P').className="tonneau";
        document.getElementById('tonneau3P').className="tonneau";
        document.getElementById('tonneau4P').className="tonneau";
        document.getElementById('tonneau5P').className="tonneau";
        document.getElementById('tonneau6P').className="tonneau";
        /// REMISE A ZERO CLASS TONNEAU /////
        remiseZero();
///Modifier l'apparence des vies ///////
        switch(vies){
            case 0 : document.getElementById("coeur1").className = "coeur" ;
                $('#gameover').show();
                $('#recommencer').show();
                $('#retour').show();
                $('#taupeFinal').show();
                break;
            case 1 : document.getElementById("coeur2").className = "coeur" ; break;
            case 2 : document.getElementById("coeur3").className = "coeur"
                ; break;
        }
        $("#score").html("Score: " + scoreJeu);
        $('.bombe').hide();
        $(".bombe").delay(1000);
    });

        /////// 2 TAUPES ///////////

    $(".taupeArriere" ).click(function()
    {
        scoreJeu = scoreJeu +10;
        boolean = true;
        //augmentation du score lorsque l'on clique sur la taupe
        $("#score").html("Score: " + scoreJeu);
        $('.taupeArriere').hide();
        $(".taupeArriere").delay(1000);
    });
//////////////////// FONCTION POUR LE CALCULE SI LES TAUPES NE SONT PAS TOUCHES //////
    function compter(){
        setTimeout(compterExecuter, 2500); //On attend 5 secondes avant d'exécuter la fonction
    }
    function compterExecuter() {

        if(boolean === false){
            vies = vies-1;
            document.getElementById('tonneauP').className="tonneau";
            document.getElementById('tonneau2P').className="tonneau";
            document.getElementById('tonneau3P').className="tonneau";
            document.getElementById('tonneau4P').className="tonneau";
            document.getElementById('tonneau5P').className="tonneau";
            document.getElementById('tonneau6P').className="tonneau";
            remiseZero();
            switch(vies){
                case 0 : document.getElementById("coeur1").className = "coeur" ;
                    $('#gameover').show();
                    $('#recommencer').show();
                    $('#retour').show();
                    $('#taupeFinal').show();
                    break;
                case 1 : document.getElementById("coeur2").className = "coeur" ; break;
                case 2 : document.getElementById("coeur3").className = "coeur"
                ; break;
            }
        }
    }
    function remiseZero(){
        setTimeout(remiseZeroExecuter, 2500); //On attend 5 secondes avant d'exécuter la fonction
    }
    function remiseZeroExecuter() {
        document.getElementById('tonneauP').className="";
        document.getElementById('tonneau2P').className="";
        document.getElementById('tonneau3P').className="";
        document.getElementById('tonneau4P').className="";
        document.getElementById('tonneau5P').className="";
        document.getElementById('tonneau6P').className="";
    }
    function commencerJeu() {
        setTimeout(commencerExecuter, 4500); //On attend 5 secondes avant d'exécuter la fonction

    }

    function cacher() {
        setTimeout(cacherExecuter, 2500); //On attend 5 secondes avant d'exécuter la fonction
    }

    function cacherExecuter(){

        $('.bombe').hide();
        $('.taupe').hide();
        $('.taupeArriere').hide();

    }
    function commencerExecuter() {
        var nbrAleatoire = Math.floor(Math.random() * (19 - 1) + 1);
        tours++;
        boolean = false;
        switch (nbrAleatoire) {
            case 1 :
                $('#bombeP').show();
                break;
            case 2 :
                $('#bombe2P').show();
                break;
            case 3 :
                $('#bombe3P').show();
                break;
            case 4 :
                $('#bombe4P').show();
                break;
            case 5 :
                $('#bombe5P').show();
                break;
            case 6 :
                $('#bombe6P').show();
                break;
            case 7 :
                $('#taupeP').show();
                compter();
                break;
            case 8 :
                $('#taupe2P').show();
                compter();
                break;
            case 9 :
                $('#taupe3P').show();
                compter();
                break;
            case 10 :
                $('#taupe4P').show();
                compter();
                break;
            case 11 :
                $('#taupe5P').show();
                compter();
                break;
            case 12 :
                $('#taupe6P').show();
                compter();
                break;
            case 13 :
                $('#taupeP').show();
                $('#taupeArriere').show();
                compter();
                ;
                break;
            case 14 :
                $('#taupe2P').show();
                $('#taupeArriere2').show();
                compter();
                ;
                break;
            case 15 :
                $('#taupe3P').show();
                $('#taupeArriere3').show();
                compter();
                ;
                break;
            case 16 :
                $('#taupe4P').show();
                $('#taupeArriere4').show();
                compter();
                ;
                break;
            case 17 :
                $('#taupe5P').show();
                $('#taupeArriere5').show();
                compter();
                ;
                break;
            case 18 :
                $('#taupe6P').show();
                $('#taupeArriere6').show();
                compter();
                ;
                break;
            default:
        }

        cacher();
        jouer();
    }
    function  jouer() {
        setTimeout(jouerExecuter, 2500); //On attend 5 secondes avant d'exécuter la fonction
    }
    function jouerExecuter() {
        tours++;
        boolean = false;
        if(vies !== 0) {
            var nbrAleatoire = Math.floor(Math.random() * (19 - 1) + 1);

            switch (nbrAleatoire) {
                case 1 :
                    $('#bombeP').show();
                    break;
                case 2 :
                    $('#bombe2P').show();
                    break;
                case 3 :
                    $('#bombe3P').show();
                    break;
                case 4 :
                    $('#bombe4P').show();
                    break;
                case 5 :
                    $('#bombe5P').show();
                    break;
                case 6 :
                    $('#bombe6P').show();
                    break;
                case 7 :
                    $('#taupeP').show();
                    compter();
                    break;
                case 8 :
                    $('#taupe2P').show();
                    compter();
                    break;
                case 9 :
                    $('#taupe3P').show();
                    compter();
                    break;
                case 10 :
                    $('#taupe4P').show();
                    compter();
                    break;
                case 11 :
                    $('#taupe5P').show();
                    compter();
                    break;
                case 12 :
                    $('#taupe6P').show();
                    compter();
                    break;
                case 13 :
                    $('#taupeP').show();
                    $('#taupeArriere').show();
                    compter();
                    ;
                    break;
                case 14 :
                    $('#taupe2P').show();
                    $('#taupeArriere2').show();
                    compter();
                    ;
                    break;
                case 15 :
                    $('#taupe3P').show();
                    $('#taupeArriere3').show();
                    compter();
                    ;
                    break;
                case 16 :
                    $('#taupe4P').show();
                    $('#taupeArriere4').show();
                    compter();
                    ;
                    break;
                case 17 :
                    $('#taupe5P').show();
                    $('#taupeArriere5').show();
                    compter();
                    ;
                    break;
                case 18 :
                    $('#taupe6P').show();
                    $('#taupeArriere6').show();
                    compter();
                    ;
                    break;
                default:
            }
            //////////////////////////////////////////////
        }
        cacher();
        if(vies !== 0){
            jouer();
        }
    }
    });

