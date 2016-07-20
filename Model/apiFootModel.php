<?php

/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 18/07/16
 * Time: 12:18
 */

namespace Model\apiFootModel;

use Model\dataModel;

class apiFootModel
{
    private $url = 'http://api.football-api.com/2.0/';

    private $authorization;

    /**
     * apiFootModel constructor.
     * get the api key from database
     */

    public function __construct()
    {
        $dataModel = new \Model\dataModel\dataModel();
        $apiKey = $dataModel->getApiKey();
        if(!$apiKey){
            $apiKey = $dataModel->getDefaultApiKey();
        }
        $this->authorization = $apiKey->meta_value;

    }

    /**
     * get all competitions
     * @return mixed
     */
    public function getAllCompetitions(){
        $search = 'competitions';
        $api = $this->url . $search .'?Authorization=' . $this->authorization;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($curl);
        curl_close($curl);
        $jsonDecode = json_decode($data);
        if(isset($jsonDecode->error) && $jsonDecode->error != null){
            return false;
        }
        return $jsonDecode;
    }

    /**
     * get one competion by id
     * @param $id
     * @return mixed
     */
    public function getCompetitionsById($id){
        if(!is_int($id)){
            return false;
        }
        $api = $this->url . $id .'?Authorization=' . $this->authorization;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($curl);
        curl_close($curl);
        $jsonDecode = json_decode($data);
        if(isset($jsonDecode->error) && $jsonDecode->error != null){
            return false;
        }
        return $jsonDecode;
    }

    /**
     * get Matchs
     * @param $competition_id int
     * @param null $team_id int
     * @param null $match_id int
     * @param null $from_date
     * @param null $to_date
     * @return string|mixed
     */
    public function getMatch($competition_id, $team_id = null, $match_id = null, $from_date = null, $to_date = null){
        if(!is_numeric($competition_id)){
            return false;
        }

        $api = $this->url . 'matches' .'?Authorization=' . $this->authorization . '&comp_id=' . $competition_id;

        if(is_numeric($team_id)){
            $api .= '&team_id=' . $team_id;
        }
        if(is_numeric($match_id)){
            $api .= '&match_date=' . $match_id;
        }
        if($from_date != null){
            $api .= '&from_date=' . $from_date;
        }
        if($to_date != null){
            $api .= '&to_date=' . $to_date;

        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($curl);
        curl_close($curl);
        $jsonDecode = json_decode($data);

        if(isset($jsonDecode->status) && $jsonDecode->status == 'error'){
            return $jsonDecode->message;
        }

        return $jsonDecode;
    }

    /**
     * get standing of a competition (classement)
     * @param $id
     * @return mixed
     */
    public function getStandingCompetition($id){
        if(!is_numeric($id)){
            return false;
        }
        $api = $this->url . 'standings/' . $id .'?Authorization=' . $this->authorization;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($curl);
        curl_close($curl);
        $jsonDecode = json_decode($data);
        if(isset($jsonDecode->error) && $jsonDecode->error != null){
            return false;
        }
        return $jsonDecode;
    }

    /**
     * get Player from a team
     * @param $team_id
     * @return bool|mixed
     */
    public function getTeam($team_id){
        if(!is_numeric($team_id)){
            return false;
        }
        $api = $this->url . 'team/' . $team_id .'?Authorization=' . $this->authorization;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($curl);
        curl_close($curl);
        $jsonDecode = json_decode($data);
        if(isset($jsonDecode->error) && $jsonDecode->error != null){
            return false;
        }
        return $jsonDecode;
    }
}