<?php
/**
 * Plugin Name: Custom Post Types.
 * Description: Custom post type for Services & testimonial.
 * Author: Caleb Matteis
 * Version: 1.0
 * Text Domain: ollie-child
 */

namespace OllieChild\CustomPostTypes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Singleton Trait.
 */
trait Singleton {
    private static $instance;

    public static function get_instance() {
        if( ! isset( self::$instance ) ){
            self::$instance = new self();
        }
        return  self::$instance;
    }
}

/**
 * Class Plugin
 */
final class Plugin {
    use Singleton;

    /**
     * Constructor.
     */
    private function __construct() {
		$this->_setup_hooks();
    }

	/**
     * Register action/filters hooks.
     *
     * @return void
     */
	private function _setup_hooks() {

    // Register taxonomies first
    add_action( 'init', [$this, 'register_taxonomies'], 9 );

    // Register post types after taxonomies
    add_action( 'init', [$this, 'register_post_types'], 10 );

    // Add the meta box for Service Types
    add_action( 'add_meta_boxes', [$this, 'add_service_type_metabox'], 20 );

    // Initialize CMB2 for Testimonials.
    add_action( 'cmb2_admin_init', [$this, 'register_testimonial_metabox'], 10 );

    // Remove metabox.
    add_action( 'do_meta_boxes', [$this, 'remove_sport_meta_box'] );

	}

	/**
     * Register custom post types.
     *
     * @return void
     */
	public function register_post_types() {
		$this->_register_services_post_type();
		$this->_register_testimonial_post_type();
	}

