<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The template for displaying all pages
 *
 * @package MEC_Theme
 */

get_header(); ?>

<div class="container">
    <div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar'; ?>">
        <main id="primary" class="primary">
            <?php
            while ( have_posts() ) :
                the_post();
                
                get_template_part( 'template-parts/content', 'page' );
                
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
