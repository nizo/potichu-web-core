<?php
	if ( ! defined('ABSPATH') ){ die(); }

	global $avia_config;

	$lightbox_option = avia_get_option( 'lightbox_active' );
	$avia_config['use_standard_lightbox'] = empty( $lightbox_option ) || ( 'lightbox_active' == $lightbox_option ) ? 'lightbox_active' : 'disabled';
	/**
	 * Allow to overwrite the option setting for using the standard lightbox
	 * Make sure to return 'disabled' to deactivate the standard lightbox - all checks are done against this string
	 *
	 * @added_by Günter
	 * @since 4.2.6
	 * @param string $use_standard_lightbox				'lightbox_active' | 'disabled'
	 * @return string									'lightbox_active' | 'disabled'
	 */
	$avia_config['use_standard_lightbox'] = apply_filters( 'avf_use_standard_lightbox', $avia_config['use_standard_lightbox'] );

	$style 					= $avia_config['box_class'];
	$responsive				= avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
	$blank 					= isset($avia_config['template']) ? $avia_config['template'] : "";
	$av_lightbox			= $avia_config['use_standard_lightbox'] != "disabled" ? 'av-default-lightbox' : 'av-custom-lightbox';
	$preloader				= avia_get_option('preloader') == "preloader" ? 'av-preloader-active av-preloader-enabled' : 'av-preloader-disabled';
    $sidebar_styling 		= avia_get_option('sidebar_styling');
	$filterable_classes 	= avia_header_class_filter( avia_header_class_string() );
	$av_classes_manually	= "av-no-preview"; /*required for live previews*/

	/**
	 * Allows to alter default settings Enfold-> Main Menu -> General -> Menu Items for Desktop
	 * @since 4.4.2
	 */
	$is_burger_menu = apply_filters( 'avf_burger_menu_active', avia_is_burger_menu(), 'header' );
	$av_classes_manually   .= $is_burger_menu ? " html_burger_menu_active" : " html_text_menu_active";

	/**
	 * Add additional custom body classes
	 * e.g. to disable default image hover effect add av-disable-avia-hover-effect
	 *
	 * @since 4.4.2
	 */
	$custom_body_classes = apply_filters( 'avf_custom_body_classes', '' );

	/**
	 * @since 4.2.3 we support columns in rtl order (before they were ltr only). To be backward comp. with old sites use this filter.
	 */
	$rtl_support			= 'yes' == apply_filters( 'avf_rtl_column_support', 'yes' ) ? ' rtl_columns ' : '';

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo "html_{$style} ".$responsive." ".$preloader." ".$av_lightbox." ".$filterable_classes." ".$av_classes_manually ?> ">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />


<?php
global $post;

if (is_single(get_the_ID()) || $post->post_parent != 0) {

	$id = get_the_ID();
	$post = get_post($id);	
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'medium' );
	$url = $thumb['0'];
	$title =  str_replace('<sup>', '', get_the_title($id));
	$title =  str_replace('</sup>', '', $title);
	?>
	<meta property="og:site_name" content="Potichu" />
	<meta property="og:title" content="<?php echo $title; ?>" />
	<meta property="og:url" content="<?php echo get_permalink($id); ?>" />
	<meta property="og:image" content="<?php echo $url; ?>" />
	<meta property="og:description" content="<?php echo $post->post_excerpt; ?>" />
	<meta property="og:type" content="website" />
<?php
} else {
?>
	<meta property="og:site_name" content="Potichu" />
	<meta property="og:title" content="Zvukové izolácie" />
	<meta property="og:description" content="" />
	<meta property="og:type" content="website" />

<?php }

	$facebookSrc = '';
	$webLocale = get_option('web_locale', 'sk');

	if ($webLocale == 'sk')	{
		echo '<meta property="og:url" content="https://www.potichu.sk" />';
		echo '<meta property="og:image" content="https://potichu.sk/logo-sk.png" />';
		$facebookSrc = "//connect.facebook.net/sk_SK/all.js#xfbml=1&appId=589860764410747";
	}
	else {
		echo '<meta property="og:url" content="https://www.potichu.cz" />';
		echo '<meta property="og:image" content="https://potichu.cz/logo-cz.png" />';
		$facebookSrc = "//connect.facebook.net/cs_CZ/all.js#xfbml=1&appId=589860764410747";
	}



	$materialPageID = get_page_by_title( 'materialy')->ID;
	$currentPageParentID= get_post_ancestors( $the_id )[0];

	if (empty($currentPageParentID)) $currentPageParentID = -1;
	global $singleMaterialPage;
	$singleMaterialPage = ($materialPageID == $currentPageParentID);

	?>

<link rel="manifest" href="<?php echo get_stylesheet_directory_uri() . '/manifest.json'?>">

<link rel="dns-prefetch" href="//app.livechatoo.com">

<link rel="preconnect" href="https://ajax.googleapis.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://googleads.g.doubleclick.net">
<link rel="preconnect" href="https://ssl.google-analytics.com">
<link rel="preconnect" href="https://www.google-analytics.com">


<link href="https://www.google.com/+PotichuSk" rel="publisher" />
<link rel="author" href="https://plus.google.com/103386127817600208643"/>

<?php
/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */
if (function_exists('avia_set_follow')) { echo avia_set_follow(); }

?>


<!-- mobile setting -->
<?php

if( strpos($responsive, 'responsive') !== false ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
?>


<!-- Scripts/CSS and wp_head hook -->
<?php
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head();

?>

</head>




<body id="top" <?php body_class( $custom_body_classes . ' ' . $rtl_support . $style." ".$avia_config['font_stack']." ".$blank." ".$sidebar_styling); avia_markup_helper(array('context' => 'body')); ?>>

<?php
	$webLocale = get_option('web_locale', 'sk');

	if ($webLocale == 'sk') {
		echo '<a href="https://eshop.potichu.sk" target="_blank" class="eshop-link" style="display: none;">Otvoriť e-shop</a>';
	} else {
		echo '<a href="https://eshop.potichu.cz" target="_blank" class="eshop-link" style="display: none;">Otevřít e-shop</a>';
	}
?>

<div id="fb-root"></div>
<!--
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "<?php echo $facebookSrc; ?>";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



	</script>
	-->

	<?php

	/**
	 * WP 5.2 add a new function - stay backwards compatible with older WP versions and support plugins that use this hook
	 * https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
	 *
	 * @since 4.5.6
	 */
	if( function_exists( 'wp_body_open' ) )
	{
		wp_body_open();
	}
	else
	{
		do_action( 'wp_body_open' );
	}

	do_action( 'ava_after_body_opening_tag' );

	if("av-preloader-active av-preloader-enabled" === $preloader)
	{
		echo avia_preload_screen();
	}

	?>

	<div id='wrap_all'>

	<?php
	if(!$blank) //blank templates dont display header nor footer
	{
		 //fetch the template file that holds the main menu, located in includes/helper-menu-main.php
         get_template_part( 'includes/helper', 'main-menu' );

	} ?>

	<div id='main' class='all_colors' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>

	<?php

		if(isset($avia_config['temp_logo_container'])) echo $avia_config['temp_logo_container'];
		do_action('ava_after_main_container');

