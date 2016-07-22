<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 11:32
 */

namespace Model\dataModel;

use Model\apiFootModel;


/**
 * Class dataModel
 * @package Model\dataModel
 *
 * table :
 *      option_api_foot
 *      competition
 *      standing
 *      team
 *      match
 */

class dataModel
{

    /**
     * Default api key use to try before to get the buying api key
     * @var string
     */
    private $defaultapiKey = '565eaa22251f932b9f000001d50aaf0b55c7477c5ffcdbaf113ebbda';

    /**
     * create Option Table
     * if you want to add a column just add here and update with the good query
     */
    public function createCompetitionTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "competition";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                slug_name varchar(255) NOT NULL,
                classement int(3) DEFAULT NULL,
                region varchar(255),
                status tinyint(1) DEFAULT 0 NOT NULL,
                date_from varchar(255) DEFAULT NULL,
                date_to varchar(255) DEFAULT NULL,
                season varchar(20) DEFAULT NULL,
                last_update int(11) DEFAULT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * create Match Table
     * if you want to add a column just add here and update with the good query
     */
    public function createMatchTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "match";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
                comp_id mediumint(9) NOT NULL,
                formatted_date varchar(10) NOT NULL,
                season VARCHAR(10) DEFAULT NULL,
                week int(4) DEFAULT NULL,
                venue VARCHAR(60) DEFAULT NULL,
                time VARCHAR(6) DEFAULT NULL,
                localteam_id mediumint(9) DEFAULT NULL,
                visitorteam_id mediumint(9) DEFAULT NULL,
                localteam_name VARCHAR(60) DEFAULT NULL,
                visitorteam_name VARCHAR(60) DEFAULT NULL,
                localteam_score tinyint(2) DEFAULT NULL,
                visitorteam_score tinyint(2) DEFAULT NULL,
                ht_score varchar(10) DEFAULT NULL,
                ft_score varchar(10) DEFAULT NULL,
                et_score varchar(10) DEFAULT NULL,
                penalty_local tinyint(2) DEFAULT NULL,
                penalty_visitor tinyint(2) DEFAULT NULL,
                events text DEFAULT NULL,
                last_update int(11) DEFAULT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * create Competiton Table
     * if you want to add a column just add here and update with the good query
     */
    public function createOptionApiTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "option_api_foot";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                meta_name varchar(255) NOT NULL,
                id_ref mediumint(9) DEFAULT NULL,
                meta_value varchar(255) NOT NULL,
                last_update int(11) DEFAULT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        /**
         * Look if the table is empty, if is empty set the default apikey and token
         */
        $result = $wpdb->get_results('SELECT * FROM '. $table_name);

