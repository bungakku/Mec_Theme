<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying related posts
 *
 * @package MEC_Theme
 * @version 1.7.4
 */

if ( ! is_single() ) {
    return;
}

$categories = get_the_category();
if ( ! $categories ) {
    return;
}

$category_ids = array();
foreach ( $categories as $category ) {
    $category_ids[] = $category->term_id;
}

$related_count = get_theme_mod( 'mec_theme_related_count', 3 );
$related_query = new WP_Query( array(
    'category__in' => $category_ids,
    'post__not_in' => array( get_the_ID() ),
    'posts_per_page' => $related_count,
    'ignore_sticky_posts' => 1,
) );

if ( ! $related_query->have_posts() ) {
    return;
}

$related_cols = min( $related_count, 3 );
?>

<div class="related-posts">
    <h3><?php esc_html_e( 'Related Posts', 'mec_theme' ); ?></h3>
    <div class="related-posts-grid" style="grid-template-columns: repeat(<?php echo esc_attr( $related_cols ); ?>, 1fr);">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
            <article class="related-post">
                <?php if ( has_post_thumbnail() && 'show' === get_theme_mod( 'mec_theme_show_featured_image', 'show' ) ) : ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" aria-hidden="true" tabindex="-1">
                        <?php the_post_thumbnail( 'mec_theme-thumbnail' ); ?>
                    </a>
                <?php endif; ?>
                <h4><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
                <?php if ( get_theme_mod( 'mec_theme_show_post_date', true ) ) : ?>
                    <span class="related-post-date"><?php echo esc_html( get_the_date() ); ?></span>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php
wp_reset_postdata();