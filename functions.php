<?php

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

define( 'THEME_ID', 'Sports_Time_Machine' );
define( 'THEME_VERSION', '1.0.1' );

add_action( 'init', 'sportstm_register_styles_scripts' );
function sportstm_register_styles_scripts() {

    // Parent Theme
    wp_register_style(
        THEME_ID . '-parent',
        get_template_directory_uri() . '/style.css',
        null,
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );

    // Current (Child) Theme
    wp_register_style(
        THEME_ID,
        get_stylesheet_uri(),
        array( THEME_ID . '-parent' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );
    
    // All the custom JavaScript
    wp_register_script(
        THEME_ID,
        get_stylesheet_directory_uri() . '/script.js',
        array( 'jquery', THEME_ID . '-fancybox', THEME_ID . '-jplayer' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
        true
    );
    
    wp_localize_script( THEME_ID, 'wpData', array( 'themeDirectory' => get_stylesheet_directory_uri() ) );
    
    // Google JSAPI
    wp_register_script(
        THEME_ID . '-google-jsapi',
        '//www.google.com/jsapi',
        array(),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
        false
    );

    // jQuery Fancybox CSS
    wp_register_style(
        THEME_ID . '-fancybox',
        get_stylesheet_directory_uri() . '/js/jquery.fancybox/jquery.fancybox.css',
        null,
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );

    // jQuery Fancybox JS
    wp_register_script(
        THEME_ID . '-fancybox',
        get_stylesheet_directory_uri() . '/js/jquery.fancybox/jquery.fancybox.js',
        array( 'jquery' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
        true
    );
    
    // jQuery jPlayer base CSS
    wp_register_style(
        THEME_ID . '-jplayer',
        get_stylesheet_directory_uri() . '/js/jplayer/jplayer.css',
        null,
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );
    
    // jQuery jPlayer Blue Monday CSS
    wp_register_style(
        THEME_ID . '-jplayer-blue-monday',
        get_stylesheet_directory_uri() . '/js/jplayer/blue_monday/jplayer.blue.monday.css',
        array( THEME_ID . '-jplayer' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
    );
    
    // jQuery jPlayer JS
    wp_register_script(
        THEME_ID . '-jplayer',
        get_stylesheet_directory_uri() . '/js/jplayer/jquery.jplayer.min.js',
        array( 'jquery' ),
        defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
        true
    );

}

add_action( 'wp_enqueue_scripts', 'sportstm_enqueue_styles_scripts' );
function sportstm_enqueue_styles_scripts() {

    wp_enqueue_style( THEME_ID . '-parent' );
    wp_enqueue_style( THEME_ID );

    wp_enqueue_style( THEME_ID . '-fancybox' );
    wp_enqueue_script( THEME_ID . '-fancybox' );
    
    wp_enqueue_style( THEME_ID . '-jplayer' );
    wp_enqueue_style( THEME_ID . '-jplayer-blue-monday' );
    wp_enqueue_script( THEME_ID . '-jplayer' );
    
    wp_enqueue_script( THEME_ID . '-google-jsapi' );
    
    wp_enqueue_script( THEME_ID );

}

add_action( 'wp_head', 'sportstm_radio_show_rss_feeds' );
function sportstm_radio_show_rss_feeds() { ?>

<link rel="alternate" type="application/rss+xml" title="Stark Posts" href="/feed/?post_type=stark_radio" />
<link rel="alternate" type="application/rss+xml" title="Summit Posts" href="/feed/?post_type=summit_radio" />

<?php
}

add_action( 'wp_footer', 'sportstm_google_analytics' );
function sportstm_google_analytics() { ?>

<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-30047922-3']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>

<?php   
}

add_action( 'after_setup_theme', 'sportstm_theme_support' );
function sportstm_theme_support() {

    add_theme_support( 'menus' );

    // Allow shortcodes in text widget
    add_filter( 'widget_text', 'do_shortcode' );

}

add_action( 'after_setup_theme', 'sportstm_nav_menus' );
function sportstm_nav_menus() {

    register_nav_menus( array(
        'stark' => 'Stark Menu',
        'summit' => 'Summit Menu'
    ) );

}

add_filter( 'excerpt_length', 'sportstm_custom_excerpt_length' );
function sportstm_custom_excerpt_length( $length ) {
    return 20;
}

add_filter( 'excerpt_more', 'sportstm_new_excerpt_more' );
function sportstm_new_excerpt_more( $more ) {
    
    global $query_string;
    
    if ( array_key_exists( 'pagename', wp_parse_args( $query_string ) ) ) {
        
        global $post;
        return '<div class="bl_read_more"><a href="' . get_permalink( $post->ID ) . '">Read the rest of this article</a></div>';
        
    }
    
}