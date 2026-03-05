<?php

// Default attributes & post.
$button_back_ground_color = isset( $attributes['buttonBackgroundColor'] ) ? $attributes['buttonBackgroundColor'] : '#0073aa';
$button_text_color        = isset( $attributes['buttonTextColor'] ) ? $attributes['buttonTextColor'] : '#ffffff';
$post_type                = isset( $attributes['postType'] ) ? $attributes['postType'] : '';
$select_post_id           = intval( $attributes['selectPostId'] ?? 0 );
$post                     = get_post( $select_post_id );
$wrapper_attributes       = get_block_wrapper_attributes();

// Bail early if no post is selected.
if ( ! $post ) {
    echo '<p>No post was selected</p>';
    return;
}

// Get fields based on post type (service or testimonial).
if ( $post_type === 'service' ) {
    $service_title       = get_post_meta( $select_post_id, 'service_title', true ) ?: $post->post_title;
    $service_description = get_post_meta( $select_post_id, 'service_description', true ) ?: wp_trim_words( $post->post_content, 30 );
} elseif ( $post_type === 'testimonial' ) {
    $testimonial_author  = get_post_meta( $select_post_id, 'testimonial_author', true ) ?: $post->post_title;
    $testimonial_content = get_post_meta( $select_post_id, 'testimonial_content', true ) ?: wp_trim_words( $post->post_content, 30 );
} else {
    $post_title   = $post->post_title ?: 'Default Title';
    $post_content = wp_trim_words( $post->post_content, 30 );
}

$image_url = get_the_post_thumbnail_url( $select_post_id, 'medium' );
$post_link = get_permalink( $select_post_id );

// Block wrapper attributes (for custom classes and styling).
?>
<div <?= $wrapper_attributes ?>>

    <div class="custom-card">
        <?php if ( $image_url ) : ?>
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( 
            $post_type === 'testimonial' 
                ? $testimonial_author 
                : ( $post_type === 'service' 
                    ? $service_title 
                    : $post->post_title ) 
            ); ?>" />
        <?php endif; ?>

        <?php if ( $post_type === 'testimonial' ) : ?>
            <!-- Testimonial-specific markup -->
            <h2><?= esc_html( $testimonial_author ); ?></h2>
            <p><?= esc_html( $testimonial_content ); ?></p>

        <?php elseif ( $post_type === 'service' ) : ?>
            <!-- Service-specific markup -->
            <h2><?= esc_html( $service_title ); ?></h2>
            <p><?= esc_html( $service_description ); ?></p>

        <?php else : ?>
            <!-- Fallback for regular posts or other post types -->
            <h2><?= esc_html( $post_title ); ?></h2>
            <p><?= esc_html( $post_content ); ?></p>

        <?php endif; ?>

        <a href="<?= esc_url( $post_link ); ?>" class="read-more-btn" style="background-color: <?= esc_attr( $button_back_ground_color ); ?>; color: <?= esc_attr( $button_text_color ); ?>;">
            <?php esc_html_e( 'Read More', 'service-block' ); ?>
        </a>
    </div>

</div>
