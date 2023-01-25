<?php 
/**
 * Plugin Name: Agenda laica
 * Plugin URI: https://www.google.com/
 * Description: Este plugin funciona como uma agenda virtual
 * Version: 0.2
 * Author: João Costa 
 * Author URI: https://github.com/Repto1
 * 
 * 
 * 
 * 
 * 
 **/

if ( ! defined('ABSPATH')) {
    die( 'Invalid request.');
}

define ('PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(PLUGIN_DIR . 'admin.php'); 

// create the database table

register_activation_hook( __FILE__, 'jal_install' );
global $jal_db_version;
$jal_db_version = '1.0';
function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix.'agenda_plugin';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		email tinytext NOT NULL,
		phone tinytext NOT NULL,
		function tinytext NOT NULL,
		bond_type tinytext NOT NULL,
		department tinytext NOT NULL,
		status tinytext NOT NULL,
		coordinator boolean NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}




?> 
