<?php

namespace Louvre\GeneralBundle\Services;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;

class TicketPriceCalculator
{
    const REDUCED_PRICE = 10;
    const SENIOR_PRICE = 12;
    const NORMAL_PRICE = 16;
    const CHILD_PRICE = 8;
    const HALF_PRICE = 1 / 2;
    const FREE_PRICE = 0;

    public function calculate(Ticket $ticket, Booking $booking): int
    {
        /** @var $dateDeNaissance \DateTime * */
        $dateDeNaissance = $ticket->getDateNaissance();
        $to = new \DateTime('today');
        $age = $dateDeNaissance->diff($to)->y;
        $price = 0;
        $priceCoef = 1;

        /* @var $tarifReduit Ticket **/

        if ($booking->getType() == 'demi-journee') {
            $priceCoef = self::HALF_PRICE;
        }

        switch (true) {
            case $age >= 4 && $age < 12:
                $price = self::CHILD_PRICE;
                break;
            case $age < 4:
                $price = self::FREE_PRICE;
                break;
            case $age >= 12 && $age < 60:
                $price = self::NORMAL_PRICE;
                break;
            case $age > 60:
                $price = self::SENIOR_PRICE;
                break;
            default:
                break;
        }

        if ($ticket->isTarifReduit()) {
            //Tarif réduit pour les personnes ayant un justificatif
            $reducedPrice = self::REDUCED_PRICE;
            $price = min($price, $reducedPrice);
        }

        return $price * $priceCoef;
    }
}
