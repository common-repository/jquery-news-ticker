<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('Jntp_pluginversion');
 
// for site options in Multisite
delete_site_option('Jntp_pluginversion');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jquery_newsticker");