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

	$table_name = $wpdb->prefix.'list_';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name . 'collaborators' (
		ID mediumint(9) NOT NULL AUTO_INCREMENT,
		CollaboratorName tinytext NOT NULL,
		Email tinytext NOT NULL,
		PRIMARY KEY  (ID)
	) $charset_collate;";

	$sql = "CREATE TABLE $table_name . 'uorg' (
		ID mediumint(9) NOT NULL AUTO_INCREMENT,
		UorgName tinytext NOT NULL,
		Email tinytext NOT NULL,
		UorgParent mediumint(9) NOT NULL,
		Responsible mediumint(9) NOT NULL,
		Substitute mediumint(9) NOT NULL,
		PRIMARY KEY  (ID)
	) $charset_collate;";

	$sql = "CREATE TABLE $table_name . 'rooms' (
		ID mediumint(9) NOT NULL AUTO_INCREMENT,
		RoomNumber tinytext NOT NULL,
		Phone tinytext NOT NULL,
		PRIMARY KEY  (ID)
	) $charset_collate;";

	$sql = "CREATE TABLE $table_name . 'vinculo' (
		ID mediumint(9) NOT NULL AUTO_INCREMENT,
		CollaboratorID mediumint(9) NOT NUll,
		UorgID mediumint(9) NOT NUll,
		RoomID mediumint(9) NOT NUll,
		Paper tinytext NOT NULL,
		VinculoStatus tinytext NOT NULL,
		PRIMARY KEY  (ID)
	) $charset_collate;";


	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}




?> 
