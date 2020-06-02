<?php

include 'functions-pipedrive.php';

// remove emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// disable rest API discovery
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// remove wp-embed.js
function my_deregister_scripts(){
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

function potichu_enqueue_scripts() {
	global $singleMaterialPage;

	if ($singleMaterialPage) {
		wp_register_script( 'chart', get_stylesheet_directory_uri().'/assets/js/chart.js', array('jquery'), 2, true );
		wp_enqueue_script( 'chart' );
	}

	// jQuery
	wp_dequeue_script('jquery');
	wp_deregister_script('jquery');

    wp_register_script( 'jquery', get_stylesheet_directory_uri() . '/assets/js/jquery-3.4.1.min.js', array(), '', true );
	wp_register_script( 'jquery-migrate-potichu', get_stylesheet_directory_uri() . '/assets/js/jquery-migrate-3.0.1.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'jquery-migrate-potichu' );

	// Avia module contact
    wp_dequeue_script('avia-module-contact');
	wp_deregister_script('avia-module-contact');

	// Avia compact
	//wp_dequeue_script('avia-compat');
	//wp_deregister_script('avia-compat');
	//wp_enqueue_script( 'avia-compat', $template_url.'/js/avia-compat.js' , array(), $vn, false );

	$child_theme_url 	= get_stylesheet_directory_uri();

	wp_enqueue_script( 'potichu-avia-module-contact', $child_theme_url.'/assets/js/contact.js', array('avia-shortcodes'), false, true);
}
add_action( 'wp_enqueue_scripts', 'potichu_enqueue_scripts', 200 );

function potichu_load_styles() {
	$theme = wp_get_theme();
	wp_register_style( 'custom-style', get_stylesheet_directory_uri() . '/custom.css', array(), $theme->get( 'Version' ));
	wp_enqueue_style( 'custom-style' );
}
add_action( 'wp_enqueue_scripts', 'potichu_load_styles', 1000000 );

function potichu_web_settings_register( $wp_customize ) {

	$wp_customize->add_setting( 'google_tag_manager_head' , array(
		'type'		=> 'option',
		'default'	=> '',
		'transport'	=> 'refresh',
	));

	$wp_customize->add_setting( 'google_tag_manager_body' , array(
		'type'		=> 'option',
		'default'	=> '',
		'transport'	=> 'refresh',
	));

	$wp_customize->add_setting( 'use_facebook_chatbot' , array(
		'type'		=> 'option',
		'default'	=> false,
		'transport'	=> 'refresh',
	));

	// Sections
	$wp_customize->add_section( 'web_settings_section' , array(
		'title'      => 'Potichu',
		'priority'   => 1000,
	) );

	$wp_customize->add_control(
		'use_facebook_chatbot_control',
		array(
			'label'    => 'Allow Facebook customer chat',
			'section'  => 'web_settings_section',
			'settings' => 'use_facebook_chatbot',
			'type'     => 'checkbox'
		)
	);

	$wp_customize->add_control(
		'google_tag_manager_head_control',
		array(
			'label'    => 'GTM code - head',
			'section'  => 'web_settings_section',
			'settings' => 'google_tag_manager_head',
			'type'     => 'textarea'
		)
	);

	$wp_customize->add_control(
		'google_tag_manager_body_control',
		array(
			'label'    => 'GTM code - body',
			'section'  => 'web_settings_section',
			'settings' => 'google_tag_manager_body',
			'type'     => 'textarea'
		)
	);
}
add_action( 'customize_register', 'potichu_web_settings_register' );
?>