<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The template for displaying comments
 *
 * Added in 1.7.67. single.php and page.php both call comments_template(),
 * but the theme shipped no comments.php, so WordPress logged a "Theme
 * without comments.php is deprecated since version 3.0.0" notice (visible
 * with WP_DEBUG on) and fell back to its own legacy template. This
 * provides the real one, kept deliberately small: it uses only native
 * WordPress comment APIs, reuses strings and spacing conventions already
 * used elsewhere in the theme, and relies on the html5 'comment-list' /
 * 'comment-form' theme support already declared in functions.php.
 *
 * @package MEC_Theme
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            printf(
                /* translators: %s: number of comments */
                esc_html( _n( '%s Comment', '%s Comments', $comment_count, 'mec_theme' ) ),
                esc_html( number_format_i18n( $comment_count ) )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
            ) );
            ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="comment-navigation" aria-label="<?php esc_attr_e( 'Comments Navigation', 'mec_theme' ); ?>">
                <div class="nav-previous"><?php previous_comments_link( '&laquo; ' . esc_html__( 'Older Comments', 'mec_theme' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'mec_theme' ) . ' &raquo;' ); ?></div>
            </nav><!-- .comment-navigation -->
        <?php endif; ?>

        <?php if ( ! comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'mec_theme' ); ?></p>
        <?php endif; ?>

    <?php endif; // have_comments() ?>

    <?php comment_form(); ?>

</div><!-- #comments -->
