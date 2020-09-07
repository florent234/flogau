//différentes variables dont j'ai besoin
var vitesseJeuMS;
var scoreJeu;
var topFond;
var leftFond;
var cpt;
leftmin=280;
leftmax=580;
tophide=topFond +5;
topshow=topFond -50;
var  nbrAleatoire =Math.floor(Math.random()*3)+1
//var  nbrAleatoire = Math.random() * (leftmax - leftmin) + leftmin;
//alert(nbrAleatoire);

// Evènement chargé qu'une fois la page elle même chargé
$(document).ready(function()
{
    $('.taupe').hide();
    //la vitesse du jeu est de 1000ms
    vitesseJeuMS = 1000;
    // Calcul du centre largeur (Taille Document - Taille Element / 2)
     leftFond = ($(document).width() - $("#fondJeu").width()) / 2;
  //  leftFond = $("#fondJeu").width()) ;
    // Calcul du centre hauteur (Taille Document - Taille Element / 2)
    topFond = ($(document).height() - $("#fondJeu").height()) / 2;
   // topFond = $("#fondJeu").height();

    $("#fondJeu").offset({ top: topFond + 15, left: leftFond });

    //lorsqu'on clique sur le bouton, le jeu commence
    $("#btCommencer").click(function()
    {
        commencerJeu();
    });

    //lorsqu'on clique sur la taupe, le score augmente
    $(".taupe").click(function()
    {
        //augmentation du score lorsque l'on clique sur la taupe
        $("#score").html("Score: " + scoreJeu++);
        $('.taupe').hide();
        $(".taupe").delay(1000);
        continuerJeu();
    });
});

//La fonction commencerJeu démarrera lorsque l'on clique sur un bouton
function commencerJeu()
{
    $('.taupe').show();
    //le score du jeu débute a 0
    scoreJeu = 0;

    $(".taupe").offset({ top: topFond -50 , left:  nbrAleatoire });
    //Cela laisse 20 essais
    for(cpt = 0; cpt < 20; cpt++)
    {
        $(".taupe").offset({ top: topFond - 50, left: nbrAleatoire });
        //animate permet d'animer le jeu avec la vitesse inscrite
        $(".taupe").animate({top: "+=40"}, vitesseJeuMS);
        $(".taupe").delay(1000);
        $(".taupe").animate({top: "-=50"}, vitesseJeuMS, function()
        {
            //génération du nb aléatoire
            nbrAleatoire = Math.random() * (leftmax - leftmin) + leftmin;
            //alert(nbrAleatoire);
            $(".taupe").offset({ top: topFond + 50 , left:  nbrAleatoire });
        });
    }
};

//La fonction commencerJeu démarrera lorsque l'on clique sur un bouton
function continuerJeu()
{
    $(".taupe").offset({ top:topFond+5, left: leftFond+nbrAleatoire });
    $(".taupe").hide();
    //Cela laisse 20 essais
    for(cpt; cpt < 20; cpt++)
    {
        /**
         * @brief offset permet d'obtenir les coordonnées actuelle du 1er élement
         * ou de définir les coordonnées de chaque élément
         * dans l'ensemble des éléments appariés par rapport au doc
         */
        //animate permet d'animer le jeu avec la vitesse inscrite
        $(".taupe").animate({top: "-=60"}, vitesseJeuMS);
        //$(".taupe").delay(1000);
        $(".taupe").animate({top: "+=60"}, vitesseJeuMS, function()
        {
            //génération du nb aléatoire
            nbrAleatoire = Math.floor((Math.random() * 400));
            $(".taupe").offset({ top: topFond+5, left:  leftFond+nbrAleatoire });
        });
    }
    $(".taupe").show();
};