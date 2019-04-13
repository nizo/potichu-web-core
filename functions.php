<?php

global $avia_config;

/*
 * if you run a child theme and dont want to load the default functions.php file
 * set the global var below in you childthemes function.php to true:
 *
 * example: global $avia_config; $avia_config['use_child_theme_functions_only'] = true;
 * The default functions.php file will then no longer be loaded. You need to make sure then
 * to include framework and functions that you want to use by yourself.
 *
 * This is only recommended for advanced users
 */

if(isset($avia_config['use_child_theme_functions_only'])) return;

/*
 * create a global var which stores the ids of all posts which are displayed on the current page. It will help us to filter duplicate posts
 */
$avia_config['posts_on_current_page'] = array();


/*
 * wpml multi site config file
 * needs to be loaded before the framework
 */

require_once( 'config-wpml/config.php' );


/*
 * These are the available color sets in your backend.
 * If more sets are added users will be able to create additional color schemes for certain areas
 *
 * The array key has to be the class name, the value is only used as tab heading on the styling page
 */


$avia_config['color_sets'] = array(
    'header_color'      => 'Logo Area',
    'main_color'        => 'Main Content',
    'alternate_color'   => 'Alternate Content',
    'footer_color'      => 'Footer',
    'socket_color'      => 'Socket'
 );



/*
 * add support for responsive mega menus
 */

add_theme_support('avia_mega_menu');




/*
 * deactivates the default mega menu and allows us to pass individual menu walkers when calling a menu
 */

add_filter('avia_mega_menu_walker', '__return_false');


/*
 * adds support for the new avia sidebar manager
 */

add_theme_support('avia_sidebar_manager');

/*
 * Filters for post formats etc
 */
//add_theme_support('avia_queryfilter');



##################################################################
# AVIA FRAMEWORK by Kriesi

# this include calls a file that automatically includes all
# the files within the folder framework and therefore makes
# all functions and classes available for later use

require_once( 'framework/avia_framework.php' );

##################################################################


/*
 * Register additional image thumbnail sizes
 * Those thumbnails are generated on image upload!
 *
 * If the size of an array was changed after an image was uploaded you either need to re-upload the image
 * or use the thumbnail regeneration plugin: http://wordpress.org/extend/plugins/regenerate-thumbnails/
 */

$avia_config['imgSize']['widget'] 			 	= array('width'=>36,  'height'=>36);						// small preview pics eg sidebar news
$avia_config['imgSize']['square'] 		 	    = array('width'=>180, 'height'=>180);		                 // small image for blogs
$avia_config['imgSize']['featured'] 		 	= array('width'=>1500, 'height'=>430 );						// images for fullsize pages and fullsize slider
$avia_config['imgSize']['featured_large'] 		= array('width'=>1500, 'height'=>630 );						// images for fullsize pages and fullsize slider
$avia_config['imgSize']['extra_large'] 		 	= array('width'=>1500, 'height'=>1500 , 'crop' => false);	// images for fullscrren slider
$avia_config['imgSize']['portfolio'] 		 	= array('width'=>495, 'height'=>400 );						// images for portfolio entries (2,3 column)
$avia_config['imgSize']['portfolio_small'] 		= array('width'=>260, 'height'=>185 );						// images for portfolio 4 columns
$avia_config['imgSize']['gallery'] 		 		= array('width'=>845, 'height'=>684 );						// images for portfolio entries (2,3 column)
$avia_config['imgSize']['magazine'] 		 	= array('width'=>710, 'height'=>375 );						// images for magazines
$avia_config['imgSize']['masonry'] 		 		= array('width'=>705, 'height'=>705 , 'crop' => false);		// images for fullscreen masonry
$avia_config['imgSize']['entry_with_sidebar'] 	= array('width'=>845, 'height'=>321);		            	// big images for blog and page entries
$avia_config['imgSize']['entry_without_sidebar']= array('width'=>1210, 'height'=>423 );						// images for fullsize pages and fullsize slider
$avia_config['imgSize']['material_portfolio']	= array('width'=>203, 'height'=>135 );						// images for fullsize pages and fullsize slider



