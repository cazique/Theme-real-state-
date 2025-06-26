<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wplistingthemes.com/
 * @since      1.0.0
 *
 * @package    Luxus_Core
 * @subpackage Luxus_Core/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Luxus_Core
 * @subpackage Luxus_Core/includes
 * @author     https://wplistingthemes.com/ <info@wplistingthemes.com>
 */
class Luxus_Core_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        // Custom Rols
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/users/custom-roles.php';

        // Generate Messages Table
        global $wpdb;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
        $charset_collate = $wpdb->get_charset_collate();

        // Create Contact Messages Table
        $contact_table_name = $wpdb->prefix . 'luxus_messages';
        $contact_sql_query  = "CREATE TABLE $contact_table_name (
           id int(11) NOT NULL AUTO_INCREMENT,
           created_by varchar(150) NOT NULL,
           sender_id varchar(150) NOT NULL,
           receiver_id varchar(150) NOT NULL,
           sender_phone varchar(150) NOT NULL,
           message longtext DEFAULT '' NOT NULL,
           del_receiver int(11) NOT NULL DEFAULT '0',
           del_sender int(11) NOT NULL DEFAULT '0',
           status varchar(150) DEFAULT 'unread' NOT NULL,
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
        ) $charset_collate;";
        dbDelta( $contact_sql_query );

        // Create Schedule Tour Table
        $schedule_tour_table_name = $wpdb->prefix . 'luxus_schedule_tour';
        $schedule_tour_sql_query  = "CREATE TABLE $schedule_tour_table_name (
           id int(11) NOT NULL AUTO_INCREMENT,
           created_by varchar(150) NOT NULL,
           sender_id varchar(150) NOT NULL,
           receiver_id varchar(150) NOT NULL,
           sender_phone varchar(150) NOT NULL,
           property_id varchar(150) NOT NULL,
           tour_date varchar(150) NOT NULL,
           tour_time varchar(150) NOT NULL,
           message longtext DEFAULT '' NOT NULL,
           del_receiver int(11) NOT NULL DEFAULT '0',
           del_sender int(11) NOT NULL DEFAULT '0',
           status varchar(150) DEFAULT 'unread' NOT NULL,
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
        ) $charset_collate;";
        dbDelta( $schedule_tour_sql_query );

        // Save Searches Table
        $save_searches_table_name = $wpdb->prefix . 'save_searches';
        $schedule_tour_sql_query  = "CREATE TABLE $save_searches_table_name (
           id int(11) NOT NULL AUTO_INCREMENT,
           saved_by varchar(150) NOT NULL,
           ss_data longtext DEFAULT '' NOT NULL,
           ss_delete int(11) NOT NULL DEFAULT '0',
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
        ) $charset_collate;";
        dbDelta( $schedule_tour_sql_query );
        
	}

}
