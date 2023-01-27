<?php 
/**
 * Plugin Name: Agenda laica teste
 * Plugin URI: https://www.google.com/
 * Description: tteste teset
 * Version: 0.1
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

	$table_collaborator = $wpdb->prefix.'collaborator';
	$table_uorg = $wpdb->prefix.'uorg';
	$table_room = $wpdb->prefix.'room';
	$table_uorg_room = $wpdb->prefix.'uorg_room';
	$table_vinculo = $wpdb->prefix.'vinculo';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_collaborator (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		fullname tinytext NOT NULL,
		email tinytext NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
	";

	$sql = "CREATE TABLE $table_uorg (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		uorg_name tinytext NOT NULL,
		email tinytext NOT NULL,
		uorg_parent_id mediumint(9) NOT NULL,
		responsible_id mediumint(9) NOT NULL,
		substitute_id mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
		ALTER TABLE $table_uorg ADD	CONSTRAINT fk_uorg_parent_id FOREIGN KEY (uorg_parent_id) REFERENCES $table_uorg (id),
		ALTER TABLE $table_uorg ADD	CONSTRAINT fk_responsible_id FOREIGN KEY (responsible_id) REFERENCES $table_collaborator (id),
		ALTER TABLE $table_uorg ADD	CONSTRAINT fk_substitute_id FOREIGN KEY (substitute_id) REFERENCES $table_collaborator (id),
	";

	$sql = "CREATE TABLE $table_room (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		room_number tinytext NOT NULL,
		phone tinytext,
		predio tinytext NOT NULL,
		andar tinytext NOT NULL,
		PRIMARY KEY  (id)	
		) $charset_collate;
	";

	$sql = "CREATE TABLE $table_uorg_room (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		uorg_id mediumint(9) NOT NULL,
		room_id mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
		

		) $charset_collate;
		ALTER TABLE $table_uorg_room ADD CONSTRAINT fK_room_id FOREIGN KEY (room_id) REFERENCES $table_room (id),
		ALTER TABLE $table_uorg_room ADD CONSTRAINT fk_uorg_id FOREIGN KEY (uorg_id) REFERENCES $table_uorg (id),
	";


	$sql = "CREATE TABLE $table_vinculo (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		collaborator_id mediumint(9) NOT NUll,
		uorg_room_id mediumint(9) NOT NUll,
		fullname tinytext NOT NULL,
		papel tinytext NOT NULL,
		vinculo_status tinytext NOT NULL,
		vinculo_type tinytext NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
		ALTER TABLE $table_vinculo ADD CONSTRAINT fk_uorg_room_id FOREIGN KEY (uorg_room_id) REFERENCES $table_uorg_room (id),
		ALTER TABLE $table_vinculo ADD CONSTRAINT fk_collaborator_id FOREIGN KEY (collaborator_id) REFERENCES $table_collaborator (id),
		ALTER TABLE $table_vinculo ADD CONSTRAINT fk_fullname FOREIGN KEY (fullname) REFERENCES $table_collaborator (fullname),
	";


	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}




?> 
