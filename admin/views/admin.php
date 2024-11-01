<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   WPCustomizerPro
 * @author    Max Kostinevich <hello@maxkostinevich.com>
 * @license   GPL-2.0+
 * @link      https://maxkostinevich.com
 * @copyright 2015 Max Kostinevich
 */
?>

<?php
/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
?>

<div class="wrap vstyler-admin-page">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable1">
					<div class="postbox">
						<div class="inside">
							<p>
								Generated CSS code by WPCustomizer PRO is below. <br>
								Disabled code is wrapped in CSS comments tag <strong>/* ... */</strong> <br>
								To modify this code please use <strong>front-end live editor &rarr; history</strong></p>
							<textarea class="css-code-preview"  readonly><?php echo Visual_Styler_Admin::get_final_css_code(); ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- end main content -->

			<!-- sidebar -->
			<?php  include_once( '_sidebar-right.php' );?>
			<!-- end sidebar -->

		</div>
		<!-- end post-body-->

		<br class="clear">
	</div>
	<!-- end poststuff -->

</div>