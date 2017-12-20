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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/movie-info-admin.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/movie-info-admin.js', array( 'jquery' ), $this->version, false );

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
		register_setting( $this->plugin_name, $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );
		register_setting( $this->plugin_name, $this->option_name . '_key' );
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
	* Render the text input field for position option
	*
	* @since  1.0.0
	*/
	public function movie_info_key_cb() {
		$key = get_option( $this->option_name . '_key' );
		echo '<input type="text" name="' . $this->option_name . '_key' . '" value="' . $key . '" id="' . $this->option_name . '_key' . '"> ';
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
		/** Loads the ,ovie taxonomy class file. */
		require_once( dirname( __FILE__ ) . '/class-movie-taxonomy.php' );
		$movie_tax = new movie_taxonomy();
		$movie_tax->init();
	}
}
