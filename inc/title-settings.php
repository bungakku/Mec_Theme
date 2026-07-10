<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Per-page Title Settings: hide title, and/or set its alignment.
 *
 * Added in 1.7.27 as a proper, page-by-page replacement for relying on a
 * third-party "hide title" plugin, which previously left a stray gap
 * behind because the page template's entry-header wrapper rendered its
 * own margin-bottom even when its content was hidden by such a plugin.
 * This keeps both the visibility and the spacing decision inside the
 * theme, so hiding a title never leaves a gap, on any page, not just the
 * site's front page.
 *
 * @package MEC_Theme
 */

/**
 * Register the Title Settings meta box on Pages (and Posts, since the
 * same need -- a clean title-free layout -- applies there too).
 */
function mec_theme_add_title_settings_meta_box() {
    add_meta_box(
        'mec_theme_title_settings',
        __( 'Title Settings', 'mec_theme' ),
        'mec_theme_render_title_settings_meta_box',
        array( 'page', 'post' ),
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'mec_theme_add_title_settings_meta_box' );

/**
 * Render the meta box fields.
 */
function mec_theme_render_title_settings_meta_box( $post ) {
    wp_nonce_field( 'mec_theme_title_settings_save', 'mec_theme_title_settings_nonce' );

    $hide_title = get_post_meta( $post->ID, '_mec_theme_hide_title', true );
    $alignment  = get_post_meta( $post->ID, '_mec_theme_title_align', true );
    if ( ! in_array( $alignment, array( 'left', 'center', 'right' ), true ) ) {
        $alignment = 'left'; // Matches the theme's existing default heading alignment.
    }
    ?>
    <p>
        <label>
            <input type="checkbox" name="mec_theme_hide_title" value="1" <?php checked( $hide_title, '1' ); ?> />
            <?php esc_html_e( 'Hide title on this page', 'mec_theme' ); ?>
        </label>
    </p>
    <p>
        <label for="mec_theme_title_align"><?php esc_html_e( 'Title alignment', 'mec_theme' ); ?></label><br>
        <select name="mec_theme_title_align" id="mec_theme_title_align" style="width: 100%;">
            <option value="left" <?php selected( $alignment, 'left' ); ?>><?php esc_html_e( 'Left', 'mec_theme' ); ?></option>
            <option value="center" <?php selected( $alignment, 'center' ); ?>><?php esc_html_e( 'Center', 'mec_theme' ); ?></option>
            <option value="right" <?php selected( $alignment, 'right' ); ?>><?php esc_html_e( 'Right', 'mec_theme' ); ?></option>
        </select>
    </p>
    <p class="description">
        <?php esc_html_e( 'Alignment has no effect if the title is hidden. The front page never shows its title, regardless of this setting.', 'mec_theme' ); ?>
    </p>
    <?php
}

/**
 * Save the meta box fields, with full nonce/capability/sanitization checks.
 */
function mec_theme_save_title_settings_meta_box( $post_id ) {
    if ( ! isset( $_POST['mec_theme_title_settings_nonce'] ) ||
        ! wp_verify_nonce( $_POST['mec_theme_title_settings_nonce'], 'mec_theme_title_settings_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $hide_title = isset( $_POST['mec_theme_hide_title'] ) ? '1' : '0';
    update_post_meta( $post_id, '_mec_theme_hide_title', $hide_title );

    $alignment = isset( $_POST['mec_theme_title_align'] ) ? sanitize_text_field( wp_unslash( $_POST['mec_theme_title_align'] ) ) : 'left';
    if ( ! in_array( $alignment, array( 'left', 'center', 'right' ), true ) ) {
        $alignment = 'left';
    }
    update_post_meta( $post_id, '_mec_theme_title_align', $alignment );
}
add_action( 'save_post', 'mec_theme_save_title_settings_meta_box' );

/**
 * Whether the title should be shown for the current post in the loop.
 * Always false on the front page, regardless of the per-page setting.
 */
function mec_theme_should_show_title() {
    // is_front_page() is true for the entire request when displaying the
    // homepage -- including when Settings > Reading is set to "Your latest
    // posts" and the homepage is really a loop of multiple blog posts, each
    // with its own title that should display normally. The intent here is
    // only to suppress a STATIC PAGE's own title when that page is used as
    // the front page (e.g. a page literally titled "FRONT PAGE" used as a
    // landing page) -- so this must also confirm we're looking at a Page,
    // not just any front-page request, or every post's title in a blog
    // listing on the homepage gets incorrectly hidden too.
    if ( is_front_page() && is_page() ) {
        return false;
    }
    $hide_title = get_post_meta( get_the_ID(), '_mec_theme_hide_title', true );
    return '1' !== $hide_title && '' !== get_the_title();
}

/**
 * The current post's configured title alignment, as a sanitized CSS value.
 */
function mec_theme_get_title_align() {
    $alignment = get_post_meta( get_the_ID(), '_mec_theme_title_align', true );
    if ( ! in_array( $alignment, array( 'left', 'center', 'right' ), true ) ) {
        $alignment = 'left';
    }
    return $alignment;
}
