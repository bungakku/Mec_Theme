<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The main template file - Used for blog index
 *
 * @package MEC_Theme
 * @version 1.7.8
 */

get_header(); 

$blog_layout = get_theme_mod( 'mec_theme_blog_layout', 'classic' );
$grid_columns = get_theme_mod( 'mec_theme_grid_columns', '2' );
?>

<div class="container">
    <div class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar'; ?>">
        <main id="primary" class="primary">
            
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