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

require_once('class-omdb-client.php');

class movie_taxonomy {

    /**
     * Initializes the plugin by registering the hooks necessary
     * for creating our custom taxonomies within WordPress.
     *
     * @since    1.0.0
     */

    public function init() {
        add_action( 'init', array( $this, 'init_movie' ) );
        add_action('admin_menu', array( $this, 'add_movie_box' ) );

        /* Use the save_post action to save new movie data */
        add_action('save_post', array( $this, 'save_movie_data' ) );
        $omdb_client = new omdb_client('3ccd5933');
    }

    /**
    * Creates the Photographs taxonomy that appears on all Post dashboard
    * pages.
    *
    * @since    1.0.0
    */
    public function init_movie() {
       $labels = array(
           'name'          => 'Movies',
           'singular_name' => 'Movie',
           'edit_item'     => 'Edit Movies',
           'update_item'   => 'Update Movies',
           'add_new_item'  => 'Add New Movie',
           'menu_name'     => 'Movies'
       );

       $args = array(
           'hierarchical'      => true,
           'labels'            => $labels,
           'show_ui'           => true,
           'show_admin_column' => true,
           'rewrite'           => array( 'slug' => 'movies' )
       );

       register_taxonomy( 'movies', 'post', $args );
   }

   public function add_movie_box() {
        remove_meta_box('moviesdiv','post','core');
        add_meta_box('movie_box_ID', __('Movie'), array( $this, 'movie_box_styling' ), 'post', 'side', 'core');
    }

    // This function gets called in edit-form-advanced.php
    public function movie_box_styling($post) {

            echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' .
            wp_create_nonce( 'taxonomy_movie' ) . '" />';
            // Get all theme taxonomy terms
       ?>

        <p>
            <label class="movie-info-search-label" for="post_movie"><?php _e( "Search for a movie:", 'movie-info' ); ?></label>
            <br />
            <input class="movie-info-search-field" type="text" placeholder="Title or IMDB-ID"  id="post_movie" value="" size="16" />
            <input class="movie-info-search-field" style="width: 130px;" placeholder="Year (optional)" type="number" name="post_movie_year" id="post_movie_year" value="" size="16" />
            <input type="button" class="button" id="movie-info-search-button" value="Search">
        </p>
        <p class="howto"><?php _e( "Can't find your movie? Try searching by complete title or IMDB-ID.", 'movie-info' ); ?></p>
        <table class="movie-info-table">
            <tr>
                <th><?php _e( "Title", 'movie-info' ); ?></th>
                <th><?php _e( "Year", 'movie-info' ); ?></th>
                <th></th>
            </tr>

        </table>
        <hr />
        <div class="movie-info-tags">
            <ul>
            <?php
                $movies = wp_get_object_terms($post->ID, 'movies');
                $deletebutton = '<button type="button dashicons-before" class="movie-info-delete">
                                    <span class="dashicons dashicons-dismiss" aria-hidden="true"></span>
                                 </button>';
                foreach ($movies as $movie) {
                    if (!is_wp_error($names) && !empty($names) && !strcmp($movie->slug, $names[0]->slug))
                        echo "<li class='theme-option' data-movie-tag='" . $movie->name . "'>" . $deletebutton . $movie->name . "</li>\n";
                    else
                        echo "<li class='theme-option' data-movie-tag='" . $movie->name . "'>". $deletebutton . $movie->name . "</li>\n";
                }
            ?>
            </ul>

        </div>
        <?php
   }

   public function save_movie_data($post_id) {
        // verify this came from our screen and with proper authorization.
        if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_movie' )) {
            return $post_id;
        }
        // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;
        // Check permissions
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) )
                return $post_id;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) )
            return $post_id;
        }
        // OK, we're authenticated: we need to find and save the data
        $post = get_post($post_id);
        if (($post->post_type == 'post') || ($post->post_type == 'page')) {
               // OR $post->post_type != 'revision'
               $deleted_movies = isset ( $_POST['post_movie_deleted'] )  ? $_POST['post_movie_deleted'] : array();
               wp_remove_object_terms( $post_id, $deleted_movies , 'movies' );
               $movies = isset ( $_POST['post_movie'] )  ? $_POST['post_movie'] : array();
               wp_set_object_terms( $post_id, $movies, 'movies', true );
            }
        return $theme;

    }
}


