import './bootstrap';

//  JavaScript pour contrôler l'affichage du loader
     
$(document).ready(function () {
    // Affiche le loader lorsque la page commence à charger
    $(window).on('load', function() {
        $('#loader').fadeOut();  // Cache le loader une fois que tout est chargé
    });

    // Affiche le loader pendant le chargement de la page
    $(window).on('beforeunload', function() {
        $('#loader').fadeIn();
    });
});
     