<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/amitrahav
 * @since      1.0.0
 *
 * @package    feed_by_user
 * @subpackage feed_by_user/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    feed_by_user
 * @subpackage feed_by_user/includes
 * @author     Amit Rahav <amit.r.89@gmail.com>
 */
class Feed_By_User_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if (!function_exists('acf_add_options_page')) {
            throw new WP_Error(400,"Can't install plugin without ACF activated");
            wp_die();        
        }
        
	}

}
