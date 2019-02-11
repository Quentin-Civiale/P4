<?php

namespace Louvre\GeneralBundle\Services;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TicketPriceCalculator extends Controller
{
    public function calculate(Ticket $ticket, Booking $booking, ContainerInterface $container): int
    {
        $childPrice = $container->getParameter('child_price');
        $normalPrice = $container->getParameter('normal_price');
        $seniorPrice = $container->getParameter('senior_price');
        $reducePrice = $container->getParameter('reduced_price');
        $halfPrice = $container->getParameter('half_price');
        $freePrice = $container->getParameter('free_price');

        $childAgeMin = $container->getParameter('children.min');
        $childAgeMax = $container->getParameter('children.max');
        $adultAgeMin = $container->getParameter('adult.min');
        $adultAgeMax = $container->getParameter('adult.max');
        $seniorAgeMin = $container->getParameter('senior.min');
        $seniorAgeMax = $container->getParameter('senior.max');


        /** @var $dateDeNaissance \DateTime * */
        $birthdate = $ticket->getDateNaissance();
//        $birthdateTicket = new \DateTime($birthdate);
        $today = new \DateTime('now');
        $age = $birthdate->diff($today)->y;
//        $age = date_diff($birthdate, $today)->y;
        $price = 0;
        $priceCoef = 1;

        /* @var $tarifReduit Ticket **/

        if ($booking->getType() == 'demi-journee') {
            $priceCoef = $halfPrice;
        }

        switch (true) {
            case $age >= $childAgeMin && $age < $childAgeMax:
                $price = $childPrice;
                break;
            case $age < $childAgeMin:
                $price = $freePrice;
                break;
            case $age >= $adultAgeMin && $age < $adultAgeMax:
                $price = $normalPrice;
                break;
            case $age >= $seniorAgeMin:
                $price = $seniorPrice;
                break;
            default:
                break;
        }

        if ($ticket->isTarifReduit()) {
            //Tarif réduit pour les personnes ayant un justificatif
            $reducedPrice = $reducePrice;
            $price = min($price, $reducedPrice);
        }

        return $price * $priceCoef;
    }
}
