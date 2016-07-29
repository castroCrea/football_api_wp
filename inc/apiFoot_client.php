<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 11:32
 */
use Model\dataModel\dataModel;

class apiFoot_client
{
    private $ip = '127.0.0.1';

    public function __construct()
    {
        $this->run();
    }

    /**
     * To call the template in you page template call function :
     *      getStandingPage  -> for standing
     *      getMatchPage  -> for match
     * url :
     *      %url%?updateCompetition -> update competition
     *      %url%?updateStanding -> update standing (classement)
     *      %url%?updateTeam -> update team
     *      %url%?updateMatch -> update matchs from all competition
     *      %url%?cleanDB -> clean Data base
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

        if(!is_admin()){
            /**
             * Update url for the cron, is in double from class addmin because here, in client part, I block the creation of a table
             */
            $dataModel = new \Model\dataModel\dataModel();

            /**
             * get the token with is set at the creation of option api table it's use to secure the update
             */
            $token = $dataModel->getToken();

            /**
             * Update the competition
             */
            if((isset($_GET['insertCompetition']) && $_SERVER['SERVER_ADDR'] == $this->ip) || (isset($_GET['insertCompetition']) && $_GET['token'] == $token->meta_value)){
                $dataModel = new \Model\dataModel\dataModel();
                $dataModel->insertCompetition();
            }
            /**
             * Update the standing (classement)
             */
            if((isset($_GET['updateStanding']) && $_SERVER['SERVER_ADDR'] == $this->ip) || (isset($_GET['updateStanding']) && $_GET['token'] == $token->meta_value)){
                $dataModel = new \Model\dataModel\dataModel();
                $dataModel->insertUpdateStanding();
            }
            /**
             * Update the team
             */
            if((isset($_GET['updateTeam']) && $_SERVER['SERVER_ADDR'] == $this->ip) || (isset($_GET['updateTeam']) && $_GET['token'] == $token->meta_value)){
                $dataModel = new \Model\dataModel\dataModel();
                $dataModel->insertUpdateTeams();
            }
            /**
             * Update the match
             */
            if((isset($_GET['updateMatch']) && $_SERVER['SERVER_ADDR'] == $this->ip) || (isset($_GET['updateMatch']) && $_GET['token'] == $token->meta_value)){
                $dataModel = new \Model\dataModel\dataModel();
                $dataModel->insertUpdateMatch();
            }
            /**
             * Update the team
             */
            if((isset($_GET['cleanDB']) && $_SERVER['SERVER_ADDR'] == $this->ip) || (isset($_GET['cleanDB']) && $_GET['token'] == $token->meta_value)){
                $this->cleanDB();
            }
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