$avia_config['selectableImgSize'] = array(
	'square' 				=> __('Square','avia_framework'),
	'featured'  			=> __('Featured Thin','avia_framework'),
	'featured_large'  		=> __('Featured Large','avia_framework'),
	'portfolio' 			=> __('Portfolio','avia_framework'),
	'gallery' 				=> __('Gallery','avia_framework'),
	'entry_with_sidebar' 	=> __('Entry with Sidebar','avia_framework'),
	'entry_without_sidebar'	=> __('Entry without Sidebar','avia_framework'),
	'extra_large' 			=> __('Fullscreen Sections/Sliders','avia_framework'),
	'material_portfolio' 	=> __('Material portfolio - thumbnail size','avia_framework'),
);

avia_backend_add_thumbnail_size($avia_config);

if ( ! isset( $content_width ) ) $content_width = $avia_config['imgSize']['featured']['width'];




/*
 * register the layout classes
 *
 */

$avia_config['layout']['fullsize'] 		= array('content' => 'av-content-full alpha', 'sidebar' => 'hidden', 	  	  'meta' => '','entry' => '');
$avia_config['layout']['sidebar_left'] 	= array('content' => 'av-content-small', 	  'sidebar' => 'alpha' ,'meta' => 'alpha', 'entry' => '');
$avia_config['layout']['sidebar_right'] = array('content' => 'av-content-small alpha','sidebar' => 'alpha', 'meta' => 'alpha', 'entry' => 'alpha');




function ExpandSubmenuInMobile(){
?>
<script>
    jQuery(document).ready(function() {
      var menuItem    = jQuery('li.menu-item-has-children'),
          subMenuIcon = jQuery('.subMenuIcon');
      menuItem.each(function() {
        jQuery(this).append( "<div class='subMenuIcon'>+</div>" );
        jQuery(this).addClass("hideSubmenu");
      });
      jQuery(document).on('click', '.subMenuIcon', function () {
        var submenuContainer = jQuery(this).closest('li.menu-item-has-children');
        var iconContainer = jQuery(submenuContainer).children(".subMenuIcon");

        console.log('---', submenuContainer, iconContainer);
        if (jQuery(submenuContainer).hasClass("hideSubmenu")) {
          jQuery(iconContainer).html("-");
        } else {
          jQuery(iconContainer).html("+");
        }

        jQuery(submenuContainer).toggleClass("hideSubmenu");
      });
    });
</script>
<?php
}
add_action('wp_footer', 'ExpandSubmenuInMobile');
/*
 * These are some of the font icons used in the theme, defined by the entypo icon font. the font files are included by the new aviaBuilder
 * common icons are stored here for easy retrieval
 */

 $avia_config['font_icons'] = apply_filters('avf_default_icons', array(

    //post formats +  types
    'standard' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue836'),
    'link'    		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue822'),
    'image'    		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue80f'),
    'audio'    		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue801'),
    'quote'   		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue833'),
    'gallery'   	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue80e'),
    'video'   		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue80d'),
    'portfolio'   	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue849'),
    'product'   	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue859'),

    //social
    'behance' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue915'),
	'dribbble' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8fe'),
	'facebook' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8f3'),
	'flickr' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8ed'),
	'gplus' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8f6'),
	'linkedin' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8fc'),
	'instagram' 	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue909'),
	'pinterest' 	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8f8'),
	'skype' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue90d'),
	'tumblr' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8fa'),
	'twitter' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8f1'),
	'vimeo' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8ef'),
	'rss' 			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue853'),
	'youtube'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue921'),
	'xing'			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue923'),
	'soundcloud'	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue913'),
	'five_100_px'	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue91d'),
	'vk'			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue926'),
	'reddit'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue927'),
	'digg'			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue928'),
	'delicious'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue929'),
	'mail' 			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue805'),

	//woocomemrce
	'cart' 			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue859'),
	'details'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue84b'),

	//bbpress
	'supersticky'	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue808'),
	'sticky'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue809'),
	'one_voice'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue83b'),
	'multi_voice'	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue83c'),
	'closed'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue824'),
	'sticky_closed' => array( 'font' =>'entypo-fontello', 'icon' => 'ue808\ue824'),
	'supersticky_closed' => array( 'font' =>'entypo-fontello', 'icon' => 'ue809\ue824'),

	//navigation, slider & controls
	'play' 			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue897'),
	'pause'			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue899'),
	'next'    		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue879'),
    'prev'    		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue878'),
    'next_big'  	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue87d'),
    'prev_big'  	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue87c'),
	'close'			=> array( 'font' =>'entypo-fontello', 'icon' => 'ue814'),
	'reload'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue891'),
	'mobile_menu'	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8a5'),

	//image hover overlays
    'ov_external'	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue832'),
    'ov_image'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue869'),
    'ov_video'		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue897'),


	//misc
    'search'  		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue803'),
    'info'    		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue81e'),
	'clipboard' 	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue8d1'),
	'scrolltop' 	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue876'),
	'scrolldown' 	=> array( 'font' =>'entypo-fontello', 'icon' => 'ue877'),
	'bitcoin' 		=> array( 'font' =>'entypo-fontello', 'icon' => 'ue92a'),

));






