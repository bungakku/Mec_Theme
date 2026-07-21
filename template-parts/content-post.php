<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying a single blog post.
 *
 * Added in 1.7.20. single.php calls get_template_part(
 * 'template-parts/content', get_post_type() ), which for a standard post
 * resolves to content-post.php -- this exact filename. No such file
 * existed before 1.7.20, so WordPress was silently falling back to the
 * generic template-parts/content.php instead, whose entry-meta block was
 * completely hardcoded and ignored every Blog Settings Customizer value
 * (Post Meta show/hide/custom, individual date/author/comments toggles).
 * This file ports the same conditional logic already used correctly in
 * content-blog.php (the blog-listing template part), so a single post
 * page now respects the same settings a blog listing already did.
 *
 * @package MEC_Theme
 */

$show_meta = get_theme_mod( 'mec_theme_show_post_meta', 'show' );
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
        if ( mec_theme_should_show_title() ) {
            printf(
                '<h1 class="entry-title entry-title--align-%s">',
                esc_attr( mec_theme_get_title_align() )
            );
            the_title();
            echo '</h1>';
        }

        if ( 'post' === get_post_type() ) :
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
                            <?php mec_theme_comments_link_markup(); ?>
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
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
