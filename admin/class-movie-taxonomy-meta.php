<?php

/**
 * The movie taxonomy: Meta class file
 *
 * Defines the functions necessary to register all custom meta fields for the 'movie' taxonomy.
 * WordPress.
 *
 * @since      1.0.0
 *
 * @package    Movie_Info
 * @subpackage Movie_Info/admin
 * @author     Bob van Donselaar
 */


class movie_taxonomy_meta {


    /**
     * Registers the hooks necessary for creating the taxonomy's custom meta fields.
     *
     * @since    1.0.0
     */

    public function init() {

        add_action( 'movies_add_form_fields', array( $this, 'movies_add_meta_fields' ), 10, 2);
        add_action( 'movies_edit_form_fields', array( $this, 'movies_edit_meta_fields' ), 10, 2 );
        add_action( 'created_movies', array( $this, 'movies_save_taxonomy_meta' ), 10, 2 );
        add_action( 'edited_movies', array( $this, 'movies_save_taxonomy_meta' ), 10, 2 );
        add_action ( 'admin_enqueue_scripts', function () {
            if (is_admin ())
                wp_enqueue_media ();
        } );
    }

    function movies_add_meta_fields( $taxonomy ) {
        ?>
        <hr />
        <h3>Movie Info</h3>
        <!-- Movie Poster -->
        <div class="form-field term-group">
            <img id="movie-info-poster" src="" />
            <label for="poster"><?php _e( 'Poster', 'movie-info' ); ?></label>
            <input type="hidden" id="poster" name="poster" />
            <p>
                <input type="hidden" value="" class="regular-text process_custom_images" id="process_custom_images" name="" max="" min="1" step="1">
                <button class="set_custom_images button"><?php _e( 'Set featured image', 'movie-info' ); ?></button>
            </p>
        </div>
        <!-- Movie Title -->
        <div class="form-field term-group">
            <label for="title"><?php _e( 'Title', 'movie-info' ); ?></label>
            <input type="text" id="title" name="title" />
        </div>
        <!-- Movie Release Year -->
        <div class="form-field term-group">
            <label for="year"><?php _e( 'Year', 'movie-info' ); ?></label>
            <input type="number" id="year" name="year" />
        </div>
        <!-- Movie Runtime -->
        <div class="form-field term-group">
            <label for="runtime"><?php _e( 'Runtime', 'movie-info' ); ?></label>
            <input type="text" id="runtime" name="runtime" />
        </div>
        <!-- Movie Genre -->
        <div class="form-field term-group">
            <label for="genre"><?php _e( 'Genre', 'movie-info' ); ?></label>
            <input type="text" id="genre" name="genre" />
        </div>
        <!-- Movie Country -->
        <div class="form-field term-group">
            <label for="country"><?php _e( 'Country', 'movie-info' ); ?></label>
            <input type="text" id="country" name="country" />
        </div>
        <!-- Movie Director -->
        <div class="form-field term-group">
            <label for="director"><?php _e( 'Director', 'movie-info' ); ?></label>
            <input type="text" id="director" name="director" />
        </div>
        <!-- Movie Cast -->
        <div class="form-field term-group">
            <label for="cast"><?php _e( 'Cast', 'movie-info' ); ?></label>
            <input type="text" id="cast" name="cast" />
        </div>
        <!-- Rated -->
        <div class="form-field term-group">
            <label for="rated"><?php _e( 'Rated', 'movie-info' ); ?></label>
            <input type="text" id="rated" name="rated" />
        </div>
        <!-- IMDB Rating -->
        <div class="form-field term-group">
            <label for="imdb-rating"><?php _e( 'IMDB rating', 'movie-info' ); ?></label>
            <input type="text" id="imdb-rating" name="imdb-rating" />
        </div>
        <!-- Metascore -->
        <div class="form-field term-group">
            <label for="metascore"><?php _e( 'Metascore', 'movie-info' ); ?></label>
            <input type="text" id="metascore" name="metascore" />
        </div>
        <?php
    }

