jQuery(document).ready(function() {
    // Récupère le ticket vierge qui contient la collection
    $collectionHolder = $('#commande_tickets');

    // Ajoute un lien de suppression pour l'élément ticket
    $collectionHolder.find('div').each(function() {
        addTicketFormDeleteLink($(this));
    });

    // ... the rest of the block from above
});

function addTicketForm() {
    // ...

    // Ajoute un lien de suppression au nouveau formulaire
    addTicketFormDeleteLink($newFormLi);
}


function addTicketFormDeleteLink($ticketFormLi) {
    var $removeTicketLink = $('<a href="#" class="remove_ticket_link btn btn-default btn-sm amber darken-2 col offset-s8">Retirer une personne<i class="material-icons right">close</i></a>');
    $ticketFormLi.append($removeTicketLink);

    $removeTicketLink.on('click', function(e) {
        // empêche le lien de créer un # sur l'URL
        e.preventDefault();

        // supprimer le formulaire ticket
        $ticketFormLi.remove();
    });
}