add_theme_support( 'automatic-feed-links' );

##################################################################
# Frontend Stuff necessary for the theme:
##################################################################
/*
 * Register theme text domain
 */
if(!function_exists('avia_lang_setup'))
{
	add_action('after_setup_theme', 'avia_lang_setup');
	function avia_lang_setup()
	{
		$lang = apply_filters('ava_theme_textdomain_path', get_template_directory()  . '/lang');
		load_theme_textdomain('avia_framework', $lang);
	}
}


/*
 * Register frontend javascripts:
 */
if(!function_exists('avia_register_frontend_scripts'))
{
	if(!is_admin()){
		add_action('wp_enqueue_scripts', 'avia_register_frontend_scripts');
	}

	function avia_register_frontend_scripts()
	{
		$template_url = get_template_directory_uri();
		$child_theme_url = get_stylesheet_directory_uri();

		//register js
		wp_enqueue_script( 'avia-compat', $template_url.'/js/avia-compat.js', array('jquery'), 2, false ); //needs to be loaded at the top to prevent bugs
		wp_enqueue_script( 'avia-default', $template_url.'/js/avia.js', array('jquery'), 3, true );
		wp_enqueue_script( 'avia-shortcodes', $template_url.'/js/shortcodes.js', array('jquery'), 5, true );
		wp_enqueue_script( 'avia-popup',  $template_url.'/js/aviapopup/jquery.magnific-popup.min.js', array('jquery'), 2, true);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-mediaelement' );


		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }


		//register styles
		wp_register_style( 'avia-style' ,  $child_theme_url."/style.css", array(), 		'2', 'all'); //register default style.css file. only include in childthemes. has no purpose in main theme
		wp_register_style( 'avia-custom',  $template_url."/css/custom.css", array(), 	'33', 'all');

		wp_enqueue_style( 'avia-grid' ,   $template_url."/css/grid.css", array(), 		'2', 'all' );
		wp_enqueue_style( 'avia-base' ,   $template_url."/css/base.css", array(), 		'2', 'all' );
		wp_enqueue_style( 'avia-layout',  $template_url."/css/layout.css", array(), 	'4', 'all' );
		wp_enqueue_style( 'avia-scs',     $template_url."/css/shortcodes.css", array(), '3', 'all' );
		wp_enqueue_style( 'avia-popup-css', $template_url."/js/aviapopup/magnific-popup.css", array(), '1', 'screen' );
		//wp_enqueue_style( 'avia-media'  , $template_url."/js/mediaelement/skin-1/mediaelementplayer.css", array(), '1', 'screen' );
		//wp_enqueue_style( 'avia-print' ,  $template_url."/css/print.css", array(), '1', 'print' );

		wp_register_script( 'chart', get_template_directory_uri().'/js/chart.js', array('jquery'), 1, true );
		wp_enqueue_script( 'chart' );


        global $avia;
		$safe_name = avia_backend_safe_string($avia->base_data['prefix']);

        if( get_option('avia_stylesheet_exists'.$safe_name) == 'true' )
        {
            $avia_upload_dir = wp_upload_dir();
            if(is_ssl()) $avia_upload_dir['baseurl'] = str_replace("http://", "https://", $avia_upload_dir['baseurl']);

            $avia_dyn_stylesheet_url = $avia_upload_dir['baseurl'] . '/dynamic_avia/'.$safe_name.'.css';
			$version_number = get_option('avia_stylesheet_dynamic_version'.$safe_name);
			if(empty($version_number)) $version_number = '1';

            wp_enqueue_style( 'avia-dynamic', $avia_dyn_stylesheet_url, array(), $version_number, 'all' );
        }

		wp_enqueue_style( 'avia-custom');


		if($child_theme_url !=  $template_url)
		{
			wp_enqueue_style( 'avia-style');
		}

	}
}


