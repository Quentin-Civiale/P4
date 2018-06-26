var $collectionHolder;

// configure le lien "Ajouter une personne"
var $addTicketLink = $('<a href="#" class="add_ticket_link btn btn-default btn-sm amber darken-2 col offset-s4">Ajouter une personne<i class="material-icons right">person_add</i></a>');
var $newLinkLi = $('<div></div>').append($addTicketLink);


function addTicketForm($collectionHolder, $newLinkLi) {
    // Récupère le prototype de données
    var prototype = $collectionHolder.data('prototype');

    // obtention du nouvel index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    // augmente l'index avec un pour l'élément suivant
    $collectionHolder.data('index', index + 1);

    // Affiche le formulaire dans la page dans un div, avant le lien
    var $newFormLi = $('<div class="ticketForm"><br/><br/><hr/><h5>Billet N°</h5></div>').append(newForm);

    $newLinkLi.before($newFormLi);

    // Ajoute un lien de suppression au nouveau formulaire
    addTicketFormDeleteLink($newFormLi);
}


jQuery(document).ready(function() {
    // Récupère le ticket qui contient la collection
    $collectionHolder = $('#booking_tickets');

    // ajoute "Ajouter une personne" et le div
    $collectionHolder.append($newLinkLi);

    // compte les entrées actuelles du formulaire
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTicketLink.on('click', function(e) {
        // empêche le lien de créer un "#" sur l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire
        addTicketForm($collectionHolder, $newLinkLi);
    });
});


function addTicketFormDeleteLink($ticketFormLi) {
    var $removeTicketLink = $('<a href="#" class="remove_ticket_link btn btn-default btn-sm red darken-2 col offset-s4">Supprimer ce billet<i class="material-icons right">close</i></a>');
    $ticketFormLi.append($removeTicketLink);

    $removeTicketLink.on('click', function(e) {
        // empêche le lien de créer un # sur l'URL
        e.preventDefault();

        // supprimer le formulaire ticket
        $ticketFormLi.remove();
    });
}



