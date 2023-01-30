<?php 
/**
 * Plugin Name: Agenda projeto
 * Plugin URI: https://www.google.com/
 * Description: Projeto de agenda
 * Version: 0.9
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
require_once(PLUGIN_DIR . 'register.php'); 


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
		fullname varchar(45) NOT NULL,
		email varchar(45) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
	

	CREATE TABLE $table_uorg (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		uorg_name varchar(45) NOT NULL,
		email varchar(45) NOT NULL,
		uorg_parent_id mediumint(9),
		responsible_id mediumint(9) NOT NULL,
		substitute_id mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
		ALTER TABLE $table_uorg ADD	CONSTRAINT fk_uorg_parent_id FOREIGN KEY (uorg_parent_id) REFERENCES $table_uorg (id);
		ALTER TABLE $table_uorg ADD	CONSTRAINT fk_responsible_id FOREIGN KEY (responsible_id) REFERENCES $table_collaborator (id);
		ALTER TABLE $table_uorg ADD	CONSTRAINT fk_substitute_id FOREIGN KEY (substitute_id) REFERENCES $table_collaborator (id);
	

	CREATE TABLE $table_room (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		room_number varchar(20) NOT NULL,
		predio varchar(20) NOT NULL,
		andar varchar(20) NOT NULL,
		PRIMARY KEY  (id)	
		) $charset_collate;


	CREATE TABLE $table_uorg_room (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		uorg_id mediumint(9) NOT NULL,
		room_id mediumint(9) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
		ALTER TABLE $table_uorg_room ADD CONSTRAINT fK_room_id FOREIGN KEY (room_id) REFERENCES $table_room (id);
		ALTER TABLE $table_uorg_room ADD CONSTRAINT fk_uorg_id FOREIGN KEY (uorg_id) REFERENCES $table_uorg (id);
	

	CREATE TABLE $table_vinculo (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		collaborator_id mediumint(9) NOT NUll,
		uorg_room_id mediumint(9) NOT NUll,
		phone varchar(20),
		papel varchar(45) NOT NULL,
		horario varchar(20),
		vinculo_status varchar(20) NOT NULL,
		vinculo_type varchar(20) NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;
		ALTER TABLE $table_vinculo ADD CONSTRAINT fk_collaborator_id FOREIGN KEY (collaborator_id) REFERENCES $table_collaborator (id);
		ALTER TABLE $table_vinculo ADD CONSTRAINT fK_uorg_room_id FOREIGN KEY (uorg_room_id) REFERENCES $table_uorg_room (id);
	";


	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}




?> 
