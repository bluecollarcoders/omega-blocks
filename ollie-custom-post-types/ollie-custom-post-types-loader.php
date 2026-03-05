<?php
/**
 * Service and testimonial plugin for WordPress.
 *
 * @package     PluginPackage
 * @author      Caleb Matteis
 * @copyright   2024 Sewnful Digital Studios.
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Custom Post type Plugin
 * Plugin URI:  https://example.com/plugin-name
 * Description: Services post type plugin for WordPress.
 * Version:     1.0.0
 * Author:      Caleb Matteis
 * Author URI:  https://example.com
 * Text Domain: plugin-slug
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

 declare(strict_types = 1);

 // Die if called directly.
 if ( ! defined( 'ABSPATH' ) ) {
     die;
}

require plugin_dir_path( __FILE__ ) . '/post-type/custom-post-types.php';

/**
 * Require custom meta data.
 */
require_once plugin_dir_path( __FILE__ ) . '/custom-meta/data.php';
