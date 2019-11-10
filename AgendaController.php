<?php

namespace App\Controller;

use App\Calendar;
use App\Events as event;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    /**
     * @Route("/agenda", name="agenda")
     */
    public function index(EventsRepository $repoevent)
    {
        try{
            $date = new Calendar(isset($_GET['month']) ? $_GET['month'] : null, isset($_GET['year']) ? $_GET['year'] : null );
        } catch(\Exception $e){
            $date = new Calendar();
        }


        $firstmonday = $date->getstartday();
        if($firstmonday->format("w") == 1){
            $firstmonday = $firstmonday->modify("-1 days");
        }
        else{
            $firstmonday = $firstmonday->modify('last monday -1 days');
        }

        
        $events = new event($repoevent);
        $liste_event = $events->geteventbetweenbyday($date->getstartday(), $date->getlastday());
        

        return $this->render('agenda/index.html.twig', [
            'date' => $date,
            'title' => 'Agenda',
            'firstmonday' => $firstmonday,
            'liste_event' => $liste_event
        ]);
    }
}
