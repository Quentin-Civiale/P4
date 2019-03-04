<?php

namespace tests\Louvre\GeneralBundle\Services;

use Louvre\GeneralBundle\Controller\BookingController;
use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Services\TicketPriceCalculator;
use PHPUnit\Framework\TestCase;

class TicketPriceCalculatorTest extends TestCase
{
    public function testCalculateBabyPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(10, 'journee');
        $date = new \DateTime('2017-05-20 00:00:00');
        $ticket = Ticket::createTicket(10, 'Civiale', 'Quentin', 'FR', $date, false);

        //        echo $ticket->getNom();
        //        echo $ticket->getPrenom();
        //        echo $ticket->getCountry();
        //        echo 'Hello !';

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(0, $calculatePrice);
    }

    public function testCalculateChildFullDayPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(11, 'journee');
        $date = new \DateTime('2011-05-20 00:00:00');
        $ticket = Ticket::createTicket(11, 'Civiale', 'Quentin', 'FR', $date, false);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(8, $calculatePrice);
    }

    public function testCalculateChildHalfDayPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(12, 'demi-journee');
        $date = new \DateTime('2011-05-20 00:00:00');
        $ticket = Ticket::createTicket(12, 'Civiale', 'Quentin', 'FR', $date, false);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(4, $calculatePrice);
    }

    public function testCalculateAdultFullDayPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(13, 'journee');
        $date = new \DateTime('1991-05-20 00:00:00');
        $ticket = Ticket::createTicket(13, 'Civiale', 'Quentin', 'FR', $date, false);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(16, $calculatePrice);
    }

    public function testCalculateAdultHalfDayPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(14, 'demi-journee');
        $date = new \DateTime('1991-05-20 00:00:00');
        $ticket = Ticket::createTicket(14, 'Civiale', 'Quentin', 'FR', $date, false);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(8, $calculatePrice);
    }

    public function testCalculateAdultFullDayReducedPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(15, 'journee');
        $date = new \DateTime('1991-05-20 00:00:00');
        $ticket = Ticket::createTicket(15, 'Civiale', 'Quentin', 'FR', $date, true);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(10, $calculatePrice);
    }

    public function testCalculateAdultHalfDayReducedPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(16, 'demi-journee');
        $date = new \DateTime('1991-05-20 00:00:00');
        $ticket = Ticket::createTicket(16, 'Civiale', 'Quentin', 'FR', $date, true);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(5, $calculatePrice);
    }

    public function testCalculateSeniorFullDayPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(17, 'journee');
        $date = new \DateTime('1950-05-20 00:00:00');
        $ticket = Ticket::createTicket(17, 'Civiale', 'Quentin', 'FR', $date, false);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(12, $calculatePrice);
    }

    public function testCalculateSeniorHalfDayPrice()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        // this line is important ↓
        $ticketPriceCalculator = $container->get(TicketPriceCalculator::class);

        $booking = new Booking();
        $booking = Booking::createBooking(18, 'demi-journee');
        $date = new \DateTime('1950-05-20 00:00:00');
        $ticket = Ticket::createTicket(18, 'Civiale', 'Quentin', 'FR', $date, false);

        $calculatePrice = $ticketPriceCalculator->calculate($ticket, $booking, $container);

        $this->assertSame(6, $calculatePrice);
    }

}
