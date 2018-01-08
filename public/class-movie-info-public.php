<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://twitter.com/bobvnd
 * @since      1.0.0
 *
 * @package    Movie_Info
 * @subpackage Movie_Info/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Movie_Info
 * @subpackage Movie_Info/public
 * @author     Bob van Donselaar <bobvandonselaar@gmail.com>
 */
class Movie_Info_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Movie_Info_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Movie_Info_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/movie-info-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Movie_Info_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Movie_Info_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/movie-info-public.js', array( 'jquery' ), $this->version, false );

	}


	public function movie_widget( $movie ){
		$title = get_term_meta( $movie->term_id, 'title', true );
        $year = get_term_meta( $movie->term_id, 'year', true );
        $runtime = get_term_meta( $movie->term_id, 'runtime', true );
        $genre = get_term_meta( $movie->term_id, 'genre', true );
        $country = get_term_meta( $movie->term_id, 'country', true );
        $director = get_term_meta( $movie->term_id, 'director', true );
        $cast = get_term_meta( $movie->term_id, 'cast', true );
		$poster = get_term_meta( $movie->term_id, 'poster', true );

		$widget = '<div class="movie-info">'
				  .	'<img class="movie-poster" src="' . $poster . '">'
				  . '<div class="movie-meta"><h3>' . $title . ' (' . $year . ')' .'</h3>'
				  . '<p><span class="movie-rating">PG 13</span>' .  $runtime . ' ' . $country . '</p>'
				  . '<p class="movie-plot">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>'
				  . '<p><b>Director:</b> ' . $director . '<br /><b>Stars:</b> ' . $cast . '</p>'

				  . '</div>'
				  . '</div>';
		return $widget;


	}

	/**
	 *
	 * Echo the movie information on the single post.
	 *
	 * @since    1.0.0
	 */
	public function the_content( $post_content ) {

				if ( is_main_query() && is_singular('post') ) {
					// get position
					$position  = get_option( 'movie_info_position', 'before' );
					$movies = get_the_terms( $post_content, 'movies' );
					$movie_info = $this->movie_widget($movies[0]);
					if ( 'after' == $position ) {
						$post_content .= $movie_info;
					}
					else if ( 'before' == $position ) {
						$post_content = $movie_info . $post_content;
					}
				}

				return $post_content;
			}

}
