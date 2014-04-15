<?php

/**
 * This controller takes care of all back end for this applications
 * 
 * @author Mark Lagusker mk.lager@gmail.com
 * @link 
 */
App::uses('AppController', 'Controller');

class MoviesController extends AppController {

    public function index() {
        $this->set('title_for_layout', 'Movies');
        $this->layout = 'ajax';
    }

    /**
     * Fetches all titles in the database to use for user suggestion
     */
    function get_titles() {
        $data = $this->Movie->find('all', array('fields' => 'DISTINCT title'));
        $movies = array();
        foreach ($data as $movie) {
            array_push($movies, $movie['Movie']['title']);
        }
        echo json_encode(array('movies' => $movies));// return titles to the view
        exit;
    }

    /**
     * Fetches and sends all needed info upon user request 
     */
    function get_locations() {
        if ($this->request->is('post')) {
            $title = $this->request->data['title'];
            $title = filter_var($title, FILTER_SANITIZE_STRING);//clear user input
            $data = $this->Movie->find('all', array('conditions' => array('title' => $title)));
            $locations = array();
            foreach ($data as $value) {
                $tmp = array();
                $tmp['LatLng'] = $value['Movie']['LatLng'];
                $tmp['location'] = $value['Movie']['locations'];
                //can be used in the future to show addition info
                //$tmp['fun_facts'] = $value['Movie']['fun_facts'];
                array_push($locations, $tmp);
            }
            echo json_encode($locations);// return to the view
            exit;
        } else {
            echo json_encode(array('locations' => null));
            exit;
        }
    }

    /**
     * Imports all data about movies to the database.
     * It was used in initial step to import data.
     */
    function import_movies() {
        $json = file_get_contents("http://data.sfgov.org/resource/yitu-d5am.json");
        if (is_null($json)) {
            Cakelog::write('debug', 'The link is broken or no data there');
            die();
        }
        $movies = json_decode($json, true);
        foreach ($movies as $movie) {
            $data['Movie'] = '';
            foreach ($movie as $key => $value) {
                //clear the data 
                $data['Movie'][$key] = htmlspecialchars_decode(filter_var($value, FILTER_SANITIZE_STRING), ENT_QUOTES);
            }
            $this->Movie->create();
            if (!$this->Movie->save($data)) {
                Cakelog::write('debug', 'Can\'t save ' . $movie['title']);
            }
        }
    }
}
