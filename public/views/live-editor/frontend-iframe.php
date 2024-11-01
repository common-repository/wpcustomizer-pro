<?php

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");

/*
 * Include Visual Styler functions
 */
require_once '_functions.php';

/*
 * Include Visual Styler config file
 */
require_once '_config.php';

/*
 * When Visual Styler live editor is enabled - show current page in iFrame:
 * 1. Remove GET param vstyler-action from the current URL,
 * 2. Add GET param vstyler-action=hide-toolbar to hide admin bar
 */
$vstyler_iframe_url = add_query_arg('vstyler-action', 'hide-toolbar', remove_query_arg('vstyler-action'));

$vstyler_admin_url = get_admin_url();
$vstyler_media_uploader_url = $vstyler_admin_url.'media-upload.php?&referer=visual-styler-customizer-uploader&type=image&TB_iframe=true&post_id=0';
?>

<html lang="en-US" id="vstyler-live">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo __('Visual Styler','visual-styler').' | '.get_bloginfo( 'name' );?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
	<link rel='stylesheet' id='vstyler-font'  href='<?php echo plugins_url('/assets/css/vstyler-font.css', __FILE__); ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='jquery-ui-css'  href='<?php echo plugins_url('/assets/css/jquery-ui.min.css', __FILE__); ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='jquery-ui-css'  href='<?php echo plugins_url('/assets/css/jquery.editable-selectbox.css', __FILE__); ?>' type='text/css' media='all' />
	<link rel='stylesheet' id='live-editor-css'  href='<?php echo plugins_url('/assets/css/live-editor.css', __FILE__); ?>' type='text/css' media='all' />
</head>
<body id="vstyler-live-body">

<div id="vstyler-live-iframe-wrapper">
	<iframe id="vstyler-live-iframe" name="vstyler-live-iframe" src="<?php echo $vstyler_iframe_url; ?>" frameborder="0" scrolling="auto" width="100%" height="100%" marginwidth="0" marginheight="0"></iframe>
</div>


<div id="vstyler-live-bar">
	<div class="vstyler-live-bar-nav">
		<span class="nav-drag vs vs-icon-ellipsis-v"></span>
		<a href="#" title="Select Element" class="nav-item select-element vs vs-icon-location-arrow"></a>
		<a href="#" title="View History" class="nav-item live-bar-nav-item vs vs-icon-history" data-vstyler-content="vstyler-window-history"></a>
		<a href="#" title="Options" class="nav-item live-bar-nav-item vs vs-icon-gears" data-vstyler-content="vstyler-window-options"></a>
		<a href="<?php echo add_query_arg('vstyler-action', 'exit-toolbar',$vstyler_iframe_url);?>"  title="Exit" class="nav-item nav-exit vs vs-icon-power-off"></a>
	</div> <!-- .vstyler-live-bar-nav  -->

	<div id="vstyler-element-path-label"></div>

	<div id="vstyler-window-customizer" class="vstyler-live-bar-content">
		<div class="customizer-element-path-wrapper">
			<div class="window-title">Customizer</div>
			<div class="element-path-content"></div>
		</div> <!-- .customizer-element-path-wrapper -->
		<div class="customizer-element-styling-wrapper">
			<div class="window-title options-panel">
				<div class="customizer-options-nav options-group-1">
					<a href="#" title="On/off hover state" class="nav-item vs vs-icon-dot-circle-o" data-vstyler-role="changeState"></a>
				</div>
				<div class="customizer-options-nav options-group-2">
					<a href="#" title="CSS Breakpoints: Small screens only" class="nav-item vs vs-icon-mobile" data-vstyler-role="changeBreakPoint" data-vstyler-screen="mobile"></a>
					<a href="#" title="CSS Breakpoints: Tablets only" class="nav-item vs vs-icon-tablet" data-vstyler-role="changeBreakPoint" data-vstyler-screen="tablet"></a>
					<a href="#" title="CSS Breakpoints: Large screens only" class="nav-item vs vs-icon-desktop" data-vstyler-role="changeBreakPoint" data-vstyler-screen="desktop"></a>
				</div>
				<div class="customizer-options-nav options-group-3">
					<a href="#" title="View generated CSS-code" class="nav-item vs vs-icon-code" data-vstyler-role="showCode"></a>
				</div>
				<div class="customizer-options-nav options-group-4">
					<a href="#" title="Save Changes" class="nav-item vs vs-icon-save" data-vstyler-role="saveCode"></a>
				</div>
			</div> <!-- .window-title.options-panel -->
			<div id="customizer-css-options-wrapper" class="element-styling-content">
				<div class="customizer-css-options-tabs">
					<a href="#" class="nav-item" data-vstyler-content="customizer-tab-general">General</a>
					<a href="#" class="nav-item" data-vstyler-content="customizer-tab-text">Text</a>
					<a href="#" class="nav-item" data-vstyler-content="customizer-tab-borders">Borders</a>
					<a href="#" class="nav-item" data-vstyler-content="customizer-tab-background">Background</a>
				</div> <!-- .customizer-css-options-tabs -->
				<div class="customizer-css-options">
					<div id="customizer-tab-general" class="tabs-content-inner">
						<?php vStyler_render_customizer_tab($vStylerCSSOptions['tab-general']); ?>
					</div>
					<div id="customizer-tab-text" class="tabs-content-inner">
						<?php vStyler_render_customizer_tab($vStylerCSSOptions['tab-text']); ?>
					</div>
					<div id="customizer-tab-borders" class="tabs-content-inner">
						<?php vStyler_render_customizer_tab($vStylerCSSOptions['tab-borders']); ?>
					</div>
					<div id="customizer-tab-background" class="tabs-content-inner">
						<?php vStyler_render_customizer_tab($vStylerCSSOptions['tab-background']); ?>
					</div>
				</div> <!-- .customizer-css-options -->
			</div> <!-- .element-styling-content -->
			<div id="customizer-css-code-wrapper"  class="element-styling-content">
				<div  class="customizer-css-code-inner">
					<textarea id="customizer-css-code"></textarea>
				</div>
			</div>
		</div> <!-- .customizer-element-styling-wrapper -->
	</div> <!-- #vstyler-window-customizer -->

	<div id="vstyler-window-history" class="vstyler-live-bar-content">
		<div class="history-list-wrapper">
			<div class="window-title">History</div>
			<div class="history-list-container"></div>
		</div> <!-- .history-list-wrapper -->
		<div class="history-details-wrapper">
			<div class="window-title options-panel">
				<div class="history-options-nav options-group-1">
					<a href="#" title="Disable this CSS" class="nav-item vs vs-icon-eye-slash" data-vstyler-role="disableHistory"></a>
				</div>
				<div class="history-options-nav options-group-2">
					<a href="#" title="Save changes" class="nav-item vs vs-icon-save" data-vstyler-role="updateHistory"></a>
				</div>
				<div class="history-options-nav options-group-3">
					<a href="#" title="Delete this CSS" class="nav-item vs vs-icon-trash-o" data-vstyler-role="deleteHistory"></a>
				</div>
			</div> <!-- .window-title.options-panel -->
			<div class="history-details-content">
				<textarea id="history-details-code"></textarea>
			</div>
		</div>
	</div><!-- #vstyler-window-history -->

	<div id="vstyler-window-options" class="vstyler-live-bar-content">
		<a href="#" title="Mobile screen" class="nav-item vs vs-icon-mobile" data-vstyler-screen="mobile"></a>
		<a href="#" title="Tablet screen" class="nav-item vs vs-icon-tablet" data-vstyler-screen="tablet"></a>
		<a href="#" title="Desktop screen" class="nav-item vs vs-icon-desktop active"  data-vstyler-screen="desktop"></a>
		<a href="#" title="Fullscreen mode" class="nav-item vs vs-icon-expand" data-vstyler-screen="fullscreen"></a>
		<a href="https://wpcustomizerpro.com/support" target="_blank" title="Get Support" class="nav-item vs vs-icon-support"></a>
	</div> <!-- #vstyler-window-options -->
