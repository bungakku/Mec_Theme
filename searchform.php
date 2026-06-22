<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Custom search form
 *
 * @package MEC_Theme
 * @version 1.7.4
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'mec_theme' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search ...', 'mec_theme' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'mec_theme' ); ?>">
        <span aria-hidden="true">&#128269;</span>
    </button>
</form>