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

	$sql = "CREATE TABLE '{$table_name}collaborators' (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		collaborator_name tinytext NOT NULL,
		email tinytext NOT NULL,
		PRIMARY KEY  (id),
		CONSTRAINT fk_responsible_id FOREIGN KEY (responsible_id) REFERENCES '{$table_name}collaborators' (id)
		CONSTRAINT fk_substitute_id FOREIGN KEY (substitute_id) REFERENCES '{$table_name}collaborators' (id)
	) $charset_collate;";

	$sql = "CREATE TABLE '{$table_name}uorg' (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		uorg_name tinytext NOT NULL,
		email tinytext NOT NULL,
		uorg_parent mediumint(9) NOT NULL,
		responsible mediumint(9) NOT NULL,
		substitute mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	$sql = "CREATE TABLE '{$table_name}rooms' (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		room_number tinytext NOT NULL,
		phone tinytext NOT NULL,
		PRIMARY KEY  (id),
		CONSTRAINT sala_id
	) $charset_collate;";

	$sql = "CREATE TABLE '{$table_name}uorgrooms' (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		RoomNumber tinytext NOT NULL,
		Phone tinytext NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";


	$sql = "CREATE TABLE '{$table_name}vinculo' (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		collaborator_id mediumint(9) NOT NUll,
		uorg_id mediumint(9) NOT NUll,
		room_id mediumint(9) NOT NUll,
		paper tinytext NOT NULL,
		vinculo_status tinytext NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";


	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}




?> 
