<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying posts
 *
 * @package MEC_Theme
 * @version 1.7.4
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
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
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