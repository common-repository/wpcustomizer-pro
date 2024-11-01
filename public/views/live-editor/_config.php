<?php
/**
 * Visual Styler Config File
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");

/*
 * Will be applied with  vstyler_enabled_ids filter
 */
$vStylerEnabledIDs=array(
	'general'=>array('header','footer','comments','banner','slider'),
	'content'=>array('page','post','content','primary','main'),
	'widget'=>array('sidebar','secondary','widget','widget-area')
);

/*
 * Will be applied with  vstyler_enabled_classes filter
 */
$vStylerEnabledClasses=array(
	'general'=>array('post', 'page', 'attachment', 'content', 'site-content', 'content-area', 'site-main', 'main','meta','slider'),
	'body'=>array('home', 'blog', 'archive', 'date', 'search', 'attachment', 'error404', 'single', 'author', 'search-results'),
	'menu'=>array('main-menu', 'menu', 'nav', 'nav-item', 'current-menu-item', 'active', 'selected'),
	'widget'=>array('sidebar', 'secondary', 'widget-area', 'widget'),
	'content'=>array('entry','entry-title','entry-footer','entry-meta','entry-header','entry-content'),
	'comments'=>array('comments','comments-area','comments-title','comment','comment-body','comment-content','comment-meta','comment-metadata','comment-author','reply','comment-reply-link','comment-respond','comment-form'),
	'footer'=>array('footer','site-footer','copyright','site-info'),
);



/*
 * CSS Options fields
 */
