<?php

namespace App;

use DateTime;
use Exception;



class Calendar{

    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;
    public  $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];




    /**
     * @param int $month
     * @param int $year
     * @throws Exception
     */
    public function __construct(int $month = null, int $year = null)
    {


        if($month === null){
            $month = intval(date('m'));
        }


        if($year === null){
            $year = intval(date('Y'));
        }


        if($month < 1 || $month > 12){
            throw new Exception("le mois n'est pas valide");
        }


        if($year < 1970){
            throw new Exception("l'année est inférieur a 1970");
        }


        $this->month = $month;
        $this->year = $year;
    }

    /**
     * return le premier jours du mois
     * @return \Datetime
     */
    public function getstartday(){
        return new DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * @return \Datetime
     */
    public function getlastday(){
        $lastday = $this->getstartday()->modify("last day of");
        return $lastday;
    }


    /**
     * return le mois en toute lettre
     * @return string
     */
    public function tostring() {
        return $this->months[$this->month - 1 ]. ' ' . $this->year;
    }

    /**
     * @return int
     */
    public function getweeks(){
        $start = $this->getstartday();
        $StartDay = intval( $start->format("w"));
        $NumOfDays = intval( (clone $start)->modify("last day of")->format("d") );
        $TDays = $NumOfDays + $StartDay;
        $NumDayInLastWeek =  6 - intval( (clone $start)->modify("last day of")->format("w") );
        $weeks =  ($TDays + $NumDayInLastWeek) / 7;

        if($start->format("w") == 0)
            return $weeks + 1;
        else
            return $weeks;
    }


    /**
     * @param \Datetime
     * @return bool
     */
    public function inmonth(DateTime $date){
        return $this->getstartday()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * @return \Month
     */
    public function nextmonth(){
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12){
            $month = 1;
            $year = $year + 1;
        }
        return new Calendar($month, $year);
    }

    /**
     * @return \Month
     */
    public function previousmonth(){
        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1){
            $month = 12;
            $year = $year - 1;
        }
        return new Calendar($month, $year);
    }
}