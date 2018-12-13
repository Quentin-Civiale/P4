var $collectionHolder;

// configure le lien "Ajouter une personne"
var $addTicketLink = $('<a href="#"  id="addTicketButton" class="add_ticket_link btn btn-default btn-sm amber darken-2 col offset-s4">Ajouter une personne<i class="material-icons right">person_add</i></a>');
var $newLinkLi = $('<div></div>').append($addTicketLink);

// configure le numéro du premier ticket à 1
var ticketNumber = 1;

function addTicketForm($collectionHolder, $newLinkLi) {
    // Récupère le prototype de données
    var prototype = $collectionHolder.data('prototype');

    // obtention du nouvel index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    // augmente l'index avec un pour l'élément suivant
    $collectionHolder.data('index', index + 1);

    // Ajoute +1 à chaque nouveau ticket de la vue
    ticketNumber++;

    // Affiche le formulaire dans un div, avant le lien et après chaque nouvel ajout de billets
    var $newFormLi = $('<div><div class="ticketForm"><h5>Billet N°'+ticketNumber+'</h5></div></div>').append(newForm);

    $newLinkLi.before($newFormLi);

    // Ajoute un lien de suppression au nouveau formulaire
    addTicketFormDeleteLink($newFormLi);

    // Initialise l'affichage du datepicker.birthday
    $('#booking_tickets_'+(ticketNumber+8)+'_dateNaissance').pickadate(
        ticketDisableDate
    );

    checkDate();
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
    var $removeTicketLink = $('<a href="#" class="remove_ticket_link btn btn-default btn-sm red darken-2 col offset-s4" style="margin-left: 34.5%"> Supprimer ce billet<i class="material-icons right">close</i></a><br/><br/>');
    $ticketFormLi.append($removeTicketLink);

    $removeTicketLink.on('click', function(e) {
        // empêche le lien de créer un # sur l'URL
        e.preventDefault();

        // supprimer le formulaire ticket
        $ticketFormLi.remove();

        // Reduit de 1 à chaque suppression de ticket sur la commande
        ticketNumber--;

        var tickets = document.getElementsByClassName("ticketForm");
        for (var i = 0; i< tickets.length; i++)
        {
            tickets[i].innerHTML = "<h5>Billet N°"+(i+1)+"</h5>";
        }

    });

    checkDate();
}



