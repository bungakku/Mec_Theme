<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The template for displaying all single posts
 *
 * @package MEC_Theme
 * @version 1.7.4
 */

get_header(); ?>

<div class="container">
    <div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar'; ?>">
        <main id="primary" class="primary">
            <?php
            while ( have_posts() ) :
                the_post();
                
                get_template_part( 'template-parts/content', get_post_type() );
                
                the_post_navigation( array(
                    'prev_text' => '&laquo; ' . __( 'Previous Post', 'mec_theme' ),
                    'next_text' => __( 'Next Post', 'mec_theme' ) . ' &raquo;',
                ) );
                
                if ( function_exists( 'mec_theme_author_bio' ) ) {
                    mec_theme_author_bio();
                }
                
                if ( function_exists( 'mec_theme_related_posts' ) ) {
                    mec_theme_related_posts();
                }
                
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                
            endwhile;
            ?>
        </main><!-- #primary -->

        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            <aside id="secondary" class="secondary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            </aside><!-- #secondary -->
        <?php endif; ?>
    </div><!-- .content-area -->
</div><!-- .container -->

<?php
get_footer();