</div> <!-- #vstyler-live-bar -->

<div id="vstyler-media-iframe-wrapper">
	<iframe id="vstyler-media-iframe" name="vstyler-media-iframe" src="<?php echo $vstyler_media_uploader_url; ?>" data-media-uploader-url="<?php echo $vstyler_media_uploader_url;?>" frameborder="0" scrolling="auto" marginwidth="0" marginheight="0" ></iframe>
	<a href="#" title="Close Uploader" class="vs vs-icon-close" id="vstyler-close-iframe"></a>
</div> <!-- #vstyler-media-iframe-wrapper -->

<div id="vs-preloader"></div>

	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/jquery-1.11.3.min.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/jquery-ui.min.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/jquery.editable-selectbox.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/iris.min.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/watch.min.js', __FILE__); ?>'></script>

	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-helper.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-live-bar.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-history.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-element-customizer.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-element-chooser.js', __FILE__); ?>'></script>

<script>
	(function( $ ) {
		"use strict";
		$(function() {
			<?php
			$vStylerEnabledIDs=apply_filters( 'vstyler_enabled_ids', $vStylerEnabledIDs );
			$vStylerEnabledClasses=apply_filters( 'vstyler_enabled_classes', $vStylerEnabledClasses );
			?>
			vsElementChooser.enabledIDs=<?php echo json_encode($vStylerEnabledIDs); ?>;
			vsElementChooser.enabledClasses=<?php echo json_encode($vStylerEnabledClasses); ?>;

			vsElementCustomizer.CSSProperties=<?php echo json_encode($vStylerCSSOptions); ?>;


			vsHelper.wpAjax=<?php echo  json_encode(array(
				'ajaxURL'=>admin_url( 'admin-ajax.php' ),
				'nonce'=>wp_create_nonce( 'vstyler_ajax_request' )
				)
			); ?>;


		});
	}(jQuery));
</script>

	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-element-customizer-events-handler.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/vs-history-events-handler.js', __FILE__); ?>'></script>
	<script type='text/javascript' src='<?php echo plugins_url('/assets/js/live-editor.js', __FILE__); ?>'></script>

</body>
</html>