if(!function_exists('avia_remove_default_video_styling'))
{
	if(!is_admin()){
		add_action('wp_footer', 'avia_remove_default_video_styling', 1);
	}

	function avia_remove_default_video_styling()
	{
		//remove default style for videos
		wp_dequeue_style( 'mediaelement' );
		// wp_dequeue_script( 'wp-mediaelement' );
		// wp_dequeue_style( 'wp-mediaelement' );
	}
}




/*
 * Activate native wordpress navigation menu and register a menu location
 */
if(!function_exists('avia_nav_menus'))
{
	function avia_nav_menus()
	{
		global $avia_config, $wp_customize;

		add_theme_support('nav_menus');

		foreach($avia_config['nav_menus'] as $key => $value)
		{
			//wp-admin\customize.php does not support html code in the menu description - thus we need to strip it
			$name = (!empty($value['plain']) && !empty($wp_customize)) ? $value['plain'] : $value['html'];
			register_nav_menu($key, THEMENAME.' '.$name);
		}
	}

	$avia_config['nav_menus'] = array(	'avia' => array('html' => __('Main Menu', 'avia_framework')),
										'avia2' => array(
													'html' => __('Secondary Menu <br/><small>(Will be displayed if you selected a header layout that supports a submenu <a target="_blank" href="'.admin_url('?page=avia#goto_header').'">here</a>)</small>', 'avia_framework'),
													'plain'=> __('Secondary Menu - will be displayed if you selected a header layout that supports a submenu', 'avia_framework')),
										'avia3' => array(
													'html' => __('Footer Menu <br/><small>(no dropdowns)</small>', 'avia_framework'),
													'plain'=> __('Footer Menu (no dropdowns)', 'avia_framework'))
									);

	avia_nav_menus(); //call the function immediatly to activate
}










/*
 *  load some frontend functions in folder include:
 */

require_once( 'includes/admin/register-portfolio.php' );		// register custom post types for portfolio entries
require_once( 'includes/admin/register-widget-area.php' );		// register sidebar widgets for the sidebar and footer
require_once( 'includes/loop-comments.php' );					// necessary to display the comments properly
require_once( 'includes/helper-template-logic.php' ); 			// holds the template logic so the theme knows which tempaltes to use
require_once( 'includes/helper-social-media.php' ); 			// holds some helper functions necessary for twitter and facebook buttons
require_once( 'includes/helper-post-format.php' ); 				// holds actions and filter necessary for post formats
require_once( 'includes/helper-markup.php' ); 					// holds the markup logic (schema.org and html5)
require_once( 'includes/admin/register-plugins.php');			// register the plugins we need

if(current_theme_supports('avia_conditionals_for_mega_menu'))
{
	require_once( 'includes/helper-conditional-megamenu.php' );  // holds the walker for the responsive mega menu
}

require_once( 'includes/helper-responsive-megamenu.php' ); 		// holds the walker for the responsive mega menu




//adds the plugin initalization scripts that add styles and functions

if(!current_theme_supports('deactivate_layerslider')) require_once( 'config-layerslider/config.php' );//layerslider plugin

require_once( 'config-bbpress/config.php' );					//compatibility with  bbpress forum plugin
require_once( 'config-templatebuilder/config.php' );			//templatebuilder plugin
require_once( 'config-gravityforms/config.php' );				//compatibility with gravityforms plugin
require_once( 'config-woocommerce/config.php' );				//compatibility with woocommerce plugin
require_once( 'config-wordpress-seo/config.php' );				//compatibility with Yoast WordPress SEO plugin
require_once( 'config-events-calendar/config.php' );			//compatibility with the Events Calendar plugin


if(is_admin())
{
	require_once( 'includes/admin/helper-compat-update.php');	// include helper functions for new versions
}




/*
 *  dynamic styles for front and backend
 */
if(!function_exists('avia_custom_styles'))
{
	function avia_custom_styles()
	{
		require_once( 'includes/admin/register-dynamic-styles.php' );	// register the styles for dynamic frontend styling
		avia_prepare_dynamic_styles();
	}

	add_action('init', 'avia_custom_styles', 20);
	add_action('admin_init', 'avia_custom_styles', 20);
}




