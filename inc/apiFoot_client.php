<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 11:32
 */
use Model\dataModel\dataModel;

//TODO : Match create match in function of day and competition

class apiFoot_client
{

    public function __construct()
    {
        $this->run();
    }

    private function run()
    {
        if(isset($_POST['StandingCompetition']) && $_POST['StandingCompetition']){
            $this->getStandingPage();
        }
    }

    public function getStandingPage(){
        $dataModel = new \Model\dataModel\dataModel();
        $competitions = $dataModel->getAllCompetitionsFromDB(false,1);

        if(isset($_POST['comp_id']) && is_numeric($_POST['comp_id'])){
            /**
             * get with ajax
             */
            $comp_id = $_POST['comp_id'];

        }else{
            /**
             * By Default First competition in the order put in the back office
             */
            $comp_id = $competitions[0]->id;
        }

        $standing = $dataModel->getStandingFromCompId($comp_id);

        include_once (__DIR__.'/../template/standing.php');
    }

    public function getMatchPage(){
        $dataModel = new \Model\dataModel\dataModel();
        $competitions = $dataModel->getAllCompetitionsFromDB(false,1);

        if(isset($_POST['comp_id']) && is_numeric($_POST['comp_id'])){
            /**
             * get with ajax
             */
            $comp_id = $_POST['comp_id'];

        }else{
            /**
             * By Default First competition in the order put in the back office
             */
            $comp_id = $competitions[0]->id;
        }

        $standing = $dataModel->getStandingFromCompId($comp_id);

        include_once (__DIR__.'/../template/match.php');
    }
}