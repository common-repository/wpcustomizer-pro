<?php
/**
 * @package   WPCustomizerPro
 * @author    Max Kostinevich <hello@maxkostinevich.com>
 * @license   GPL-2.0+
 * @link      https://maxkostinevich.com
 * @copyright 2015 Max Kostinevich
 *
 * @wordpress-plugin
 * Plugin Name:       WP Customizer PRO
 * Plugin URI:        https://wpcustomizerpro.com/
 * Description:       Advanced Theme Customizer for WordPress. Ex-"Visual Styler".
 * Version:           1.0.0
 * Author:            Max Kostinevich
 * Author URI:        https://maxkostinevich.com
 * Text Domain:       wpcustomizerpro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");


/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/


require_once( plugin_dir_path( __FILE__ ) . 'public/class-visual-styler.php' );


register_activation_hook( __FILE__, array( 'Visual_Styler', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Visual_Styler', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'Visual_Styler', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-visual-styler-admin.php' );
	add_action( 'plugins_loaded', array( 'Visual_Styler_Admin', 'get_instance' ) );

}
