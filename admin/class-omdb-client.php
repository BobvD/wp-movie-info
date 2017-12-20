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
     * Client for accessing OMDB data.
     *
     * @since    1.0.0
     */
    public function init() {

        $omdb = new OMDbAPI();
        
    }

}