<?php

/*
Plugin Name: Api Foot
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: paolo
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

/**
 * Lod class
 */

require( __DIR__ . '/Model/apiFootModel.php' );
require( __DIR__ . '/Model/dataModel.php' );
require( __DIR__ . '/inc/apiFoot_admin.php' );
require( __DIR__ . '/inc/apiFoot_client.php' );


/**
 * Init class client and admin
 **/
function apiFoot_init() {
    new apiFoot_client();

    if( is_admin() ){
        new apiFoot_admin();
    }
}
add_action( 'plugins_loaded', 'apiFoot_init', 11 );