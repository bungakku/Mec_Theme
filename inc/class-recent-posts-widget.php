<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Custom Recent Posts Widget with Excerpt and Read More
 *
 * Extracted from functions.php during the 1.7.7 file-organization pass.
 * No behavior changed — registration still happens via
 * register_widget( 'MEC_Theme_Recent_Posts_Widget' ) in functions.php.
 *
 * @package MEC_Theme
 * @version 1.7.7
 */

class MEC_Theme_Recent_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mec_theme_recent_posts',
            esc_html__( 'MEC Recent Posts (with excerpt)', 'mec_theme' ),
            array(
                'description' => esc_html__( 'Display recent posts with thumbnail, excerpt and read more link.', 'mec_theme' ),
                'classname'   => 'widget_mec_recent_posts',
            )
        );
    }
    
    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : true;
        $show_readmore = isset( $instance['show_readmore'] ) ? (bool) $instance['show_readmore'] : true;
        $excerpt_length = ! empty( $instance['excerpt_length'] ) ? absint( $instance['excerpt_length'] ) : 15;
        
        $query_args = array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        );
        
        $recent_posts = new WP_Query( $query_args );
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        
        if ( $recent_posts->have_posts() ) : ?>
            <ul class="mec-recent-posts-list">
                <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                    <li class="mec-recent-post-item">
                        <?php if ( $show_thumbnail && has_post_thumbnail() ) : ?>
                            <div class="recent-post-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="recent-post-content">
                            <h4 class="recent-post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <?php if ( $show_excerpt ) : ?>
                                <div class="recent-post-excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( $show_readmore ) : ?>
                                <a href="<?php the_permalink(); ?>" class="read-more-link">
                                    <?php esc_html_e( 'Read More', 'mec_theme' ); ?> &rarr;
                                </a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'mec_theme' ); ?></p>
        <?php endif;
        
        echo $args['after_widget'];
    }
    
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'mec_theme' );
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : true;
        $show_readmore = isset( $instance['show_readmore'] ) ? (bool) $instance['show_readmore'] : true;
        $excerpt_length = isset( $instance['excerpt_length'] ) ? absint( $instance['excerpt_length'] ) : 15;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mec_theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'mec_theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $number ); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_thumbnail ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_thumbnail' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_thumbnail' ) ); ?>"><?php esc_html_e( 'Show featured image', 'mec_theme' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_excerpt' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"><?php esc_html_e( 'Show excerpt', 'mec_theme' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_readmore ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_readmore' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>"><?php esc_html_e( 'Show "Read More" link', 'mec_theme' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php esc_html_e( 'Excerpt length (words):', 'mec_theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" step="1" min="5" max="100" value="<?php echo esc_attr( $excerpt_length ); ?>">
        </p>
        <?php
    }
    
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = absint( $new_instance['number'] );
        $instance['show_thumbnail'] = ! empty( $new_instance['show_thumbnail'] );
        $instance['show_excerpt'] = ! empty( $new_instance['show_excerpt'] );
        $instance['show_readmore'] = ! empty( $new_instance['show_readmore'] );
        $instance['excerpt_length'] = absint( $new_instance['excerpt_length'] );
        return $instance;
    }
}
