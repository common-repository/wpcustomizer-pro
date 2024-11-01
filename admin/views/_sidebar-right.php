<?php
/**
 * Render theme options right sidebar
 * You can modify this file
 *
 * @package   WPCustomizerPro
 * @author    Max Kostinevich <hello@maxkostinevich.com>
 * @license   GPL-2.0+
 * @link      https://maxkostinevich.com
 * @copyright 2015 Max Kostinevich
 *
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
?>


<div id="postbox-container-1" class="postbox-container vstyler-right-sidebar">
	<div class="meta-box-sortables">
		<div class="postbox">
			<h3><span><?php esc_attr_e('Get help','visual-styler');?></span></h3>
			<div class="inside">
				<div>
					<ul>
						<li><a class="no-underline" target="_blank" href="https://wpcustomizerpro.com/docs/"><span class="dashicons dashicons-admin-home"></span> <?php esc_attr_e('Documentation','wpcustomizerpro');?></a></li>
						<li><a class="no-underline" target="_blank" href="https://wpcustomizerpro.com/support"><span class="dashicons dashicons-sos"></span> <?php esc_attr_e('Support Forum','wpcustomizerpro');?></a></li>
						<li><a class="no-underline" href="http://twitter.com/wpcustomizerpro" target="_blank" title="@WPCustomizerPRO"><span class="dashicons dashicons-twitter"></span> <?php esc_attr_e('@WPCustomizerPRO','wpcustomizerpro');?></a></li>
					</ul>
				</div>
				<div class="vstyler-sidebar-footer">
					<div class="vstyler-copyright">
						<?php esc_attr_e('Created with ','wpcustomizerpro');?> <span class="text-highlighted-second dashicons dashicons-heart"></span> by <a class="no-underline text-highlighted" href="https://maxkostinevich.com/" title="Max Kostinevich" target="_blank">Max Kostinevich</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>