<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://twitter.com/bobvnd
 * @since      1.0.0
 *
 * @package    Movie_Info
 * @subpackage Movie_Info/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Movie_Info
 * @subpackage Movie_Info/admin
 * @author     Bob van Donselaar <bobvandonselaar@gmail.com>
 */
class Movie_Info_Admin {

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
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'movie_info';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->create_movie_taxonomy();
		$this->load_dependencies();
	}

	/**
	 * Load the required dependencies for the admin.
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


	}


	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( 'jquery-auto-complete', plugin_dir_url( __FILE__ ) . 'css/jquery.auto-complete.css', array(), 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/movie-info-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/movie-info-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

			$this->plugin_screen_hook_suffix = add_options_page(
				__( 'Movie Info Settings', 'movie-info' ),
				__( 'Movie Info', 'movie-info' ),
				'manage_options',
				$this->plugin_name,
				array( $this, 'display_options_page' )
			);

		}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/movie-info-admin-display.php';
	}



	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'movie-info' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);
		add_settings_field(
			$this->option_name . '_key',
			__( 'OMDB Api Key', 'movie-info' ),
			array( $this, $this->option_name . '_key_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_key' )
		);
		add_settings_field(
			$this->option_name . '_position',
			__( 'Widget position', 'movie-info' ),
			array( $this, $this->option_name . '_position_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_position' )
		);
		add_settings_field(
			$this->option_name . '_update_rating_frequency',
			__( 'Update IMDB rating:', 'movie-info' ),
			array( $this, $this->option_name . '_update_rating_frequency_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_update_rating_frequency' )
		);
		add_settings_field(
			$this->option_name . '_save_image_locally',
			__( 'Images', 'movie-info' ),
			array( $this, $this->option_name . '_save_image_locally_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_save_image_locally' )
		);
		add_settings_field(
			$this->option_name . '_update_moviedata_on_post_update',
			__( 'Various', 'movie-info' ),
			array( $this, $this->option_name . '_update_moviedata_on_post_update_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_update_moviedata_on_post_update' )
		);
		// Add a Styling section
		add_settings_section(
			$this->option_name . '_styling',
			__( 'Styling', 'movie-info' ),
			array( $this, $this->option_name . '_styling_cb' ),
			$this->plugin_name
		);
		add_settings_field( // Option 1
			$this->option_name . '_font_size', // Option ID
			__( 'Font Size', 'movie-info' ), // Label
			array( $this, $this->option_name . '_font_size_cb' ), // !important - This is where the args go!
			$this->plugin_name, // Page it will be displayed (General Settings)
			$this->option_name . '_styling', // Name of our section
			array( 'label_for' => $this->option_name . '_font_size' )
		);
		add_settings_field( // Option 1
			$this->option_name . '_primary_color', // Option ID
			__( 'Primary Color', 'movie-info' ), // Label
			array( $this, $this->option_name . '_primary_color_cb' ), // !important - This is where the args go!
			$this->plugin_name, // Page it will be displayed (General Settings)
			$this->option_name . '_styling', // Name of our section
			array( 'label_for' => $this->option_name . '_primary_color' )
		);
		add_settings_field( // Option 1
			$this->option_name . '_secondary_color', // Option ID
			__( 'Secondary Color', 'movie-info' ), // Label
			array( $this, $this->option_name . '_secondary_color_cb' ), // !important - This is where the args go!
			$this->plugin_name, // Page it will be displayed (General Settings)
			$this->option_name . '_styling', // Name of our section
			array( 'label_for' => $this->option_name . '_secondary_color' )
		);


		register_setting( $this->plugin_name, $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );
		register_setting( $this->plugin_name, $this->option_name . '_key' );
		register_setting( $this->plugin_name, $this->option_name . '_save_image_locally' );
		register_setting( $this->plugin_name, $this->option_name . '_update_rating_frequency' );
		register_setting( $this->plugin_name, $this->option_name . '_update_moviedata_on_post_update' );
		register_setting( $this->plugin_name, $this->option_name . '_font_size' );
		register_setting( $this->plugin_name, $this->option_name . '_primary_color' );
		register_setting( $this->plugin_name, $this->option_name . '_secondary_color' );
	}



	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function movie_info_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly and provide a valid API key.', 'movie-info' ) . '</p>';
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function movie_info_styling_cb() {
		echo '<p>' . __( 'Change the way your widget will be displayed.', 'movie-info' ) . '</p>';
	}

	/**
	* Render the radio input field for position option
	*
	* @since  1.0.0
	*/
   	public function movie_info_position_cb() {
			$position = get_option( $this->option_name . '_position' );
	   	?>
		  	<fieldset>
			   	<label>
				   <input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before" <?php checked( $position, 'before' ); ?>>
				   	<?php _e( 'Before the content', 'movie-info' ); ?>
			   	</label>
			   	<br>
			   	<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="after" <?php checked( $position, 'after' ); ?>>
					<?php _e( 'After the content', 'movie-info' ); ?>
			   	</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="shortcode" <?php checked( $position, 'shortcode' ); ?>>
				    <?php _e( 'By shortcode only', 'movie-info' ); ?>
			   	</label>
		   	</fieldset>
	   <?php
	}

	/**
	* Render the select input field for update rating frequency
	*
	* @since  1.0.0
	*/
	public function movie_info_update_rating_frequency_cb() {
		$rating_freq = get_option( $this->option_name . '_update_rating_frequency' );
	   ?>
		  <select
		  	name="<?php echo $this->option_name . '_update_rating_frequency' ?>"
			id="<?php echo $this->option_name . '_update_rating_frequency' ?>">
			<option
				<?php selected( $rating_freq, 'never' ); ?>
				value="never">Never
			</option>
			<option
				<?php selected( $rating_freq, 'daily' ); ?>
				value="daily">Daily
			</option>
			<option
				<?php selected( $rating_freq, 'weekly' ); ?>
				value="weekly">Weekly
			</option>
			<option
				<?php selected( $rating_freq, 'monthly' ); ?>
				value="monthly">Monthly
			</option>
		  </select>
	<?php
	}

	/**
	* Render the select input field for update rating frequency
	*
	* @since  1.0.0
	*/
	public function movie_info_save_image_locally_cb() {
		$rating_freq = get_option( $this->option_name . '_save_image_locally' );
	   ?>
		  <input id="checkBox"
		  	type="checkbox"
			value="1"
			name="<?php echo $this->option_name . '_save_image_locally' ?>"
			id="<?php echo $this->option_name . '_save_image_locally' ?>"
			<?php checked( $rating_freq, true ); ?>>
		  Save images (posters) locally
		  </input>

	<?php
	}

	/**
	* Render the select input field for update rating frequency
	*
	* @since  1.0.0
	*/
	public function movie_info_update_moviedata_on_post_update_cb() {
		$do_not_update = get_option( $this->option_name . '_update_moviedata_on_post_update' );
	   ?>
		  <input id="checkBox"
		  	type="checkbox"
			value="1"
			name="<?php echo $this->option_name . '_update_moviedata_on_post_update' ?>"
			id="<?php echo $this->option_name . '_update_moviedata_on_post_update' ?>"
			<?php checked( $do_not_update, true ); ?>>
		  Don't update movie-data when post get's updated.
		  </input>

	<?php
	}

		/**
	* Render the text input field for position option
	*
	* @since  1.0.0
	*/
	public function movie_info_key_cb() {
		$key = get_option( $this->option_name . '_key' );
		echo '<input type="text" name="' . $this->option_name . '_key' . '" value="' . $key . '" id="' . $this->option_name . '_key' . '"> ';
	}

	public function movie_info_font_size_cb() {
		$font_size = get_option( $this->option_name . '_font_size' );
		echo '<input type="text" name="' . $this->option_name . '_font_size' . '" value="'
		. $font_size . '" id="' . $this->option_name . '_font_size' . '"> ';
	}

	public function movie_info_primary_color_cb() {
		$primary_color = get_option( $this->option_name . '_primary_color' );
		echo '<input name="' . $this->option_name . '_primary_color'
			. '" value="'. $primary_color . '"'
			. '" class="color-field" type="text" >';
	}

	public function movie_info_secondary_color_cb() {
		$secondary_color = get_option( $this->option_name . '_secondary_color' );
		echo '<input name="' . $this->option_name . '_secondary_color'
				. '" value="'. $secondary_color . '"'
				. '" class="color-field" type="text" >';
	}


	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function outdated_notice_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
	        return $position;
	    }
	}

	public function create_movie_taxonomy(){
		/** Loads the movie taxonomy class file. */
		require_once( dirname( __FILE__ ) . '/class-movie-taxonomy.php' );
		$movie_tax = new movie_taxonomy();
		$movie_tax->init();
		// create custom fields
		require_once( dirname( __FILE__ ) . '/class-movie-taxonomy-meta.php');
		$movie_tax_meta = new movie_taxonomy_meta();
		$movie_tax_meta->init();
	}

	public function ajax_movie_names() {
		require_once( dirname( __FILE__ ) . '/class-omdb-client.php' );
		$omdb_client = new omdb_client(get_option( $this->option_name . '_key' ));

		$title = $_POST['movie'];
		$year = $_POST['year'];

		if($year){
			echo json_encode($omdb_client->search_movie_by_name_and_year($title, $year));
		}
		else {
			echo json_encode($omdb_client->search_movie_by_name($title));
		}
		 //encode into JSON format and output
		die(); //stop "0" from being output
	}

	public function save_post_movies( $post_ID, $post, $update ) {

		require_once( dirname( __FILE__ ) . '/class-omdb-client.php' );
		$omdb_client = new omdb_client(get_option( $this->option_name . '_key' ));
		$save_image = get_option( $this->option_name . '_save_image_locally' );
		$do_not_update = get_option( $this->option_name . '_update_moviedata_on_post_update' );

		if($update == 1 || ($update == 1 && $do_not_update != 1)){
			$movies = get_the_terms( $post_id, 'movies' );
			// get all movie data.
			foreach ( $movies as $movie ) {
				$do_not_update_single = get_term_meta( $movie->term_id, 'do-not-update', true);
				if($do_not_update_single == 1){
					continue;
				}
				$imdb_id = get_term_meta( $movie->term_id, 'imdb-id', true);
				if(!$imdb_id){
					if( isset( $_POST[$movie->slug] ) ) {
						$imdb_id = esc_attr( $_POST[$movie->slug]);
					}
				}
				$movie_data = $omdb_client->get_movie_data($imdb_id);

				update_term_meta( $movie->term_id, 'title', $movie_data->data->Title );
				update_term_meta( $movie->term_id, 'year', $movie_data->data->Year );
				update_term_meta( $movie->term_id, 'runtime', $movie_data->data->Runtime );
				update_term_meta( $movie->term_id, 'genre', $movie_data->data->Genre );
				update_term_meta( $movie->term_id, 'country', $movie_data->data->Country );
				update_term_meta( $movie->term_id, 'director', $movie_data->data->Director );
				update_term_meta( $movie->term_id, 'cast', $movie_data->data->Actors );
				update_term_meta( $movie->term_id, 'rated', $movie_data->data->Rated );
				update_term_meta( $movie->term_id, 'imdb-rating', $movie_data->data->imdbRating );
				update_term_meta( $movie->term_id, 'metascore', $movie_data->data->Metascore );
				update_term_meta( $movie->term_id, 'imdb-id', $movie_data->data->imdbID );

				// check if the user want's to save images locally
				if($save_image == 1){
					// check if the poster image already exists, if not: save
					if ( null == ( $thumb_id = $this->does_file_exists( basename($movie_data->data->Poster) ) ) ) {

						if (filter_var($movie_data->data->Poster, FILTER_VALIDATE_URL) === FALSE) {
							update_term_meta( $movie->term_id, 'poster', 'no poster' );
						} else {
							update_term_meta( $movie->term_id, 'poster',
							media_sideload_image($movie_data->data->Poster, 0, $movie->name, 'src') );
						}

					}
				} else {
					update_term_meta( $movie->term_id, 'poster', $movie_data->data->Poster);
				}

				// Update the term's description.
				$update = wp_update_term( $movie->term_id, 'movies', array(
					'description' => $movie_data->data->Plot
				) );
			}
		}

	}

	public function does_file_exists($filename) {
		global $wpdb;
		return intval( $wpdb->get_var( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value LIKE '%/$filename'" ) );
	}

}
