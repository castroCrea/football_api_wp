<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 11:32
 */

use Model\apiFootModel;
use Model\dataModel;

class apiFoot_admin
{

    private $ip = '127.0.0.1';

    public function __construct()
    {
        $this->run();
    }

    /**
     * CALL FUNCTION TO ADD IN CONSTRUCT
     * url :
     * %url%?updateCompetition -> update competition
     **/
    private function run()
    {
        /**
         * Update the competition
         */
        if(isset($_GET['updateCompetition']) && $_SERVER['SERVER_ADDR'] == $this->ip){
            $dataModel = new \Model\dataModel\dataModel();
            $dataModel->createCompetitionTable();
            $dataModel->insertCompetition();
        }
        /**
         * Update the standing (classement)
         */
        if(isset($_GET['updateStanding']) && $_SERVER['SERVER_ADDR'] == $this->ip){
            $dataModel = new \Model\dataModel\dataModel();
            $dataModel->createStandingTable();
            $dataModel->insertUpdateStanding();
        }
        /**
         * Update the standing (classement)
         */
        if(isset($_GET['updateTeam']) && $_SERVER['SERVER_ADDR'] == $this->ip){
            $dataModel = new \Model\dataModel\dataModel();
            $dataModel->createTeamTable();
            $dataModel->insertUpdateTeams();
        }
        /**
         * create admin apifoot plugin page
         */
        add_action('admin_menu', array($this, 'admin_apiFoot_setup_menu'));
        /**
         * return of form adminPage
         */
        if(isset($_POST['updateCompetition'])){
            $this->updateCompetition();
        }
    }

    /**
     * Create admin page
     */

    public function admin_apiFoot_setup_menu(){
        add_menu_page( 'Api Foot', 'Api Foot', 'manage_options', 'api-foot', array($this, 'admin_apiFoot_init') );
    }

    /**
     * Administration page of apiFoot plugin
     */
    public function admin_apiFoot_init(){
        echo "<h1>".__('Selection des championnats!', 'apiFoot')."</h1>";
        $dataModel = new \Model\dataModel\dataModel();

        $allCompetition = $dataModel->getAllCompetitionsFromDB();
        include_once (__DIR__.'/../template/admin-competition.php');
    }

    public function updateCompetition(){
        $dataModel = new \Model\dataModel\dataModel();
        foreach($_POST['competition'] as $competition_id){
            $dataModel->updateCompetitionStatus($competition_id, 1);
        }
    }

}