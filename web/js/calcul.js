// function calculAge(dateNaissance) {
//     var dateCourante = new Date().getFullYear();
//
//     return dateCourante - dateNaissance;
// }
// document.write('Votre ageVisiteur est de : ' + calculAge(1991) + ' ans !' + "<BR>");
//
//
//
//
// // alert("connecté !");
//
// function calculAgeJour(jourNaissance) {
//     var jourCourante = new Date().getDate();
//
//     return jourCourante - jourNaissance;
// }
// function calculAgeMois(moisNaissance) {
//     var moisCourante = new Date().getMonth();
//
//     return moisCourante - moisNaissance;
// }
// function calculAgeAnnee(anneeNaissance) {
//     var anneeCourante = new Date().getFullYear();
//
//     return anneeCourante - anneeNaissance;
// }
// document.write('Votre ageVisiteur est de : ' + (calculAgeAnnee(1991)-1) + ' ans, ' + (calculAgeMois(5)+1) + ' mois et ' + calculAgeJour(20) + ' jours !' + "<BR>");
//
//
//
// var today = new Date();
// document.write("Nous sommes le : ");
// document.write(today.getDate() + "/" + (today.getMonth()+1) + "/" + today.getFullYear() + "<BR>");
// var tab_mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
// document.write("Nous sommes en " + tab_mois[today.getMonth()] + "<BR>");
//
//
//
// var dt = new Date();
// var day = dt.getDate();
// var month = dt.getMonth()+1;
// var year = dt.getFullYear();
// document.write(day + '/' + month + '/' + year + "<BR>");




var dateNaissance = new Date("5/20/1991");
var dateCourante = new Date();
var ageVisiteur = dateCourante.getFullYear() - dateNaissance.getFullYear();

// Réinitialiser dateNaissance vers dateCourante.
dateNaissance.setFullYear(dateCourante.getFullYear());

// Si la dateNaissance de l'utilisateur ne s'est pas encore produite cette année, enlever 1.
if (dateCourante < dateNaissance)
{
    ageVisiteur--;
}
document.write("Calcul de l'âge : " + ageVisiteur + " ans.");


function verifAge(ageVisiteur) {
    var age = ageVisiteur;
    var tNormal = 16;
    var tEnfant = 8;
    var tSenior = 12;
    var tReduit = 10;

    if((age >= 4) && (age < 12)) {
        document.write("Entrée à " + tEnfant + " euros.");
    }else if ((age >= 12) && (age < 60)) {
        document.write("Entrée à " + tNormal + " euros.");
    }else if (age > 60) {
        document.write("Entrée à " + tSenior + " euros.");
    }else {
        document.write("Entrée à " + tReduit + " euros.");
    }
}

verifAge();

var BilletDeBase = 1;
var BilletEnPlus = BilletDeBase+1;
// var BilletTotal = BilletDeBase + BilletEnPlus;
document.write("Billet N°" + BilletEnPlus);

