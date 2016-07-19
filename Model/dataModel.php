<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 11:32
 */

//TODO : Match in database create data base , update and insert
//TODO : Remove FROM database old update entries more than a year
//TODO : button to update in function of the query string choosen
//TODO : Option table for api, with the key and the ip for the cron
//TODO : create token to update all and add to admin part
//TODO : create template to the render of the pages
//TODO : create standing in function of competition
//TODO : Match create match in function of day and competition

namespace Model\dataModel;

use Model\apiFootModel;

class dataModel
{

    /**
     * create Competiton Tale
     * if you want to add a colum just add here and update with the good query
     */
    public function createCompetitionTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "competition";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                region varchar(255),
                status tinyint(1) DEFAULT 0 NOT NULL,
                last_update int(11) DEFAULT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * create Standing Table
     * if you want to add a colum just add here and update with the good query
     */
    public function createStandingTable(){
        global $wpdb;

        $table_name = $wpdb->prefix . "standing";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                id_competition mediumint(9) NOT NULL,
                id_team mediumint(9) NOT NULL,
                id_stage mediumint(9) NOT NULL,
                team_name varchar(255) NOT NULL,
                comp_group varchar(255) DEFAULT NULL,
                position tinyint(2) NOT NULL,
                status varchar(20) DEFAULT 'same',
                point tinyint(2) DEFAULT 0 NOT NULL,
                round tinyint(2) DEFAULT 0 NOT NULL,
                overall_w tinyint(3) DEFAULT 0 NOT NULL,
                overall_d tinyint(3) DEFAULT 0 NOT NULL,
                overall_l tinyint(3) DEFAULT 0 NOT NULL,
                gd tinyint(3) DEFAULT 0 NOT NULL,
                season varchar(12) NOT NULL,
                last_update int(11) DEFAULT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * create Team Table
     * if you want to add a colum just add here and update with the good query
     */
    public function createTeamTable(){
        global $wpdb;

        $table_name = $wpdb->prefix . "team";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                country varchar(255) NOT NULL,
                founded varchar(255) NOT NULL,
                leagues varchar(255) NOT NULL,
                venue_name varchar(255) DEFAULT NULL,
                venue_city varchar(255) DEFAULT NULL,
                coach_name varchar(255) DEFAULT NULL,
                coach_id mediumint(9) DEFAULT NULL,
                transfers_in text DEFAULT NULL,
                transfers_out text DEFAULT NULL,
                last_update int(11) DEFAULT NULL,
                image varchar(255) DEFAULT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * Insert a competition
     */
    public function insertCompetition(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'competition';

        $apiFoot = new \Model\apiFootModel\apiFootModel();
        $competitions = $apiFoot->getAllCompetitions();

        foreach($competitions as $oneCompetition){

            $competition_id = $oneCompetition->id;

            $retour = $this->getCompetitionById($competition_id);

            if(!$retour){
                $wpdb->insert(
                    $table_name,
                    array(
                        'id' => $competition_id,
                        'name' => $oneCompetition->name,
                        'region' => $oneCompetition->region,
                        'status' => 0,
                        'last_update' => time(),
                    )
                );
            }
        }
    }

    /**
     * Insert and update a standing
     */
    public function insertUpdateStanding(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'standing';

        $competitions = $this->getAllCompetitionsFromDB(false, 1);

        /**
         * if the table doesn't exist i create it, insert the competition and get the competition with status 1 (normaly the are all set to 0)
         */
        if(!$competitions){
            $this->createCompetitionTable();
            $this->insertCompetition();
            return false;
        }

        $apiFoot = new \Model\apiFootModel\apiFootModel();

        foreach($competitions as $oneCompetition){

            $competition_id = $oneCompetition->id;

            $standing = $apiFoot->getStandingCompetition($competition_id);

            foreach($standing as $team){

                $teamVerif = $this->getTeamStanding($team->comp_id, $team->team_id);

                if(!$teamVerif){
                    $wpdb->insert(
                        $table_name,
                        array(
                            'id_competition' => $team->comp_id,
                            'id_stage' => $team->stage_id,
                            'id_team' => $team->team_id,
                            'team_name' => $team->team_name,
                            'comp_group' => $team->comp_group,
                            'position' => $team->position,
                            'status' => $team->status,
                            'point' => $team->points,
                            'overall_w' => $team->overall_w,
                            'overall_d' => $team->overall_d,
                            'overall_l' => $team->overall_l,
                            'gd' => $team->gd,
                            'season' => $team->season,
                            'last_update' => time(),
                        )
                    );
                }else{
                    var_dump(time());
                    $wpdb->update(
                        $table_name,
                        array(
                            'id_stage' => $team->stage_id,
                            'team_name' => $team->team_name,
                            'comp_group' => $team->comp_group,
                            'position' => $team->position,
                            'status' => $team->status,
                            'point' => $team->points,
                            'overall_w' => $team->overall_w,
                            'overall_d' => $team->overall_d,
                            'overall_l' => $team->overall_l,
                            'gd' => $team->gd,
                            'season' => $team->season,
                            'last_update' => time(),	// integer
                        ),
                        array( 'id' => $teamVerif->id ),
                        array(
                            '%d'	// value2
                        )
                    );
                }
            }
        }
    }

    /**
     * Insert and update a team in function of the standing because standing are taken in relation of status one competition and we don't want the team out of a choosen competition
     */
    public function insertUpdateTeams(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'team';

        $allStanding = $this->getStandingFromDb();

        /**
         * if the table doesn't exist i create it, insert the competition and get the competition with status 1 (normaly the are all set to 0)
         */
        if(!$allStanding){
            $this->createCompetitionTable();
            $this->insertCompetition();
            return false;
        }

        $apiFoot = new \Model\apiFootModel\apiFootModel();

        foreach($allStanding as $standing){

            $id_team = $standing->id_team;

            $teamVerif = $this->getTeamById($id_team);
            $team = $apiFoot->getTeam($id_team);

            if(!$teamVerif){
                $wpdb->insert(
                    $table_name,
                    array(
                        'id' => $team->team_id,
                        'name' => $team->name,
                        'country' => $team->country,
                        'founded' => $team->founded,
                        'leagues' => $team->leagues,
                        'venue_name' => $team->venue_name,
                        'venue_city' => $team->venue_city,
                        'coach_name' => $team->coach_name,
                        'coach_id' => $team->coach_id,
                        'transfers_in' =>json_encode($team->transfers_in),
                        'transfers_out' => json_encode($team->transfers_out),
                        'last_update' => time(),
                    )
                );
            }else{
                $wpdb->update(
                    $table_name,
                    array(
                        'name' => $team->name,
                        'country' => $team->country,
                        'founded' => $team->founded,
                        'leagues' => $team->leagues,
                        'venue_name' => $team->venue_name,
                        'venue_city' => $team->venue_city,
                        'coach_name' => $team->coach_name,
                        'coach_id' => $team->coach_id,
                        'transfers_in' =>json_encode($team->transfers_in),
                        'transfers_out' => json_encode($team->transfers_out),
                        'last_update' => time(),	// integer
                    ),
                    array( 'id' => $teamVerif->id ),
                    array(
                        '%d'	// value2
                    )
                );
            }
        }
    }

    /**
     * get all competition from data base
     * @param bool $i (set to block the infinit loop)
     * @return mixed|bool
     */
    public function getAllCompetitionsFromDB($i = false, $status = null){
        if(!$i){
            global $wpdb;

            $table_name = $wpdb->prefix . 'competition';

            if(is_numeric($status)){
                $competition = $wpdb->get_results('SELECT * FROM '. $table_name . ' WHERE status = ' . $status);
            }else{
                $competition = $wpdb->get_results('SELECT * FROM '. $table_name);
            }

            if($competition != null){
                return $competition;
            }else{
                /**
                 * if there is not competiton we create data base, insert from api et do again this function
                 */
                $this->createCompetitionTable();
                $this->insertCompetition();
                $this->getAllCompetitionsFromDB(true);
            }
        }
        return false;
    }

    /**
     * get competition by is id
     * @param $id
     * @return bool
     */
    public function getCompetitionById($id){
        if(is_numeric($id)){
            global $wpdb;

            $table_name = $wpdb->prefix . 'competition';

            $competition = $wpdb->get_results('SELECT * FROM '. $table_name . ' WHERE id =' . $id);

            if($competition != null){
                return $competition;
            }
        }
        return false;
    }

    public function getStandingFromDb(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'standing';

        $competition = $wpdb->get_results('SELECT * FROM '. $table_name);

        if($competition != null){
            return $competition;
        }
        return false;
    }

    /**
     * get the team position in a competition, mostly use to update the standing
     * @param $competition_id
     * @param $team_id
     * @return bool
     */
    private function getTeamStanding($competition_id, $team_id){
        if(is_numeric($team_id) && is_numeric($competition_id)){
            global $wpdb;

            $table_name = $wpdb->prefix . 'standing';

            $competition = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE id_competition =' . $competition_id .' AND id_team = ' . $team_id);

            if($competition != null){
                return $competition;
            }
        }
        return false;
    }

    /**
     * get the team
     * @param $competition_id
     * @param $team_id
     * @return bool
     */
    public function getTeamById($team_id){
        if(is_numeric($team_id)){
            global $wpdb;

            $table_name = $wpdb->prefix . 'team';

            $competition = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE id = '. $team_id);

            if($competition != null){
                return $competition;
            }
        }
        return false;
    }

    /**
     * Update the status of a competition
     * @param $id
     * @param $status
     */

    public function updateCompetitionStatus($id, $status){
        if(is_numeric($id) && is_numeric($status)){

            global $wpdb;

            $table_name = $wpdb->prefix . 'competition';

            $id_return = $wpdb->update(
                $table_name,
                array(
                    'status' => $status,	// integer
                    'last_update' => time(),	// integer
                ),
                array( 'id' => $id ),
                array(
                    '%d'	// value2
                )
            );
            if(is_numeric($id_return)){
                return true;
            }
            return false;
        }
        return false;
    }

}