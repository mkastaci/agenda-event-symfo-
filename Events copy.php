<?php

namespace App;

use App\Repository\EventsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Events extends AbstractController{
    
    public $repoevent;


    public function __construct(EventsRepository $repoevent)
        {
            $this->repoevent = $repoevent;
        }


    /**
     * @return array
     */
    public function geteventbetweenbyday(DateTime $start, DateTime $end){
        $liste_event = $this->repoevent->findbydate($start, $end);
        $days = [];
        
        foreach($liste_event as $event){
            $date = $event->getStart()->format('Y-m-d');
            
                $days[$date][] = $event;
            
        }
        return $days;
    }
}