        if($result == null){
            $this->insertDefault();
        }
    }

    /**
     * create Standing Table
     * if you want to add a column just add here and update with the good query
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
     * if you want to add a column just add here and update with the good query
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

                $slug = str_replace(' ', '-', strtolower($oneCompetition->name));

                $wpdb->insert(
                    $table_name,
                    array(
                        'id' => $competition_id,
                        'name' => $oneCompetition->name,
                        'slug_name' => $slug,
                        'region' => $oneCompetition->region,
                        'status' => 0,
                        'last_update' => time(),
                    )
                );
            }
        }
    }

    /**
     * Insert a Default Apikey witch is a test apikey from football-api.com documentation
     * Insert Token use to refresh the page vie a button
     */
    private function insertDefault(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'option_api_foot';

        /**
         * insert api key default
         */
        $wpdb->insert(
            $table_name,
            array(
                'meta_name' => 'api_key_default',
                'meta_value' => $this->defaultapiKey,
                'last_update' => time(),
            )
        );

        /**
         * insert token
         */
        $wpdb->insert(
            $table_name,
            array(
                'meta_name' => 'token',
                'meta_value' => bin2hex(random_bytes(43)),
                'last_update' => time(),
            )
        );

    }

    /**
     * update match of all selected competition
     * @return bool
     */
    public function insertUpdateMatch(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'match';

        $competitions = $this->getAllCompetitionsFromDB(false, 1);

        $apiFoot = new \Model\apiFootModel\apiFootModel();

        foreach($competitions as $oneCompetition){

            $competition_id = $oneCompetition->id;

            $matchs = $apiFoot->getMatch($competition_id, null, null, $oneCompetition->date_from, $oneCompetition->date_to);

//           echo '<pre>';
//           var_dump($matchs);
//           echo '</pre>';
//            die();

            foreach($matchs as $oneMatch){

                $matchVerif = $this->getMatchById($oneMatch->comp_id, $oneMatch->id);

                if(!$matchVerif){
                    $result = $wpdb->insert(
                        $table_name,
                        array(
                            'id' => $oneMatch->id,
                            'comp_id' => $oneMatch->comp_id,
                            'formatted_date' => strtotime(str_replace('.','-',$oneMatch->formatted_date)),
                            'season' => $oneMatch->season,
                            'week' => $oneMatch->week,
                            'venue' => $oneMatch->venue,
                            'time' => $oneMatch->time,
                            'localteam_id' => $oneMatch->localteam_id,
                            'visitorteam_id' => $oneMatch->visitorteam_id,
                            'localteam_name' => $oneMatch->localteam_name,
                            'visitorteam_name' => $oneMatch->visitorteam_name,
                            'localteam_score' => $oneMatch->localteam_score,
                            'visitorteam_score' => $oneMatch->visitorteam_score,
                            'ht_score' => $oneMatch->ht_score,
                            'ft_score' => $oneMatch->ft_score,
                            'et_score' => $oneMatch->et_score,
                            'penalty_local' => $oneMatch->penalty_local,
                            'penalty_visitor' => $oneMatch->penalty_visitor,
                            'events' => json_encode($oneMatch->events),
                            'last_update' => time(),
                        )
                    );
                }else{
                    $wpdb->update(
                        $table_name,
                        array(
                            'comp_id' => $oneMatch->comp_id,
                            'formatted_date' => strtotime(str_replace('.','-',$oneMatch->formatted_date)),
                            'season' => $oneMatch->season,
                            'week' => $oneMatch->week,
                            'venue' => $oneMatch->venue,
                            'time' => $oneMatch->time,
                            'localteam_id' => $oneMatch->localteam_id,
                            'visitorteam_id' => $oneMatch->visitorteam_id,
                            'localteam_name' => $oneMatch->localteam_name,
                            'visitorteam_name' => $oneMatch->visitorteam_name,
                            'localteam_score' => $oneMatch->localteam_score,
                            'visitorteam_score' => $oneMatch->visitorteam_score,
                            'ht_score' => $oneMatch->ht_score,
                            'ft_score' => $oneMatch->ft_score,
                            'et_score' => $oneMatch->et_score,
                            'penalty_local' => $oneMatch->penalty_local,
                            'penalty_visitor' => $oneMatch->penalty_visitor,
                            'events' => json_encode($oneMatch->events),
                            'last_update' => time(),
                        ),
                        array( 'id' => $matchVerif->id )
                    );
                }
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
                            'last_update' => time(),
                        ),
                        array( 'id' => $teamVerif->id )
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
                        /**
                         * we are modify by hand so we are not updating theme
                         * 'name' => $team->name,
                         */
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
                    array( 'id' => $teamVerif->id )
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
            global $wpdb;

            $table_name = $wpdb->prefix . 'competition';

            if(is_numeric($status)){
                $competition = $wpdb->get_results('SELECT * FROM '. $table_name . ' WHERE status = ' . $status . ' ORDER BY classement');
            }else{
                $competition = $wpdb->get_results('SELECT * FROM '. $table_name);
            }

            if($competition != null){
                return $competition;
            }else{
                if(!$i){
                /**
                 * if there is not competiton we create data base, insert from api et do again this function
                 */
                    $this->createCompetitionTable();
                    $this->insertCompetition();
                    $this->getAllCompetitionsFromDB(true, $status);
                }
            }
        return false;
    }

    /**
     * get all match from a competition
     * @param $comp_id
     * @return bool|array
     */

    public function getAllMatchFormCompIdAndDay($comp_id, $week = null){
        if(is_numeric($comp_id)){
            global $wpdb;

            $table_name = $wpdb->prefix . 'match';
            $join_name = $wpdb->prefix . 'team';

            $season = $this->getSeasonFromCompId($comp_id);

            if($week === null){
                $week = $this->getCurrentWeek($comp_id);
                if($week === false){
                    return false;
                }
            }

            if(is_numeric($week)){

                $matchs = $wpdb->get_results('SELECT m.id, m.week, m.time, m.formatted_date, m.season, m.localteam_score, m.visitorteam_score, m.et_score, m.penalty_local, m.penalty_visitor, t1.name as localteam_name, t1.image as localteam_image, t2.name as visitorteam_name, t2.image as visitorteam_image FROM '. $table_name . ' AS m JOIN '.$join_name.' as t1 ON m.localteam_id = t1.id JOIN '.$join_name.' as t2 ON m.visitorteam_id = t2.id WHERE m.comp_id = ' . $comp_id . ' AND m.season = "'. $season .'" AND m.week = '.$week.' ORDER BY m.formatted_date');

    //            var_dump('SELECT m.id, m.week, m.time, m.formatted_date, m.season, m.localteam_score, m.visitorteam_score, m.et_score, m.penalty_local, m.penalty_visitor, t1.name as localteam_name, t1.image as localteam_image, t2.name as visitorteam_name, t2.image as visitorteam_image FROM '. $table_name . ' AS m CROSS JOIN '.$join_name.' as t1 ON m.localteam_id = t1.id CROSS JOIN '.$join_name.' as t2 ON m.visitorteam_id = t2.id WHERE m.comp_id = ' . $comp_id . ' AND m.season = "'. $season .'" AND m.week = '.$week.' ORDER BY m.formatted_date');

                if($matchs != null) {
                    return $matchs;
                }

            }

            return false;
        }
    }

    /**
     * get all teams
     * @return bool|array
     */
    public function getAllTeam(){
            global $wpdb;

            $table_name = $wpdb->prefix . 'team';

            $teams = $wpdb->get_results('SELECT * FROM '. $table_name . ' ORDER BY '.$table_name.'.name');

            if($teams != null) {
                return $teams;
            }

        return false;
    }

    /**
     * get the key of the api
     * @return bool|array
     */
    public function getApiKey(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'option_api_foot';

        $apiKey = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE meta_name = "api_key"');

        if($apiKey != null){
            return $apiKey;
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

    /**
     * get current week for the matchs
     * @param $compId
     * @param null $season
     * @return bool
     */
    public function getCurrentWeek($compId, $season = null){
        global $wpdb;

        $table_name = $wpdb->prefix . 'match';

        if($season == null){
            $season = $this->getSeasonFromCompId($compId);
        }

        $curentTimeStamp = time();

        $week = $wpdb->get_results('SELECT * FROM '.$table_name.' AS m WHERE m.comp_id = '.$compId.' AND m.season = "'.$season.'" AND m.formatted_date >= '.$curentTimeStamp.' GROUP BY m.week ORDER BY m.week');

        if($week != null){
            return $week[0]->week;
        }
        return false;
    }

    /**
     * get weeks of a competition
     * @param $compId
     * @param null $season
     * @return bool
     */
    public function getWeeksOfComp($compId, $season = null){
        global $wpdb;

        $table_name = $wpdb->prefix . 'match';

        if($season == null){
            $season = $this->getSeasonFromCompId($compId);
        }

        $week = $wpdb->get_results('SELECT * FROM '.$table_name.' AS m WHERE m.comp_id = '.$compId.' AND m.season = "'.$season.'" GROUP BY m.week ORDER BY m.week');

        if($week != null){
            return $week;
        }
        return false;
    }

    /**
     * get the key of the api
     * @return bool
     */
    public function getDefaultApiKey(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'option_api_foot';

        $defaultApiKey = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE meta_name = "api_key_default"');

        if($defaultApiKey != null){
            return $defaultApiKey;
        }
        return false;
    }

    /**
     * get all standing from the data base
     * @return bool
     */
    public function getStandingFromDb(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'standing';

        $standing = $wpdb->get_results('SELECT * FROM '. $table_name);

        if($standing != null){
            return $standing;
        }
        return false;
    }

    /**
     * get all season available from the standing table
     * @return bool
     */
    public function getSeason(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'standing';

        $season = $wpdb->get_results('SELECT season FROM '. $table_name .' GROUP BY season');

        if($season != null){
            return $season;
        }
        return false;
    }

    /**
     * get all season available from the standing table
     * @return bool
     */
    private function getSeasonFromCompId($compId){
        if(is_numeric($compId)) {
            global $wpdb;

            $table_name = $wpdb->prefix . 'competition';

            $season = $wpdb->get_row('SELECT season FROM ' . $table_name . ' WHERE id = ' . $compId);

            if ($season != null) {
                return $season->season;
            }
            return false;
        }
    }

    /**
     * get all standing from comp id
     * @return bool
     */
    public function getStandingFromCompId($compId){
        if(is_numeric($compId)){
            global $wpdb;

            $table_name = $wpdb->prefix . 'standing';
            $inner_name = $wpdb->prefix . 'team';

            /**
             * get only form the season selected in the back Office
             */
            $season = $this->getSeasonFromCompId($compId);

            $standing = $wpdb->get_results('SELECT position, status, '.$inner_name.'.image, '.$inner_name.'.name, point, round, overall_w, overall_d, overall_l, gd, comp_group  FROM '. $table_name . ' INNER JOIN '.$inner_name.' ON '.$table_name.'.id_team = '.$inner_name.'.id WHERE id_competition = '.$compId . ' AND season = "'. $season .'" ORDER BY comp_group, '.$table_name.'.position');

            if($standing != null){
                return $standing;
            }
            return false;
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

            $standing = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE id_competition =' . $competition_id .' AND id_team = ' . $team_id);

            if($standing != null){
                return $standing;
            }
        }
        return false;
    }

    /**
     * get the match, mostly use to update the match table
     * @param $competition_id
     * @param $team_id
     * @return bool
     */
    private function getMatchById($competition_id, $match_id){
        if(is_numeric($match_id) && is_numeric($competition_id)){
            global $wpdb;

            $table_name = $wpdb->prefix . 'match';

            $matchs = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE comp_id =' . $competition_id .' AND id = ' . $match_id);

            if($matchs != null){
                return $matchs;
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

            $team = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE id = '. $team_id);

            if($team != null){
                return $team;
            }
        }
        return false;
    }

    public function getToken(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'option_api_foot';

        $token = $wpdb->get_row('SELECT * FROM '. $table_name . ' WHERE meta_name = "token"');

        if($token != null){
            return $token;
        }
    }

    /**
     * Remove old entries, older than a years
     */
    public function removeOldEntries(){
        $deletTime = time() - (3600*24*365*2);

        /**
         * remove match
         */
        global $wpdb;

        $table_name = $wpdb->prefix . 'match';


        $sql = $wpdb->prepare('DELETE FROM '.$table_name.' WHERE formatted_date < %s', $deletTime);

        $wpdb->query($sql);

        /**
         * remove standing (classement)
         */

        $table_name = $wpdb->prefix . 'standing';


        $currentYear = intval(date("Y"));

        $seasonToRemove = ($currentYear - 2).'/'.($currentYear - 1);

        $sql = $wpdb->prepare('DELETE FROM '.$table_name.' WHERE season = %s', $seasonToRemove);

        $wpdb->query($sql);

        /**
         * remove team
         */

        $table_name = $wpdb->prefix . 'team';

        $sql = $wpdb->prepare('DELETE FROM '.$table_name.' WHERE last_update < %s', $deletTime);

        $wpdb->query($sql);

    }

    /**
     * reset the status value at zero of all competition, use to refresh the status
     */
    public function resetCompetitionToZero(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'competition';

        $competition = $wpdb->get_results('SELECT * FROM '. $table_name);

        foreach($competition as $oneCompetition){
            $wpdb->update(
                $table_name,
                array(
                    'date_from' => NULL,
                    'date_to' => NULL,
                    'status' => 0,
                    'season' => NULL,
                    'last_update' => time(),
                ),
                array( 'id' => $oneCompetition->id )
            );
        }
    }

    /**
     * Update the apiKey
     * @param $id
     * @param $status
     */
    public function updateApiKey($apiKey){
        global $wpdb;

        $table_name = $wpdb->prefix . 'option_api_foot';

        /**
         * get the apikey from the database
         */
            $apiKeyBd = $this->getApiKey();

            $apiKey = htmlentities($apiKey);

        /**
         * if no api key insert else update
         */
        if(!$apiKeyBd){
            $wpdb->insert(
                $table_name,
                array(
                    'meta_name' => 'api_key',
                    'meta_value' => $apiKey,	// integer
                    'last_update' => time(),
                )
            );
        }else{
            $wpdb->update(
                $table_name,
                array(
                    'meta_value' => $apiKey,
                    'last_update' => time(),
                ),
                array( 'id' => $apiKeyBd->id )
            );
        }
    }

    /**
     * Update the status of a competition
     * @param $id
     * @param $status
     */
    public function updateCompetitionStatus($id, $status, $dateFrom, $dateTo, $classement, $season){
        if(is_numeric($id) && is_numeric($status) && $dateFrom != null && $dateTo != null && $season != null && is_numeric($classement)){

            $dateFrom = htmlentities($dateFrom);
            $dateTo = htmlentities($dateTo);

            global $wpdb;

            $table_name = $wpdb->prefix . 'competition';

            $id_return = $wpdb->update(
                $table_name,
                array(
                    'status' => $status,
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                    'classement' => $classement,
                    'season' => $season,
                    'last_update' => time(),
                ),
                array( 'id' => $id )
            );
            if(is_numeric($id_return)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * update team form the back office
     * @param $data
     */
    public function updateTeam($data){

        $id = $data['teamId'];
        $name = htmlentities($data['name']);
        if(isset($data['image'])){
            $image = htmlentities($data['image']);
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'team';

        if(is_numeric($id) && $name != null && isset($image) && $image != null){

            $id_return = $wpdb->update(
                $table_name,
                array(
                    'name' => $name,
                    'image' => $image,
                    'last_update' => time(),
                ),
                array( 'id' => $id )
            );
            if(is_numeric($id_return)){
                echo true;
            }
            echo false;
        }elseif(is_numeric($id) && $name != null){

            $id_return = $wpdb->update(
                $table_name,
                array(
                    'name' => $name,
                    'last_update' => time(),
                ),
                array( 'id' => $id )
            );
            if(is_numeric($id_return)){
                echo true;
            }
            echo false;
        }
        echo false;
    }

}