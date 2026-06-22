<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The template for displaying 404 pages (not found)
 *
 * @package MEC_Theme
 * @version 1.7.3
 */

get_header();
?>

<div class="container">
    <div class="content-area no-sidebar">
        <main id="primary" class="primary">
            <section class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can’t be found.', 'mec_theme' ); ?></h1>
                </header><!-- .page-header -->

                <div class="page-content">
                    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'mec_theme' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .page-content -->
            </section><!-- .error-404 -->
        </main><!-- #primary -->
    </div><!-- .content-area -->
</div><!-- .container -->

<?php
get_footer();