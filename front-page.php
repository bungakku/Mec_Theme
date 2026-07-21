<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The front page template file
 *
 * @package MEC_Theme
 */

get_header(); ?>

<div class="container">
    <div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar'; ?>">
        <main id="primary" class="primary">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'blog' );
                endwhile;
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;
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
