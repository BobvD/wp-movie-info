<?php

/**
 * The movie taxonomy class file
 *
 * Defines the functions necessary to register the movie taxonomy with
 * WordPress.
 *
 * @since      1.0.0
 *
 * @package    Movie_Info
 * @subpackage Movie_Info/admin
 * @author     Bob van Donselaar
 */

use aharen\OMDbAPI;

class omdb_client {

    /**
	 * The OMDB API key
	 *
	 * @since  	1.0.0
	 * @access 	protected
	 * @var  	string 		$key 	OMDB API key
	 */
    protected $key;

    /**
	 * aharen\OMDbAPI
	 *
	 * @since  	1.0.0
	 * @access 	protected
	 * @var  	OMDbAPI
	 */
    protected $omdb;

    /**
     * Client for accessing OMDB data.
     *
     * @since    1.0.0
     */
    public function __construct($key) {
        $this->key = $key;
        $this->omdb = new OMDbAPI($key);
    }

    public function search_movie_by_name($name){
        $results = $this->omdb->search($name, 'movie');
        $items = array();
        $search = $results->data->Search;
        foreach ($search as $entry) {
            $items[] = $entry;

        }
        return  $items;
    }


    public function search_movie_by_name_and_year($name, $year){
        $results = $this->omdb->search($name, 'movie', $year);
        $items = array();
        $search = $results->data->Search;
        foreach ($search as $entry) {
            $items[] = $entry;

        }
        return  $items;
    }

    public function get_movie_data($id){

        $results = $this->omdb->fetch('i', $id);
        return  $results;

    }


}