/*
 *  activate framework widgets
 */
if(!function_exists('avia_register_avia_widgets'))
{
	function avia_register_avia_widgets()
	{
		register_widget( 'avia_newsbox' );
		register_widget( 'avia_portfoliobox' );
		register_widget( 'avia_socialcount' );
		register_widget( 'avia_combo_widget' );
		register_widget( 'avia_partner_widget' );
		register_widget( 'avia_google_maps' );
		register_widget( 'avia_fb_likebox' );


	}

	avia_register_avia_widgets(); //call the function immediatly to activate
}



/*
 *  add post format options
 */
add_theme_support( 'post-formats', array('link', 'quote', 'gallery','video','image','audio' ) );



/*
 *  Remove the default shortcode function, we got new ones that are better ;)
 */
add_theme_support( 'avia-disable-default-shortcodes', true);


/*
 * compat mode for easier theme switching from one avia framework theme to another
 */
add_theme_support( 'avia_post_meta_compat');


/*
 * make sure that enfold widgets dont use the old slideshow parameter in widgets, but default post thumbnails
 */
add_theme_support('force-post-thumbnails-in-widget');







/*
 *  register custom functions that are not related to the framework but necessary for the theme to run
 */

require_once( 'functions-enfold.php');


/*
 * add option to edit elements via css class
 */
// add_theme_support('avia_template_builder_custom_css');


/* Constrcution POST TYPE */

add_action( 'init', 'register_constructions_post_type' );
function register_constructions_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Constructions',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-admin-settings'

    );
    register_post_type( 'construction', $args );
}

add_action( 'init', 'register_construction_taxonomies' );
function register_construction_taxonomies() {

    $labels = array(
		'name'                       => 'Noise Originators',
		'singular_name'              => 'Noise Originator',
		'search_items'               => 'Search Noise Originators',
		'popular_items'              => 'Popular Noise Originators',
		'all_items'                  => 'All Noise Originators',
		'edit_item'                  => 'Edit Noise Originator',
		'update_item'                => 'Update Noise Originator',
		'add_new_item'               => 'Add New Noise Originator',
		'new_item_name'              => 'New Construction Name',
		'separate_items_with_commas' => 'Separate Noise Originators with commas',
		'add_or_remove_items'        => 'Add or remove Noise Originators',
		'choose_from_most_used'      => 'Choose from the most used Noise Originators',
		'not_found'                  => 'No construction found',
		'menu_name'                  => 'Noise Originators'
	);

	register_taxonomy(
		'noise_originator',
		'construction',
		array(
			'labels' => $labels,
			'hierarchical' => true
		)
	);

    $labels = array(
		'name'                       => 'Noise Types',
		'singular_name'              => 'Noise Type',
		'search_items'               => 'Search Noise Types',
		'popular_items'              => 'Popular Noise Types',
		'all_items'                  => 'All Noise Types',
		'edit_item'                  => 'Edit Noise Type',
		'update_item'                => 'Update Noise Type',
		'add_new_item'               => 'Add New Noise Type',
		'new_item_name'              => 'New Noise Type Name',
		'separate_items_with_commas' => 'Separate Noise Types with commas',
		'add_or_remove_items'        => 'Add or remove Noise Type',
		'choose_from_most_used'      => 'Choose from the most used Noise Types',
		'not_found'                  => 'No Noise Types found',
		'menu_name'                  => 'Noise Types'
	);

	register_taxonomy(
		'noise_type',
		'construction',
		array(
			'labels' => $labels,
			'hierarchical' => true
		)
	);


    $labels = array(
		'name'                       => 'Construction Width',
		'singular_name'              => 'Construction Width',
		'search_items'               => 'Search Construction Width',
		'popular_items'              => 'Popular Construction Width',
		'all_items'                  => 'All Construction Width',
		'edit_item'                  => 'Edit Construction Width',
		'update_item'                => 'Update Construction Width',
		'add_new_item'               => 'Add New Construction Width',
		'new_item_name'              => 'New Construction Width Name',
		'separate_items_with_commas' => 'Separate Construction Width with commas',
		'add_or_remove_items'        => 'Add or remove Construction Width',
		'choose_from_most_used'      => 'Choose from the most used Construction Width',
		'not_found'                  => 'No Construction Width found',
		'menu_name'                  => 'Construction Width'
	);


	register_taxonomy(
		'construction_width',
		'construction',
		array(
			'labels' => $labels,
			'hierarchical' => true
		)
	);

	$labels = array(
		'name'                       => 'Construction Approach',
		'singular_name'              => 'Construction Approach',
		'search_items'               => 'Search Construction Approach',
		'popular_items'              => 'Popular Construction Approach',
		'all_items'                  => 'All Construction Approach',
		'edit_item'                  => 'Edit Construction Approach',
		'update_item'                => 'Update Construction Approach',
		'add_new_item'               => 'Add New Construction Approach',
		'new_item_name'              => 'New Construction Approach Name',
		'separate_items_with_commas' => 'Separate Construction Approach with commas',
		'add_or_remove_items'        => 'Add or remove Construction Approach',
		'choose_from_most_used'      => 'Choose from the most used Construction Approach',
		'not_found'                  => 'No Construction Approach found',
		'menu_name'                  => 'Construction Approach'
	);


	register_taxonomy(
		'construction_approach',
		'construction',
		array(
			'labels' => $labels,
			'hierarchical' => true
		)
	);

	register_taxonomy_for_object_type( 'construction', 'construction_width' );
	register_taxonomy_for_object_type( 'construction', 'noise_type' );
	register_taxonomy_for_object_type( 'construction', 'noise_originator' );


}

