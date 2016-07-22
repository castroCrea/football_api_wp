<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 11:32
 */
use Model\dataModel\dataModel;

//TODO : css

class apiFoot_client
{

    public function __construct()
    {
        $this->run();
    }

    /**
     * To call the template in you page template call function :
     *      getStandingPage  -> for standing
     *      getMatchPage  -> for match
     */
    private function run()
    {
        /**
         * Done for the ajax standing in competition
         */
        if(isset($_POST['StandingCompetition']) && $_POST['StandingCompetition']){
            $this->getStandingPage();
        }

        /**
         * Done for the week of match and competition
         */
        if(isset($_POST['MatchCompetition']) && $_POST['MatchCompetition']){
            $this->getMatchPage();
        }
    }

    /**
     * Template page for standing (classement)
     */

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

        include_once (__DIR__.'/../template/standing-page.php');
    }

    /**
     * template page for matchs
     */
    public function getMatchPage(){
        $dataModel = new \Model\dataModel\dataModel();
        $competitions = $dataModel->getAllCompetitionsFromDB(false,1);

        if(isset($_POST['comp_id']) && is_numeric($_POST['comp_id']) && isset($_POST['week']) && is_numeric($_POST['week'])){
            /**
             * get with ajax
             */
            $comp_id = $_POST['comp_id'];
            $currentWeek = $_POST['week'];
            $allMatch = $dataModel->getAllMatchFormCompIdAndDay($comp_id, $currentWeek);

        }elseif(isset($_POST['comp_id']) && is_numeric($_POST['comp_id'])){
            /**
             * get with ajax
             */
            $comp_id = $_POST['comp_id'];
            $currentWeek = $dataModel->getCurrentWeek($comp_id);
            $allMatch = $dataModel->getAllMatchFormCompIdAndDay($comp_id);

        }else{
            /**
             * By Default First competition in the order put in the back office
             */
            $comp_id = $competitions[0]->id;
            $currentWeek = $dataModel->getCurrentWeek($comp_id);
            $allMatch = $dataModel->getAllMatchFormCompIdAndDay($comp_id);
        }

        $weeks = $dataModel->getWeeksOfComp($comp_id);


        include_once (__DIR__.'/../template/match-page.php');
    }
}