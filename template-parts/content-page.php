<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying page content in page.php
 *
 * @package MEC_Theme
 * @version 1.7.26
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    // Suppress the page title (and its wrapper, to avoid a stray margin)
    // on the front page -- a page used as the static front page typically
    // shouldn't display its own admin-facing title (e.g. "FRONT PAGE") as
    // visible content, since that title is really just an internal label.
    // Also skipped if the post genuinely has no title.
    $show_title = ! is_front_page() && get_the_title();
    ?>
    <?php if ( $show_title ) : ?>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->
    <?php endif; ?>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mec_theme' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->