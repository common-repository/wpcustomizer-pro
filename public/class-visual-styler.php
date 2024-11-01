<?php
/**
 * WPCustomizerPro.
 *
 * @package   WPCustomizerPro
 * @author    Max Kostinevich <hello@maxkostinevich.com>
 * @license   GPL-2.0+
 * @link      https://maxkostinevich.com
 * @copyright 2015 Max Kostinevich
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-visual-styler-admin.php`
 */


/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");

class Visual_Styler {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'wpcustomizer-pro';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ),99999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */


		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ),999 );
		add_action ('wp_loaded',array( $this, 'handle_live_editor_actions'));

		add_action('media_upload_tabs',array($this, 'media_uploader_remove_tabs'));

		add_action('wp_ajax_vstyler_ajax_request', array($this, 'handle_ajax_request'));
		add_action('wp_ajax_nopriv_vstyler_ajax_request', array($this, 'handle_ajax_request'));

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );

		$custom_css=$this->get_final_css_code();

		wp_add_inline_style( $this->plugin_slug . '-plugin-styles', $custom_css );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
		// Load Frontend iFrame javascript only if live editor is enabled and current user can edit theme options
		if(isset($_GET['vstyler-action']) && current_user_can('edit_theme_options')){
			wp_enqueue_script( $this->plugin_slug . '-frontend-iframe', plugins_url( 'assets/js/frontend-iframe.js', __FILE__ ), array( 'jquery' ), self::VERSION );
		}

	}

	/**
	 * Add menu item to admin bar
	 *
	 * @since    1.0.0
	 */
	public function admin_bar_menu($wp_admin_bar) {

		// Allow live editor features only for admins who can edit theme options
		if(!current_user_can('edit_theme_options')){ return; }

		// relative current URI:
		if(is_admin()){
			$live_editor_url=add_query_arg('vstyler-action', 'edit-page', esc_url( home_url( '/' ) ) );
		}else{
			$live_editor_url = add_query_arg('vstyler-action', 'edit-page' );
			//$live_editor_url = home_url( add_query_arg( 'vstyler-action', 'edit-page' ) );
		}

		$args = array(
			'id'    => 'vs-toolbar-menu',
			'title' => '<span class="ab-icon"></span> WPCustomizer PRO',
			'href'  => $live_editor_url,
			'meta'  => array( 'class' => 'vstyler-toolbar-page' )
		);
		$wp_admin_bar->add_node( $args );
	}

	/**
	 * Handle redirect to live editor
	 *
	 * @since    1.0.0
	 */
	public function handle_live_editor_actions() {

		// Allow live editor features only for admins who can edit theme options
		if(!current_user_can('edit_theme_options')){ return; }

		// Prevent live editor on WP-Admin
		if(is_admin()){ return; }

		// Perform exit from the live editor
		if (isset($_GET['vstyler-action']) && $_GET['vstyler-action'] == 'exit-toolbar')  {
			return;
		}

		// Hide toolbar in iFrame
		if (isset($_GET['vstyler-action']) && $_GET['vstyler-action'] == 'hide-toolbar')  {
			show_admin_bar(false);
		}

		// Launch live editor iFrame
		if (isset($_GET['vstyler-action']) && $_GET['vstyler-action']=='edit-page')  {
			show_admin_bar(false);
			require_once('views/live-editor/frontend-iframe.php');
			exit;
		}
	}

	/**
	 * Remove some tabs from media uploader  when live editor is enabled
	 *
	 * @since    1.0.0
	 */
	public function media_uploader_remove_tabs($tabs) {
		if($_GET['referer'] == 'visual-styler-customizer-uploader') {
			unset($tabs['type_url']);
			unset($tabs['gallery']);
			return $tabs;
		}else{
			return $tabs;
		}
	}

	/**
	 * Handle AJAX calls from VStyler JS files
	 *
	 * @since    1.0.0
	 */
	public function handle_ajax_request(){
		// Security check
		check_ajax_referer( 'vstyler_ajax_request', 'nonce' );

		if(isset($_POST['action_type'])){
			$action=$_POST['action_type'];
			switch($action){
				case 'update_css':

					// Get current 'vstyler_history' option value
					$vstyler_history=get_option('vstyler_history'); // Returns array of history records
					$vstyler_history=$vstyler_history?$vstyler_history:array();

					// If update existing history record
					if(isset($_POST['history_index'])){
						$history_index=(int)$_POST['history_index'];
						$vstyler_history[$history_index]['css_code']=trim($_POST['css_code']);
						if(isset($_POST['is_active'])){
							$vstyler_history[$history_index]['is_active']=($_POST['is_active']==='true')?true:false;
						}
					}else{ // If create new history record
						$newRecord=array(
							'css_code'=>trim($_POST['css_code']),
							'date_updated'=>current_time( 'timestamp' ),
							'is_active'=>true
						);
						array_unshift($vstyler_history,$newRecord);
					}

					update_option('vstyler_history',$vstyler_history);

					// Return JSON response back to Javascript
					wp_send_json_success( $vstyler_history );

					break;

				case 'get_history_list':
					// Get current 'vstyler_history' option value
					$vstyler_history=get_option('vstyler_history'); // Returns array of history records
					$vstyler_history=$vstyler_history?$vstyler_history:'';

					if(is_array($vstyler_history)){
						// Modify $vstyler_history array: add formatted date and time difference
						foreach($vstyler_history as &$history){
							$history['date_updated_formatted']=date( 'M j, Y H:i:s',$history['date_updated']);
							$history['date_updated_diff']=human_time_diff( $history['date_updated'], current_time('timestamp') ) . ' ago';
						}
					}

					wp_send_json_success( $vstyler_history );
					break;

				case 'get_history_details':
					// Get current 'vstyler_history' option value
					$vstyler_history=get_option('vstyler_history'); // Returns array of history records
					$vstyler_history=$vstyler_history?$vstyler_history:'';

					if(isset($_POST['history_index'])) {
						$history_index=(int)$_POST['history_index'];
						if ( is_array( $vstyler_history ) ) {
							wp_send_json_success( $vstyler_history[$history_index] );
						}
					}
					break;

				case 'delete_history':
					// Get current 'vstyler_history' option value
					$vstyler_history=get_option('vstyler_history'); // Returns array of history records
					$vstyler_history=$vstyler_history?$vstyler_history:array();

					// If update existing history record
					if(isset($_POST['history_index'])){
						$history_index=(int)$_POST['history_index'];
						unset($vstyler_history[$history_index]);
						update_option('vstyler_history',array_values($vstyler_history));
					}
					break;
				case 'update_inline_css':
					$final_css=$this->get_final_css_code();
					wp_send_json_success( $final_css );
					break;
			}
		}



	}

	/**
	 * Generate final css code
	 *
	 * @since    1.0.0
	 */
	private function get_final_css_code(){
		$final_css="/* Generated by Visual Styler */ \n\r";
		// Get current 'vstyler_history' option value
		$vstyler_history=get_option('vstyler_history'); // Returns array of history records

		if(is_array($vstyler_history)){
			/*
			 *  Reverse CSS code
			 * Latest changes will appended at the end of stylesheet, otherwise it works incorrect
			 */
			$vstyler_history=array_reverse($vstyler_history);
			foreach($vstyler_history as $history){
				if($history['is_active']===true) {
					$final_css .= $history['css_code'] . "\n\r";
				}
			}
		}
		return $final_css;
	}








}
