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
    var $newFormLi = $('<div class="ticketForm"><br/><hr/><h5>Billet N°</h5></div>').append(newForm);

    $newLinkLi.prepend($newFormLi);
}

jQuery(document).ready(function() {
    debugger
    // Récupère le ticket vierge qui contient la collection
    $collectionHolder = $('#commande_tickets');

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