$vStylerCSSOptions=array(
	'tab-general'=>array(),
	'tab-text'=>array(),
	'tab-borders'=>array(),
	'tab-background'=>array()
);

	/* GENERAL TAB */
	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'display',
		'title'=>esc_attr__('Display','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none'  => 'none',
				'inline' => 'inline',
				'block' => 'block',
				'flex' => 'flex',
				'inline-block' => 'inline-block',
				'inline-flex' => 'inline-flex',
				'inline-table' => 'inline-table',
				'list-item' => 'list-item',
				'table' => 'table'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'padding-top',
		'title'=>esc_attr__('Padding Top','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'padding-right',
		'title'=>esc_attr__('Padding Right','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'padding-bottom',
		'title'=>esc_attr__('Padding Bottom','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'padding-left',
		'title'=>esc_attr__('Padding Left','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'margin-top',
		'title'=>esc_attr__('Margin Top','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'margin-right',
		'title'=>esc_attr__('Margin Right','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'margin-bottom',
		'title'=>esc_attr__('Margin Bottom','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'margin-left',
		'title'=>esc_attr__('Margin Left','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px',
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'float',
		'title'=>esc_attr__('Float','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none'  => 'none',
				'left' => 'left',
				'right' => 'right'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'visibility',
		'title'=>esc_attr__('Visibility','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'visible'  => 'visible',
				'hidden' => 'hidden',
				'collapse' => 'collapse'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'position',
		'title'=>esc_attr__('Position','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'static'  => 'static',
				'absolute' => 'absolute',
				'fixed' => 'fixed',
				'relative' => 'relative'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'Top',
		'title'=>esc_attr__('Top','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'auto' => 'auto'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'right',
		'title'=>esc_attr__('Right','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'auto' => 'auto'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'bottom',
		'title'=>esc_attr__('Bottom','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'auto' => 'auto'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'left',
		'title'=>esc_attr__('Left','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'auto' => 'auto'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'overflow-x',
		'title'=>esc_attr__('Overflow-X','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'visible' => 'visible',
				'hidden' => 'hidden',
				'scroll' => 'scroll',
				'auto' => 'auto'
			)
		)
	);

	$vStylerCSSOptions['tab-general'][]=array(
		'name'=>'overflow-y',
		'title'=>esc_attr__('Overflow-Y','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'visible' => 'visible',
				'hidden' => 'hidden',
				'scroll' => 'scroll',
				'auto' => 'auto'
			)
		)
	);



	/* TEXT TAB */
	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'color',
		'title'=>esc_attr__('Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#000000'
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'font-family',
		'title'=>esc_attr__('Font Family','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
				'Courier, Monaco, monospace' => 'Courier, Monaco, monospace',
				'"Times New Roman", Georgia, serif' => '"Times New Roman", Georgia, serif'
			)
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'font-size',
		'title'=>esc_attr__('Font Size','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'1em' => '1em'
			)
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'font-style',
		'title'=>esc_attr__('Font Style','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'normal' => 'normal',
				'italic' => 'italic'
			)
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'font-weight',
		'title'=>esc_attr__('Font Weight','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'normal' => 'normal',
				'bold' => 'bold',
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900'
			)
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'text-align',
		'title'=>esc_attr__('Text Align','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'justify' => 'justify'
			)
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'text-transform',
		'title'=>esc_attr__('Text Transform','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'capitalize' => 'capitalize',
				'uppercase' => 'uppercase',
				'lowercase' => 'lowercase'
			)
		)
	);

	$vStylerCSSOptions['tab-text'][]=array(
		'name'=>'text-decoration',
		'title'=>esc_attr__('Text Decoration','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'underline' => 'underline',
				'overline' => 'overline',
				'line-through' => 'line-through'
			)
		)
	);


	/* BORDERS TAB */
	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-style',
		'title'=>esc_attr__('Border Style','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'solid' => 'solid',
				'dotted' => 'dotted',
				'dashed' => 'dashed',
				'double' => 'double'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-width',
		'title'=>esc_attr__('Border Width','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-color',
		'title'=>esc_attr__('Border Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#000000'
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-radius',
		'title'=>esc_attr__('Border Radius','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-top-style',
		'title'=>esc_attr__('Border Top Style','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'solid' => 'solid',
				'dotted' => 'dotted',
				'dashed' => 'dashed',
				'double' => 'double'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-top-width',
		'title'=>esc_attr__('Border Top Width','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-top-color',
		'title'=>esc_attr__('Border Top Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#000000'
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-top-radius',
		'title'=>esc_attr__('Border Top Radius','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-right-style',
		'title'=>esc_attr__('Border Right Style','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'solid' => 'solid',
				'dotted' => 'dotted',
				'dashed' => 'dashed',
				'double' => 'double'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-right-width',
		'title'=>esc_attr__('Border Right Width','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-right-color',
		'title'=>esc_attr__('Border Right Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#000000'
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-right-radius',
		'title'=>esc_attr__('Border Right Radius','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-bottom-style',
		'title'=>esc_attr__('Border Bottom Style','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'solid' => 'solid',
				'dotted' => 'dotted',
				'dashed' => 'dashed',
				'double' => 'double'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-bottom-width',
		'title'=>esc_attr__('Border Bottom Width','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-bottom-color',
		'title'=>esc_attr__('Border Bottom Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#000000'
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-bottom-radius',
		'title'=>esc_attr__('Border Bottom Radius','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-left-style',
		'title'=>esc_attr__('Border Left Style','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none',
				'solid' => 'solid',
				'dotted' => 'dotted',
				'dashed' => 'dashed',
				'double' => 'double'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-left-width',
		'title'=>esc_attr__('Border Left Width','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-left-color',
		'title'=>esc_attr__('Border Left Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#000000'
		)
	);

	$vStylerCSSOptions['tab-borders'][]=array(
		'name'=>'border-left-radius',
		'title'=>esc_attr__('Border Left Radius','visual-styler'),
		'field'=>array(
			'type'=>'slider',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px' => '0px'
			)
		)
	);



	/* BACKGROUND TAB */
	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background',
		'title'=>esc_attr__('Background','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-color',
		'title'=>esc_attr__('Background Color','visual-styler'),
		'field'=>array(
			'type'=>'colorpicker',
			'default'=>'#ffffff'
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-image',
		'title'=>esc_attr__('Background Image','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'allow-uploader'=>true,
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'none' => 'none'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-position',
		'title'=>esc_attr__('Background Position','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'0px 0px' => '0px 0px',
				'0% 0%' => '0% 0%',
				'left top' =>'left top',
				'left center' =>'left center',
				'left bottom' =>'left bottom',
				'right top' =>'right top',
				'right center' =>'right center',
				'right bottom' =>'right bottom',
				'center top' =>'center top',
				'center center' =>'center center',
				'center bottom' =>'center bottom'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-size',
		'title'=>esc_attr__('Background Size','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'contain' => 'contain',
				'cover' => 'cover',
				'auto' => 'auto',
				'100%' => '100%'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-repeat',
		'title'=>esc_attr__('Background Repeat','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'no-repeat' => 'no-repeat',
				'repeat' => 'repeat',
				'repeat-x' => 'repeat-x',
				'repeat-y' => 'repeat-y'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-origin',
		'title'=>esc_attr__('Background Origin','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'padding-box' => 'padding-box',
				'border-box' => 'border-box',
				'content-box' => 'content-box'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-clip',
		'title'=>esc_attr__('Background Clip','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'border-box' => 'border-box',
				'padding-box' => 'padding-box',
				'content-box' => 'content-box'
			)
		)
	);

	$vStylerCSSOptions['tab-background'][]=array(
		'name'=>'background-attachment',
		'title'=>esc_attr__('Background Attachment','visual-styler'),
		'field'=>array(
			'type'=>'dropdown',
			'options'=>array(
				'initial' => 'initial',
				'inherit' => 'inherit',
				'scroll' => 'scroll',
				'fixed' => 'fixed',
				'local' => 'local'
			)
		)
	);