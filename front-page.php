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
            $blog_layout = get_theme_mod( 'mec_theme_blog_layout', 'classic' );
            $grid_columns = get_theme_mod( 'mec_theme_grid_columns', '2' );

            // 1.7.90: a static front page is one page, not a list of posts. In the
            // Grid layout the .blog-grid wrapper put the whole page into a single
            // card (a third to a half of the content width), so only wrap posts.
            if ( ! is_home() ) {
                $blog_layout = 'classic';
            }
            ?>

            <?php if ( 'grid' === $blog_layout ) : ?>
                <div class="blog-grid grid-columns-<?php echo esc_attr( $grid_columns ); ?>">
            <?php elseif ( 'list' === $blog_layout ) : ?>
                <div class="blog-list">
            <?php endif; ?>

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

            <?php if ( 'grid' === $blog_layout || 'list' === $blog_layout ) : ?>
                </div><!-- .blog-grid or .blog-list -->
            <?php endif; ?>

            <?php
            // Added in 1.7.78: WordPress uses front-page.php for the posts
            // index too whenever Settings > Reading is "Your latest posts"
            // (the default), so this template -- not index.php -- renders the
            // home page, and without this call visitors had no way to reach
            // any post beyond the first page. Same arguments as index.php and
            // archive.php. It prints nothing when a static page is the front
            // page (a single page has only one "page" of results).
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '&laquo; ' . __( 'Previous', 'mec_theme' ),
                'next_text' => __( 'Next', 'mec_theme' ) . ' &raquo;',
            ) );
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
