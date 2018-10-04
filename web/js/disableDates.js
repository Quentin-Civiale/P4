$('.datepicker').pickadate({
    firstDay: 1,
    disable: [
        2,
        [2018,4,1],
        [2018,10,1],
        [2018,11,25],
    ],
    min: "0",
    cancel: 'Annuler',
    clear: 'Retour',
    done: 'Ok',
    close: 'Ok',
    today: 'Auj.',
    format: 'dd/mm/yyyy',
    monthsFull:
        [
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre'
        ],
    monthsShort:
        [
            'Jan',
            'Fév',
            'Mar',
            'Avr',
            'Mai',
            'Jun',
            'Jul',
            'Aoû',
            'Sep',
            'Oct',
            'Nov',
            'Déc'
        ],
    weekdaysFull:
        [
            'Dimanche',
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi'
        ],
    weekdaysShort:
        [
            'Dim',
            'Lun',
            'Mar',
            'Mer',
            'Jeu',
            'Ven',
            'Sam'
        ],
    weekdaysLetter:	['D','L','M','M','J','V','S']
});

$('.datepickerBirthday').pickadate({
    selectMonths: true,
    // format: 'mm',
    selectYears: 100,
    // format: 'yyyy',
    buttonImageOnly: false,
    // disable: [true],
    onOpen: function() {
        $(".picker__nav--prev, .picker__nav--next").remove();
    },
    firstDay: 1,
    max: "now",
    cancel: 'Annuler',
    clear: 'Retour',
    done: 'Ok',
    close: 'Ok',
    today: 'Auj.',
    format: 'dd/mm/yyyy',
    monthsFull:
        [
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre'
        ],
    monthsShort:
        [
            'Jan',
            'Fév',
            'Mar',
            'Avr',
            'Mai',
            'Jun',
            'Jul',
            'Aoû',
            'Sep',
            'Oct',
            'Nov',
            'Déc'
        ],
    weekdaysFull:
        [
            'Dimanche',
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi'
        ],
    weekdaysShort:
        [
            'Dim',
            'Lun',
            'Mar',
            'Mer',
            'Jeu',
            'Ven',
            'Sam'
        ],
    weekdaysLetter:	['D','L','M','M','J','V','S']
});