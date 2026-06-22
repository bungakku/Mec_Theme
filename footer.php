<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The footer template
 *
 * @package MEC_Theme
 * @version 1.7.6
 */

?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php
        $footer_layout = get_theme_mod( 'mec_theme_footer_layout', '4' );
        $footer_direction = get_theme_mod( 'mec_theme_footer_direction', 'horizontal' );
        
        $footer_columns = absint( $footer_layout );
        if ( $footer_columns < 1 ) {
            $footer_columns = 1;
        }
        
        $active_footer_columns = array();
        for ( $i = 1; $i <= $footer_columns; $i++ ) {
            if ( is_active_sidebar( 'footer-' . $i ) ) {
                $active_footer_columns[] = $i;
            }
        }
        $has_footer_widgets = ! empty( $active_footer_columns );
        
        if ( $has_footer_widgets ) : 
            $grid_style = '';
            if ( 'horizontal' === $footer_direction ) {
                $col_count = count( $active_footer_columns );
                if ( $col_count < 1 ) {
                    $col_count = 1;
                }
                $grid_style = 'grid-template-columns: repeat(' . $col_count . ', 1fr);';
            }
            ?>
            <div class="footer-widgets-container">
                <div class="footer-widgets <?php echo esc_attr( $footer_direction ); ?>" 
                     style="<?php echo esc_attr( $grid_style ); ?>">
                    <?php
                    foreach ( $active_footer_columns as $i ) {
                        echo '<div class="footer-widget footer-widget-' . esc_attr( $i ) . '">';
                        dynamic_sidebar( 'footer-' . $i );
                        echo '</div>';
                    }
                    ?>
                </div><!-- .footer-widgets -->
            </div><!-- .footer-widgets-container -->
        <?php endif; ?>

        <div class="site-info">
            <div class="footer-bottom">
                <div class="copyright">
                    <?php
                    // Copyright text – safe with wp_kses, default uses date_i18n() for WP 5.0+ compatibility
                    $copyright_text = get_theme_mod( 'mec_theme_copyright_text', '&copy; ' . date_i18n('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.' );
                    
                    echo wp_kses( $copyright_text, array(
                        'a' => array(
                            'href' => array(),
                            'title' => array(),
                            'target' => array(),
                            'rel' => array(),
                            'class' => array(),
                        ),
                        'br' => array(),
                        'strong' => array(),
                        'em' => array(),
                        'span' => array(
                            'class' => array(),
                        ),
                    ) );
                    ?>
                </div>
                
                <?php if ( get_theme_mod( 'mec_theme_show_footer_menu', true ) && has_nav_menu( 'footer' ) ) : ?>
                    <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'mec_theme' ); ?>">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            )
                        );
                        ?>
                    </nav>
                <?php endif; ?>
            </div><!-- .footer-bottom -->
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>