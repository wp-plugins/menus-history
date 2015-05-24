<?php
/**
 * Plugin Name: Menus History
 * Description: Provides history of changes to Wordpress menus
 * Version: 1.0.1
 * Author: BinaryStash
 * Author URI:  http://www.binarystash.net
 * License: GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */
 
/*
 * Define constants 
 */
 
if ( !defined('MENUS_HISTORY_URL') ) {
    define('MENUS_HISTORY_URL', plugin_dir_url( __FILE__ ));
}

if(!defined('MENUS_HISTORY_DIR')){
	define('MENUS_HISTORY_DIR', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR );
}

/*
 * Register post types
 */

function menus_history_register_post_types() {
	$args = array(
	  'label'  => 'Menus Revisions'
	);
	register_post_type( 'menu_revision', $args );
}

add_action( 'init', 'menus_history_register_post_types' );

/*
 * Include classes
 */

include MENUS_HISTORY_DIR . 'classes/class-menus-history-controller.php';
include MENUS_HISTORY_DIR . 'classes/class-menus-history-nav-walker.php';

function Menus_History_Instantiate() {
	new Menus_History();
}
add_action( 'plugins_loaded', 'Menus_History_Instantiate', 15 );