var $collectionHolder;

// configure un lien "ajouter un ticket"
var $ajoutTicketLien = $('<a href="#" class="tickets">Ajouter un ticket</a>');
var $nouveauLienLi = $('<li></li>').append($ajoutTicketLien);

jQuery(document).ready(function() {
    // obtenir le ul qui détient la collection de balises
    $collectionHolder = $('ul.tickets');

    // ajoute l'ancre "ajouter un ticket" et li aux tags ul
    $collectionHolder.append($nouveauLienLi);

    // compte les entrées de formulaire actuelles qu'il y a (par exemple 2), utiliser cela comme nouvel
    // index lors de l'insertion d'un nouvel élément (par exemple 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $ajoutTicketLien.on('click', function(e) {
        // empêche le lien de créer un "#" sur l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire d'étiquette
        ajoutTicketForm($collectionHolder, $nouveauLienLi);
    });
});


function ajoutTicketForm($collectionHolder, $nouveauLienLi) {
    // obtenir le prototype
    var prototype = $collectionHolder.data('prototype');

    // obtenir le nouvel index
    var index = $collectionHolder.data('index');

    var nouveauForm = prototype;
    // Uniquement si le 'label' n'est pas défini => false dans le champ de tags
    // Remplace «__name__label__» dans le HTML du prototype
    // au lieu d'être un nombre basé sur combien de tickets nous avons
    // nouveauForm = nouveauForm.replace (/ __ nom__label __ / g, index);

    // Remplace «__name__» dans le HTML du prototype
    // au lieu d'être un nombre basé sur combien d'articles nous avons
    nouveauForm = nouveauForm.replace(/__name__/g, index);

    // augmente l'index avec un pour le prochain article
    $collectionHolder.data('index', index + 1);

    // Affiche le formulaire dans la page dans un li, avant le lien "Ajouter un tag"
    var $nouveauFormLi = $('<li></li>').append(nouveauForm);
    $nouveauLienLi.before($nouveauFormLi);
}

