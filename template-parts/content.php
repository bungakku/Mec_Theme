<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying posts
 *
 * Fixed in 1.7.50: this generic fallback part (used only when a custom
 * post type has no matching content-{posttype}.php) never called
 * mec_theme_should_show_title() / mec_theme_get_title_align(), unlike
 * content-page.php, content-post.php, and content-blog.php, which all
 * already did. The Title Settings meta box (1.7.27) silently had no
 * effect for any content type routed through this fallback. Ported the
 * same conditional + alignment-class logic already used in content-blog.php.
 *
 * @package MEC_Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'large' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <?php
        if ( mec_theme_should_show_title() ) :
            $title_align_class = ' entry-title--align-' . esc_attr( mec_theme_get_title_align() );
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title' . $title_align_class . '">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title' . $title_align_class . '"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
        endif;

        if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <span class="posted-on">
                    <?php echo esc_html( get_the_date() ); ?>
                </span>
                <span class="byline">
                    <?php esc_html_e( 'by', 'mec_theme' ); ?> <?php the_author_posts_link(); ?>
                </span>
                <span class="comments-link">
                    <?php mec_theme_comments_link_markup(); ?>
                </span>
            </div><!-- .entry-meta -->
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
            the_excerpt();
            ?>
            <a href="<?php the_permalink(); ?>" class="read-more">
                <?php esc_html_e( 'Read More', 'mec_theme' ); ?>
            </a>
        <?php endif; ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