    function movies_edit_meta_fields( $term, $taxonomy ) {

        $title = get_term_meta( $term->term_id, 'title', true );
        $year = get_term_meta( $term->term_id, 'year', true );
        $runtime = get_term_meta( $term->term_id, 'runtime', true );
        $genre = get_term_meta( $term->term_id, 'genre', true );
        $country = get_term_meta( $term->term_id, 'country', true );
        $director = get_term_meta( $term->term_id, 'director', true );
        $cast = get_term_meta( $term->term_id, 'cast', true );
        $poster = get_term_meta( $term->term_id, 'poster', true );
        $rated = get_term_meta( $term->term_id, 'rated', true );
        $imdb_rating = get_term_meta( $term->term_id, 'imdb-rating', true );
        $metascore = get_term_meta( $term->term_id, 'metascore', true );
        ?>
        <table class="form-table">
            <hr/>
            <h3>Movie Info</h3>
            <!-- Movie Poster -->
            <tr class="form-field">
                <th scope="row">
                    <label for="poster"><?php _e( 'Poster', 'movie-info' ); ?></label>
                </th>
                <td>
                    <img id="movie-info-poster" src="<?php echo $poster; ?>" />
                    <input type="hidden" id="poster" name="poster" value="<?php echo $poster; ?>" />
                    <div class="form-field term-group">
                        <p>
                            <input type="hidden" value="" class="regular-text process_custom_images" id="process_custom_images" name="" max="" min="1" step="1">
                            <button class="set_custom_images button"><?php _e( 'Set featured image', 'movie-info' ); ?></button>
                        </p>
                    </div>
                </td>
            </tr>

            <!-- Movie Title -->
            <tr class="form-field">
                <th scope="row">
                    <label for="title"><?php _e( 'Title', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" />
                </td>
            </tr>
            <!-- Movie Release Year -->
            <tr class="form-field">
                <th scope="row">
                    <label for="year"><?php _e( 'Year', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="number" id="year" name="year" value="<?php echo $year; ?>" />
                </td>
            </tr>
            <!-- Movie Runtime -->
            <tr class="form-field term-group">
                <th scope="row">
                    <label for="runtime"><?php _e( 'Runtime', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="runtime" name="runtime" value="<?php echo $runtime; ?>" />
                </td>
            </tr>
            <!-- Movie Genre -->
            <tr class="form-field">
                <th scope="row">
                    <label for="genre"><?php _e( 'Genre', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>" />
                </td>
            </tr>
            <!-- Movie Country -->
            <tr class="form-field">
                <th scope="row">
                    <label for="country"><?php _e( 'Country', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="country" name="country" value="<?php echo $country; ?>" />
                </td>
            </tr>
            <!-- Movie Director -->
            <tr class="form-field">
                <th scope="row">
                    <label for="director"><?php _e( 'Director', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="director" name="director" value="<?php echo $director; ?>" />
                </td>
            </tr>
            <!-- Movie Cast -->
            <tr class="form-field">
                <th scope="row">
                    <label for="cast"><?php _e( 'Cast', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="cast" name="cast" value="<?php echo $cast; ?>" />
                </td>
            </tr>
            <!-- Rated -->
            <tr class="form-field">
                <th scope="row">
                    <label for="rated"><?php _e( 'Rated', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="rated" name="rated" value="<?php echo $rated; ?>" />
                </td>
            </tr>
            <!-- IMDB Rating -->
            <tr class="form-field">
                <th scope="row">
                    <label for="imdb-rating"><?php _e( 'IMDB rating', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="imdb-rating" name="imdb-rating" value="<?php echo $imdb_rating; ?>" />
                </td>
            </tr>
            <!-- Metascore -->
            <tr class="form-field">
                <th scope="row">
                    <label for="metascore"><?php _e( 'Metascore', 'movie-info' ); ?></label>
                </th>
                <td>
                    <input type="text" id="metascore" name="metascore" value="<?php echo $metascore; ?>" />
                </td>
            </tr>
        </table>
        <?php
    }

    function movies_save_taxonomy_meta( $term_id, $tag_id ) {
        if( isset( $_POST['title'] ) ) {
            update_term_meta( $term_id, 'title', esc_attr( $_POST['title'] ) );
        }
        if( isset( $_POST['year'] ) ) {
            update_term_meta( $term_id, 'year', esc_attr( $_POST['year'] ) );
        }
        if( isset( $_POST['runtime'] ) ) {
            update_term_meta( $term_id, 'runtime', esc_attr( $_POST['runtime'] ) );
        }
        if( isset( $_POST['genre'] ) ) {
            update_term_meta( $term_id, 'genre', esc_attr( $_POST['genre'] ) );
        }
        if( isset( $_POST['country'] ) ) {
            update_term_meta( $term_id, 'country', esc_attr( $_POST['country'] ) );
        }
        if( isset( $_POST['director'] ) ) {
            update_term_meta( $term_id, 'director', esc_attr( $_POST['director'] ) );
        }
        if( isset( $_POST['cast'] ) ) {
            update_term_meta( $term_id, 'cast', esc_attr( $_POST['cast'] ) );
        }
        if( isset( $_POST['poster'] ) ) {
            update_term_meta( $term_id, 'poster', esc_attr( $_POST['poster'] ) );
        }
        if( isset( $_POST['rated'] ) ) {
            update_term_meta( $term_id, 'rated', esc_attr( $_POST['rated'] ) );
        }
        if( isset( $_POST['imdb-rating'] ) ) {
            update_term_meta( $term_id, 'imdb-rating', esc_attr( $_POST['imdb-rating'] ) );
        }
        if( isset( $_POST['metascore'] ) ) {
            update_term_meta( $term_id, 'metascore', esc_attr( $_POST['metascore'] ) );
        }

        // Check that the nonce is valid, and the user can edit this post.
        if ( isset( $_POST['my_image_upload_nonce'] ) ) {
            $attachment_id = media_handle_upload( 'my_image_upload' );
        } else {

            // The security check failed, maybe show the user an error.
        }
    }


}


