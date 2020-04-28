<?php

// Css & Js
function ot_scripts_styles() {
	$in_footer = true;

	// Loads styles
	wp_enqueue_style( 'base-style', get_stylesheet_uri(), array() );
	wp_enqueue_style( 'google-fonts-sans', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap', array() );
	wp_enqueue_style( 'google-fotns-cardo', 'https://fonts.googleapis.com/css?family=Cardo:400,700&display=swap', array() );
	wp_enqueue_style( 'styles-css', get_template_directory_uri() . '/assets/css/styles.css', array(), '', false );

	// Loads scripts
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'uikit-js', get_template_directory_uri() . '/assets/js/uikit.min.js', array(), '', false );
	wp_enqueue_script( 'matchheight-js', get_template_directory_uri() . '/assets/js/jquery.matchHeight-min', array( 'jquery' ), '', false );
	wp_enqueue_script( 'typed-js', get_template_directory_uri() . '/assets/js/typed.min.js', array(), '', false );
	wp_enqueue_script( 'countup-js', get_template_directory_uri() . '/assets/js/jquery.countup.min.js', array(), '', false );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'scripts-js', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '', false ;
}
add_action( 'wp_enqueue_scripts', 'ot_scripts_styles' );
