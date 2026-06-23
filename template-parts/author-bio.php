<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template part for displaying author bio
 *
 * @package MEC_Theme
 * @version 1.7.7
 */

if ( ! is_single() ) {
    return;
}
?>

<div class="author-bio">
    <h3><?php esc_html_e( 'About the Author', 'mec_theme' ); ?></h3>
    <div class="author-info">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
        <div class="author-description">
            <h4><?php echo esc_html( get_the_author() ); ?></h4>
            <p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
        </div>
    </div>
</div>