<?php
	global $avia_config;

	$style 		= $avia_config['box_class'];
	$responsive	= avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
	$blank 		= isset($avia_config['template']) ? $avia_config['template'] : "";
	$av_lightbox= avia_get_option('lightbox_active') != "disabled" ? 'av-default-lightbox' : 'av-custom-lightbox';

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo " html_{$style} ".$responsive." ".$av_lightbox." ".avia_header_class_string();?> ">
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
		echo '<meta property="og:url" content="http://www.potichu.sk" />';
		echo '<meta property="og:image" content="http://potichu.sk/logo-sk.png" />';
		$facebookSrc = "//connect.facebook.net/sk_SK/all.js#xfbml=1&appId=589860764410747";
	}
	else if ($webLocale == 'cz') {
		echo '<meta property="og:url" content="http://www.potichu.cz" />';
		echo '<meta property="og:image" content="http://potichu.cz/logo-cz.png" />';
		$facebookSrc = "//connect.facebook.net/cs_CZ/all.js#xfbml=1&appId=589860764410747";
	}



	$materialPageID = get_page_by_title( 'materialy')->ID;
	$currentPageParentID= get_post_ancestors( $the_id )[0];

	if (empty($currentPageParentID)) $currentPageParentID = -1;
	global $singleMaterialPage;
	$singleMaterialPage = ($materialPageID == $currentPageParentID);

	?>

<link rel="dns-prefetch" href="//google-analytics.com">
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//app.livechatoo.com">



<!-- page title, displayed in your browser bar -->
<title><?php if(function_exists('avia_set_title_tag')) { echo avia_set_title_tag(); } ?></title>

<link href="https://www.google.com/+PotichuSk" rel="publisher" />
<link rel="author" href="https://plus.google.com/103386127817600208643"/>



<?php
/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */
 if (function_exists('avia_set_follow')) { echo avia_set_follow(); }


 /*
 * outputs a favicon if defined
 */
 if (function_exists('avia_favicon'))    { echo avia_favicon(avia_get_option('favicon')); }
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

	<!--//Livechatoo.com START-code

	<script type="text/javascript">
	(function() {
	 livechatooCmd = function() { livechatoo.embed.init({account : 'potichu<?php if ($webLocale == 'cs') echo "cz";?>)', lang : '<?php echo $webLocale; ?>', side : 'right'}) };
	 var l = document.createElement('script'); l.type = 'text/javascript'; l.async = !0;
	 l.src = 'http' + (document.location.protocol == 'https:' ? 's' : '') + '://app.livechatoo.com/js/web.min.js';
	 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(l, s);
	})();
	</script>

	Livechatoo.com END-code//-->



</head>




<body id="top" <?php body_class($style." ".$avia_config['font_stack']." ".$blank); avia_markup_helper(array('context' => 'body')); ?>>

<?php
 	$webLocale = get_option('web_locale', 'sk');

  if ($webLocale == 'sk') {
    echo '<a href="https://eshop.potichu.sk" target="_blank" class="eshop-link" style="display: none;">Otvoriť e-shop</a>';
  } else {
    echo '<a href="https://eshop.potichu.cz" target="_blank" class="eshop-link" style="display: none;">Otevřít e-shop</a>';
  }
 ?>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TVXDZZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TVXDZZ');</script>
<!-- End Google Tag Manager -->



<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "<?php echo $facebookSrc; ?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));


	</script>

	<script type='text/javascript' src='<?php echo home_url(); ?>/wp-content/themes/enfold/js/potichu-custom.js?ver=3'></script>


	<div id='wrap_all'>

	<?php
	if(!$blank) //blank templates dont display header nor footer
	{
		 //fetch the template file that holds the main menu, located in includes/helper-menu-main.php
         get_template_part( 'includes/helper', 'main-menu' );

	} ?>

	<div id='main' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>


	<?php do_action('ava_after_main_container'); ?>