add_filter('avf_builder_boxes','products_post_type_options');
function products_post_type_options($boxes) {

	$boxes = array(
		array( 'title' =>__('Avia Layout Builder','avia_framework' ), 'id'=>'avia_builder', 'page'=>array('portfolio','page','post','product'), 'context'=>'normal', 'priority'=>'high', 'expandable'=>true ),
		array( 'title' =>__('Layout','avia_framework' ), 'id'=>'layout', 'page'=>array('portfolio', 'page' , 'post','product'), 'context'=>'side', 'priority'=>'low'),
		array( 'title' =>__('Additional Portfolio Settings','avia_framework' ), 'id'=>'preview', 'page'=>array('portfolio'), 'context'=>'normal', 'priority'=>'high' ),
		array( 'title' =>__('Breadcrumb Hierarchy','avia_framework' ), 'id'=>'hierarchy', 'page'=>array('portfolio'), 'context'=>'side', 'priority'=>'low'),
	);

	return $boxes;
}

function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function modify_jquery() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-1.11.3.min.js');
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');


add_action( 'wp_ajax_fetchConstructions', 'fetchConstructions' );
add_action( 'wp_ajax_nopriv_fetchConstructions', 'fetchConstructions' );

function fetchConstructions() {


	$args = array(
		'post_type' => 'construction',
		'tax_query' => array(
			'relation' => 'AND'
		),
	);

	if ($_POST['width']) {
		array_push($args['tax_query'],
			array(
				'taxonomy' => 'construction_width',
				'field'    => 'slug',
				'terms'    => $_POST['width'],
			)
		);
	}

	if ($_POST['originator']) {
		array_push($args['tax_query'],
			array(
				'taxonomy' => 'noise_originator',
				'field'    => 'slug',
				'terms'    => $_POST['originator'],
			)
		);
	}

	if ($_POST['noiseType']) {
		array_push($args['tax_query'],
			array(
				'taxonomy' => 'noise_type',
				'field'    => 'slug',
				'terms'    => $_POST['noiseType'],
			)
		);
	}



	$query = new WP_Query( $args );
	$result = '<div class="constructions">';


	if ($query->have_posts()) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$result .= '<div class="construction">';

			$result .= get_the_post_thumbnail();

			$result .= '<div class="data">';
			$result .= '<h3>' .  get_the_title() . '</h3>';

			$result .= '<strong>hrúbka: 50mm</strong>';
			$result .= '<strong>efektivita: ...</strong>';

			$result .= '</div>';

			$result .= '</div>';

		}
	}
	else echo 'no constructions found';

	$result .= '</div>';

	echo $result;
	die();
}

function fetchPage($slug) {
	$page = get_posts( array(
		'name' => $slug,
		'post_type' => 'page'
		)
	);

	if ( $page ) {
		$content = apply_filters('the_content', $page[0]->post_content);
		echo $content;
	}
}

add_action('wp_head','add_ajaxurl');
function add_ajaxurl() {
	?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
	<?php
}

