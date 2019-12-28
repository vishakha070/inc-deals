<?php
/**
 * The plugin main file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/vishakha070/inc-deals
 * @since             1.0.0
 * @package           Inc_Deals
 *
 * @wordpress-plugin
 * Plugin Name:       Inc Deals
 * Plugin URI:        https://github.com/vishakha070/inc-deals
 * Description:       This plugin creates a CPT that lists all deals and creates shortcode for display all deals ( ['all-deals'] ) and single deal ([deal-card post_id=""])
 * Version:           1.0.0
 * Author:            Vishakha Gupta
 * Author URI:        https://profiles.wordpress.org/vishakha07/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       inc-deals
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
if ( ! defined( 'INC_DEALS_VERSION' ) ) {
	define( 'INC_DEALS_VERSION', '1.0.0' );
}

if ( ! defined( 'INC_PLUGIN_FILE' ) ) {
	define( 'INC_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'INC_PLUGIN_PATH' ) ) {
	define( 'INC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'INC_PLUGIN_URL' ) ) {
	define( 'INC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-inc-deals-activator.php
 */
function activate_inc_deals() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-inc-deals-activator.php';
	Inc_Deals_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-inc-deals-deactivator.php
 */
function deactivate_inc_deals() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-inc-deals-deactivator.php';
	Inc_Deals_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_inc_deals' );
register_deactivation_hook( __FILE__, 'deactivate_inc_deals' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-inc-deals.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_inc_deals() {

	$plugin = new Inc_Deals();
	$plugin->run();

}
run_inc_deals();