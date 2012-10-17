<?php
/*
Plugin Name: AFR Lesson
Plugin URI: http://codex.wordpress.org
De<?php echo AFR_LS_PLUGIN_DIR ?>/jsion: AFR Module of Lesson.
Version: 1.0
Author: Dani Gojay
Author URI: http://conversion-hub.com
License: GPL2
*/

wp_debug_mode(true);

global $wp_version;
define( 'AFR_LS_REQUIRED_WP_VERSION', '3.0' );

$exit_msg = 'AFR Ingredient for WordPress requires WordPress '. AFR_LS_REQUIRED_WP_VERSION .' or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
if ( version_compare( $wp_version, AFR_LS_REQUIRED_WP_VERSION, "<" ) ) {
    exit($exit_msg);
}

/**
 *
 * Global Define
 *
 */
if ( ! defined( 'AFR_LS_PLUGIN_BASENAME' ) )
    define( 'AFR_LS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'AFR_LS_PLUGIN_NAME' ) )
    define( 'AFR_LS_PLUGIN_NAME', trim( dirname( AFR_LS_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'AFR_LS_PLUGIN_DIR' ) )
    define( 'AFR_LS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . AFR_LS_PLUGIN_NAME );

if ( ! defined( 'AFR_LS_PLUGIN_URL' ) )
    define( 'AFR_LS_PLUGIN_URL', WP_PLUGIN_URL . '/' . AFR_LS_PLUGIN_NAME );

if ( ! defined( 'AFR_LS_PLUGIN_INC_DIR' ) )
    define( 'AFR_LS_PLUGIN_INC_DIR', AFR_LS_PLUGIN_DIR . '/includes' );

if ( ! defined( 'AFR_LS_PLUGIN_TPL_DIR' ) )
    define( 'AFR_LS_PLUGIN_TPL_DIR', AFR_LS_PLUGIN_DIR . '/templates' );
    

function afr_ls_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'afr_ls_excerpt_length', 999 );

function afr_ls_load_terms( $post_id, $taxonomy )
{
    global $wpdb;
    
    $query = $wpdb->prepare("
	    SELECT DISTINCT term.name
	    FROM {$wpdb->terms} term
	    INNER JOIN
		{$wpdb->term_taxonomy} tax
		ON
		term.term_id = tax.term_id
	    INNER JOIN
		{$wpdb->term_relationships} relationship
		ON
		relationship.term_taxonomy_id = tax.term_taxonomy_id
	    INNER JOIN
		{$wpdb->posts} p
		ON
		p.ID = relationship.object_id
	    WHERE
		p.ID = '%d' AND
		tax.taxonomy = '%s'", $post_id, $taxonomy );
	    
    $result =  $wpdb->get_results( $query, OBJECT );
    return $result;                 
}

function afr_ls_school_time( $lesson_time )
{
    $time = unserialize( $lesson_time );
    $st = $time['start'];
    $en = $time['end'];
    
    $start_time = $st['hour'] . '.' . $st['minute'] . $st['time'];
    $end_time   = $en['hour'] . '.' . $en['minute'] . $en['time'];
    $school_timing = $start_time . ' - ' . $end_time;
    
    return $school_timing;
}

/**
 *
 * AFR Lesson Class
 * 
 */    
include '/includes/AFRLesson.php';

if( class_exists('AFRLesson') )
{
    $lesson = new AFRLesson();
    /**
     * register_activation_hook
     * @param file
     * @param callback
     */
    register_activation_hook( __FILE__, array( &$lesson, 'install' ) );
    register_uninstall_hook( __FILE__, array( &$lesson, 'uninstall' ) );
}
?>
