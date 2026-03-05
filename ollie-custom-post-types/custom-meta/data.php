<?php
/**
 * Register post meta data for custom post types
 *
 * This registers post meta data for custom post types.
 *
 * @link URL
 *
 * @package WordPress
 * @subpackage Component
 * @since x.x.x (when the file was introduced)
 */
declare(strict_types=1);

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Custom_Post_Meta {

	/**
	 * Constructor to hook into WordPress
	 */
	public function __construct() {
		$this->_setup_hooks();
	}

	/**
     * Register action/filters hooks.
     *
     * @return void
     */
	public function _setup_hooks() {
		add_action( 'init', [ $this, 'register_all_post_meta' ] );
	}
	
	/**
	 * Register post meta for all custom post types.
	 *
	 * @return void
	 */
	public function register_all_post_meta(): void {

		// Register Service post meta
		$this->register_post_meta(
			'service',
			[
				[
					'meta_key' => 'service_title',
					'label'    => __( 'Service Title', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				],
				[
					'meta_key' => 'service_description',
					'label'    => __( 'Service Description', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				],
				[
					'meta_key' => 'service_headline_description',
					'label'    => __( 'Service Description', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				],
				[
					'meta_key' => 'service_sub_title',
					'label'    => __( 'Service Description', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				],
				[
					'meta_key' => 'service_image_url',
					'label'    => __( 'Service Image URL', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'esc_url_raw',
				],
				[
					'meta_key' => 'service_image_alt',
					'label'    => __( 'Service Image Alt Text', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				]
			]
		);

		// Register Testimonial post meta
		$this->register_post_meta(
			'testimonial',
			[
				[
					'meta_key' => 'testimonial_author',
					'label'    => __( 'Testimonial Author', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				],
				[
					'meta_key' => 'testimonial_content',
					'label'    => __( 'Testimonial Content', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				],
				[
					'meta_key' => 'testimonial_title',
					'label'    => __( 'Testimonial Title', 'your-text-domain' ),
					'type'     => 'string',
					'sanitize' => 'wp_strip_all_tags',
				]
			]
		);
	}

	/**
	 * Register custom post meta for a post type.
	 *
	 * @param string $post_type Post type to register meta for.
	 * @param array  $meta_fields Array of meta field configurations.
	 *
	 * @return void
	 */
	protected function register_post_meta( string $post_type, array $meta_fields ): void {
		foreach ( $meta_fields as $field ) {
			register_post_meta(
				$post_type,
				$field['meta_key'],
				[
					'object_subtype'    => $post_type,
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $field['type'],
					'sanitize_callback' => $field['sanitize'],
				]
			);
		}
	}
}

// Initialize the class to register post meta for both Service and Testimonial post types.
new Custom_Post_Meta();
