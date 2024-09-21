<?php
/**
 * Plugin Name:       Omega Blocks
 * Description:       Package of useful custom blocks.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Sewnful Digital Studios
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       curvy
 *
 * @package CreateBlock
 */

namespace OmegaBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Omega_Blocks {

	/**
    * Constructor to initialize hooks.
    */
	public function __construct() {
		$this->setup_hooks();
	}
	
	/**
    * Set up WordPress hooks.
    */
	public function setup_hooks() {
		add_action( 'init', [ $this, 'register_blocks'] );
		add_filter( 'block_categories_all', [ $this, 'create_custom_block_category' ] );
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function register_blocks() {
		register_block_type( __DIR__ . '/build/blocks/curvy' );
		register_block_type( __DIR__ . '/build/blocks/clickyGroup' );
		register_block_type( __DIR__ . '/build/blocks/clickyButton' );
	}

	public function create_custom_block_category( $categories ) {

		array_unshift( $categories, [
			'slug'  => 'omega blocks',
			'title' => __( 'Omega Blocks', 'curvy' ),
		]);

		return $categories;

	}
}

	// Initialize the class
	function init_plugin() {
		new Omega_Blocks();
	}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\init_plugin' );