	/**
     * Register Services post type.
     *
     * @return void
     */
	private function _register_services_post_type(): void {

		$labels = [
            'name'                  => _x('Services', 'Post type general name', 'ollie-child'),
            'singular_name'         => _x('Service', 'Post type singular name', 'ollie-child'),
            'menu_name'             => _x('Services', 'Admin Menu text', 'ollie-child'),
            'name_admin_bar'        => _x('Service', 'Add New on Toolbar', 'ollie-child'),
            'add_new'               => __('Add New', 'ollie-child'),
            'add_new_item'          => __('Add New Service', 'ollie-child'),
            'new_item'              => __('New Service', 'ollie-child'),
            'edit_item'             => __('Edit Service', 'ollie-child'),
            'view_item'             => __('View Service', 'ollie-child'),
            'all_items'             => __('All Services', 'ollie-child'),
            'search_items'          => __('Search Services', 'ollie-child'),
            'parent_item_colon'     => __('Parent Services:', 'ollie-child'),
            'not_found'             => __('No services found.', 'ollie-child'),
            'not_found_in_trash'    => __('No services found in Trash.', 'ollie-child'),
            'featured_image'        => _x('Service Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'archives'              => _x('Service archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'ollie-child'),
            'insert_into_item'      => _x('Insert into service', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'ollie-child'),
            'uploaded_to_this_item' => _x('Uploaded to this service', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'ollie-child'),
            'filter_items_list'     => _x('Filter services list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'ollie-child'),
            'items_list_navigation' => _x('Services list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'ollie-child'),
            'items_list'            => _x('Services list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'ollie-child'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'service'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-building',
            'show_in_rest'       => true,
            'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields'],
            'taxonomies'         => ['service_type'],  // Add this line

        ];

        register_post_type( 'service', $args );

	}

    /**
     * Register Services post type.
     *
     * @return void
     */
    private function _register_testimonial_post_type() {

        $labels = [
            'name'                  => _x('Testimonials', 'Post type general name', 'ollie-child'),
            'singular_name'         => _x('Testimonial', 'Post type singular name', 'ollie-child'),
            'menu_name'             => _x('Testimonials', 'Admin Menu text', 'ollie-child'),
            'name_admin_bar'        => _x('Testimonial', 'Add New on Toolbar', 'ollie-child'),
            'add_new'               => __('Add New', 'ollie-child'),
            'add_new_item'          => __('Add New Testimonial', 'ollie-child'),
            'new_item'              => __('New Testimonial', 'ollie-child'),
            'edit_item'             => __('Edit Testimonial', 'ollie-child'),
            'view_item'             => __('View Testimonial', 'ollie-child'),
            'all_items'             => __('All Testimonials', 'ollie-child'),
            'search_items'          => __('Search Testimonials', 'ollie-child'),
            'parent_item_colon'     => __('Parent Testimonials:', 'ollie-child'),
            'not_found'             => __('No testimonials found.', 'ollie-child'),
            'not_found_in_trash'    => __('No testimonials found in Trash.', 'ollie-child'),
            'featured_image'        => _x('Testimonial Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'ollie-child'),
            'archives'              => _x('Testimonial archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'ollie-child'),
            'insert_into_item'      => _x('Insert into testimonial', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'ollie-child'),
            'uploaded_to_this_item' => _x('Uploaded to this testimonial', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'ollie-child'),
            'filter_items_list'     => _x('Filter testimonials list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'ollie-child'),
            'items_list_navigation' => _x('Testimonials list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'ollie-child'),
            'items_list'            => _x('Testimonials list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'ollie-child'),
        ];
        
        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => 'testimonial'],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-testimonial', // Update icon as necessary
            'show_in_rest'       => true,
            'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields'],
        ];
        
        register_post_type( 'testimonial', $args );
        
    }

    /**
     * Register custom taxonomies.
     *
     * @return void
     */
    public function register_taxonomies() {
        // Register Service Types taxonomy for Services
        $labels = [
            'name'              => _x('Service Types', 'taxonomy general name', 'ollie-child'),
            'singular_name'     => _x('Service Type', 'taxonomy singular name', 'ollie-child'),
            'search_items'      => __('Search Service Types', 'ollie-child'),
            'all_items'         => __('All Service Types', 'ollie-child'),
            'parent_item'       => __('Parent Service Type', 'ollie-child'),
            'parent_item_colon' => __('Parent Service Type:', 'ollie-child'),
            'edit_item'         => __('Edit Service Type', 'ollie-child'),
            'update_item'       => __('Update Service Type', 'ollie-child'),
            'add_new_item'      => __('Add New Service Type', 'ollie-child'),
            'new_item_name'     => __('New Service Type Name', 'ollie-child'),
            'menu_name'         => __('Service Types', 'ollie-child'),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'service-type'],
        ];

        register_taxonomy( 'service_type', ['service'], $args );

        // Register Sports taxonomy for Testimonials
        $labels = [
            'name'              => _x('Sports', 'taxonomy general name', 'ollie-child'),
            'singular_name'     => _x('Sport', 'taxonomy singular name', 'ollie-child'),
            'search_items'      => __('Search Sports', 'ollie-child'),
            'all_items'         => __('All Sports', 'ollie-child'),
            'parent_item'       => __('Parent Sport', 'ollie-child'),
            'parent_item_colon' => __('Parent Sport:', 'ollie-child'),
            'edit_item'         => __('Edit Sport', 'ollie-child'),
            'update_item'       => __('Update Sport', 'ollie-child'),
            'add_new_item'      => __('Add New Sport', 'ollie-child'),
            'new_item_name'     => __('New Sport Name', 'ollie-child'),
            'menu_name'         => __('Sports', 'ollie-child'),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'sport'],
        ];

        register_taxonomy( 'sport', ['testimonial'], $args );
    }

    /**
     * Add the Service Type meta box.
     */
    public function add_service_type_metabox() {
        add_meta_box(
            'service_type_metabox',         // Meta box ID
            __( 'Service Types' ),            // Meta box title
            [$this, 'display_service_type_metabox'], // Callback function
            'service',                      // Post type
            'side',                         // Context (side, normal, advanced)
            'default'                       // Priority
        );
    }
    
    /**
     * Display the Service Type meta box.
     */
    public function display_service_type_metabox( $post ) {

        // Use the 'post_categories_meta_box' function to display checkboxes for the taxonomy
        $taxonomy = 'service_type';
        $tax      = get_taxonomy( $taxonomy );
        $terms    = get_terms( $taxonomy, array('hide_empty' => false ) );
        
        ?>
        <div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
            <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
                <li class="tabs">
                    <a href="#<?php echo $taxonomy; ?>-all" tabindex="3"><?php echo $tax->labels->all_items; ?></a>
                </li>
            </ul>
            <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
                <input type="hidden" name="tax_input[<?php echo $taxonomy; ?>][]" value="0" />
                <ul id="<?php echo $taxonomy; ?>checklist" class="categorychecklist form-no-clear">
                    <?php 
                    foreach ($terms as $term) {
                        $id      = "taxonomy-{$taxonomy}-{$term->term_id}";
                        $checked = (has_term($term->slug, $taxonomy, $post)) ? ' checked="checked"' : '';
                        ?>
                        <li id="<?php echo $id; ?>" class="popular-category">
                            <label class="selectit">
                                <input type="checkbox" id="in-<?php echo $id; ?>" name="tax_input[<?php echo $taxonomy; ?>][]" value="<?php echo $term->term_id; ?>"<?php echo $checked; ?> />
                                <?php echo $term->name; ?>
                            </label>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Register meta box for Testimonials using CMB2.
     */
    public function register_testimonial_metabox() {

    // Create the CMB2 box for the 'testimonial' post type.
    $cmb = new_cmb2_box( array(
        'id'            => 'testimonial_sports_metabox',
        'title'         => __( 'Sports Categories', 'ollie-child' ),
        'object_types'  => array( 'testimonial' ), // Post type
        'context'       => 'side',                // Metabox location: normal, side, etc.
        'priority'      => 'default',             // Priority
    ));

    // Add a taxonomy select field for the 'sport' taxonomy.
    $cmb->add_field( array(
        'name'     => __( 'All Sports Type', 'ollie-child' ),
        'desc'     => __( 'Select the sport related to this testimonial.', 'ollie-child' ),
        'id'       => 'ollie_testimonial_sport',
        'taxonomy' => 'sport',                    // Taxonomy key
        'type'     => 'taxonomy_radio',          // Type of field
        'remove_default' => true,                 // Remove default metabox
    ));

    }

    /**
     * Remove meta box for Sport taxomony.
     */
    public function remove_sport_meta_box() {
        remove_meta_box( 'tagsdiv-sport', 'testimonial', 'side' ); 
    }

}
Plugin::get_instance();