//add_filter('avf_contact_form_submit_button_attr','avia_add_submit_attributes_to_cf', 10, 3);
/*
function avia_add_submit_attributes_to_cf($att, $formID, $form_params){
	$att = "onclick=\"ga('send', 'event', 'Contact', 'Contact form', 'Contact form submitted', 1);\"";
	return $att;
}
*/

/* PIPEDRIVE SECTION START */
add_action( 'potichu_submit_job_hook', 'potichu_submit_job_to_pipedrive', 10, 1);

function potichu_submit_job_to_pipedrive_handler($jobDetails) {
	$args = array($jobDetails);
	wp_schedule_single_event( time() + 10, 'potichu_submit_job_hook', $args);
}

function potichu_submit_job_to_pipedrive($jobDetails) {
	// $jobDetails should contain following items in following order
	// MENO PRIEZVISKO
	// EMAIL
	// TELEFON
	// MESTO
	// TYP PROBLEMU
	// POPIS PROBLEMU

	if (get_option('web_locale', 'sk') === 'sk') {
		$api_token = '4fae12d61eae55ca09ad67d09202559d01349afd';
		$assignedToPersonUserId = 2479848;
		$cityId = 'd939ca8cc6a11101553489d9bd2c9fc84c2930ec';
	} else {
		$api_token = '2dbe5a7e699f15990b5b8fccda79a90ba19af617';
		$assignedToPersonUserId = 3086675;
		$cityId = '3635d1573043f91389788ea00ba3a30caa36ac31';
	}

	$name = $jobDetails[0];
	$email = $jobDetails[1];
	$phone = $jobDetails[2];
	$city = $jobDetails[3];
	$problemType = $jobDetails[4];
	$note = $jobDetails[5];

	// main data about the person. org_id is added later dynamically
	$person = array(
	 'name' => $name,
	 'email' => $email,
	 'phone' => $phone,
	 'd939ca8cc6a11101553489d9bd2c9fc84c2930ec' => $city
	);

	// main data about the deal. person_id and org_id is added later dynamically
	$deal = array(
	 'title' => $name . ' - formulár',
	 'user_id' => $assignedToPersonUserId
	);

	// try adding a person and get back the ID
	$person_id = create_person($api_token, $person);

	// if the person was added successfully add the deal and link it to the organization and the person
	if ($person_id) {
		echo "Person added successfully!";
		$deal['person_id'] = $person_id;
		// try adding a person and get back the ID
		$deal_id = create_deal($api_token, $deal);

		if ($deal_id) {
			echo "<br/>Deal added successfully!";
		}

		$activity = array(
			'subject' => 'Dopyt z webstránky',
			'type' => 'task',
			'due_date' => date("Y-m-d"),
			'deal_id' => $deal_id,
			'user_id' => $assignedToPersonUserId,
			'note' =>  $note . PHP_EOL . $problemType
		);

		// try setting activity to a deal
		$activity_id = add_activity($api_token, $activity);
		if ($activity_id) {
			echo "<br/>Activity added successfully!";
		}


	} else {
		echo "There was a problem with adding the person!";
	}
}

function create_person($api_token, $person) {
	$url = "https://api.pipedrive.com/v1/persons?api_token=" . $api_token;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $person);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	// create an array from the data that is sent back from the API
	$result = json_decode($output, 1);
	// check if an id came back
	if (!empty($result['data']['id'])) {
	$person_id = $result['data']['id'];
		return $person_id;
		} else {
		return false;
	}
}

function create_deal($api_token, $deal) {
	$url = "https://api.pipedrive.com/v1/deals?api_token=" . $api_token;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	// create an array from the data that is sent back from the API
	$result = json_decode($output, 1);
	// check if an id came back
	if (!empty($result['data']['id'])) {
		$deal_id = $result['data']['id'];
		return $deal_id;
		} else {
		return false;
	}
}

function add_activity($api_token, $activity) {
	$url = "https://api.pipedrive.com/v1/activities?api_token=" . $api_token;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $activity);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	// create an array from the data that is sent back from the API
	$result = json_decode($output, 1);
	// check if an id came back
	if (!empty($result['data']['id'])) {
		$activity_id = $result['data']['id'];
		return $activity_id;
		} else {
		return false;
	}
}

/* PIPEDRIVE SECTION END */
