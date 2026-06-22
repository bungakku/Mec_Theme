<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The template for displaying search results
 *
 * @package MEC_Theme
 * @version 1.7.1
 */

get_header();
?>

<div class="container">
    <div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar'; ?>">
        <main id="primary" class="primary">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        printf(
                            esc_html__( 'Search Results for: %s', 'mec_theme' ),
                            '<span>' . esc_html( get_search_query() ) . '</span>'
                        );
                        ?>
                    </h1>
                </header><!-- .page-header -->

                <?php
                $blog_layout = get_theme_mod( 'mec_theme_blog_layout', 'classic' );
                $grid_columns = get_theme_mod( 'mec_theme_grid_columns', '2' );

                if ( 'grid' === $blog_layout ) {
                    echo '<div class="blog-grid grid-columns-' . esc_attr( $grid_columns ) . '">';
                } elseif ( 'list' === $blog_layout ) {
                    echo '<div class="blog-list">';
                }

                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'blog' );
                endwhile;

                if ( 'grid' === $blog_layout || 'list' === $blog_layout ) {
                    echo '</div>';
                }

                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '&laquo; ' . __( 'Previous', 'mec_theme' ),
                    'next_text' => __( 'Next', 'mec_theme' ) . ' &raquo;',
                ) );

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