<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying blog posts with customizable options
 *
 * @package MEC_Theme
 * @version 1.7.3
 */

$blog_layout = get_theme_mod( 'mec_theme_blog_layout', 'classic' );
$show_image = get_theme_mod( 'mec_theme_show_featured_image', 'show' );
$image_size = get_theme_mod( 'mec_theme_featured_image_size', 'large' );
$content_display = get_theme_mod( 'mec_theme_content_display', 'excerpt' );
$show_read_more = get_theme_mod( 'mec_theme_show_read_more', true );
$read_more_text = get_theme_mod( 'mec_theme_read_more_text', 'Read More' );
$show_meta = get_theme_mod( 'mec_theme_show_post_meta', 'show' );

$post_classes = 'blog-post ' . $blog_layout . '-post';
if ( 'grid' === $blog_layout ) {
    $grid_columns = get_theme_mod( 'mec_theme_grid_columns', '2' );
    $post_classes .= ' grid-column-' . $grid_columns;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
    
    <?php if ( 'show' === $show_image && has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( $image_size ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content-wrapper">
        <header class="entry-header">
            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
            ?>

            <?php if ( 'post' === get_post_type() ) : ?>
                <?php
                $show_date = true;
                $show_author = true;
                $show_comments = true;
                $show_categories = false;
                
                if ( 'hide' === $show_meta ) {
                    $show_date = $show_author = $show_comments = $show_categories = false;
                } elseif ( 'custom' === $show_meta ) {
                    $show_date = get_theme_mod( 'mec_theme_show_post_date', true );
                    $show_author = get_theme_mod( 'mec_theme_show_post_author', true );
                    $show_comments = get_theme_mod( 'mec_theme_show_post_comments', true );
                    $show_categories = get_theme_mod( 'mec_theme_show_post_categories', false );
                }
                
                if ( $show_date || $show_author || $show_comments || $show_categories ) : ?>
                    <div class="entry-meta">
                        <?php if ( $show_date ) : ?>
                            <span class="posted-on">
                                <?php echo esc_html( get_the_date() ); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ( $show_author ) : ?>
                            <span class="byline">
                                <?php esc_html_e( 'by', 'mec_theme' ); ?> <?php the_author_posts_link(); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ( $show_comments ) : ?>
                            <span class="comments-link">
                                <?php
                                $comment_count = get_comments_number();
                                if ( $comment_count == 0 ) {
                                    $comments_text = __( '0 Comments', 'mec_theme' );
                                    $screen_reader_text = __( '0 comments', 'mec_theme' );
                                } elseif ( $comment_count == 1 ) {
                                    $comments_text = __( '1 Comment', 'mec_theme' );
                                    $screen_reader_text = __( '1 comment', 'mec_theme' );
                                } else {
                                    /* translators: %s: number of comments */
                                    $comments_text = sprintf( __( '%s Comments', 'mec_theme' ), number_format_i18n( $comment_count ) );
                                    $screen_reader_text = sprintf( __( '%s comments', 'mec_theme' ), number_format_i18n( $comment_count ) );
                                }
                                ?>
                                <a href="<?php comments_link(); ?>">
                                    <span aria-hidden="true"><?php echo esc_html( $comments_text ); ?></span>
                                    <span class="screen-reader-text"><?php echo esc_html( $screen_reader_text ); ?></span>
                                </a>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ( $show_categories ) : ?>
                            <span class="cat-links">
                                <?php esc_html_e( 'in', 'mec_theme' ); ?> <?php the_category( ', ' ); ?>
                            </span>
                        <?php endif; ?>
                    </div><!-- .entry-meta -->
                <?php endif; ?>
            <?php endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            if ( is_singular() ) :
                the_content( sprintf(
                    wp_kses(
                        __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'mec_theme' ),
                        array( 'span' => array( 'class' => array() ) )
                    ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );
                
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mec_theme' ),
                    'after'  => '</div>',
                ) );
                
            else :
                if ( 'excerpt' === $content_display ) {
                    the_excerpt();
                } elseif ( 'full' === $content_display ) {
                    the_content( '' );
                }
                
                if ( $show_read_more && 'none' !== $content_display ) : ?>
                    <a href="<?php the_permalink(); ?>" class="read-more">
                        <?php echo esc_html( $read_more_text ); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div><!-- .entry-content -->
    </div><!-- .entry-content-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->