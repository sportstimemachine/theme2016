<?php

if ( ! class_exists( 'SportsTM_Archives' ) ) {

    class SportsTM_Archives extends WP_Widget {

        /**
        * Register widget with WordPress.
        */
        function __construct() {
            parent::__construct(
                'sportstm_archives', // Base ID
                __( 'Sports Time Machine Archives', 'woothemes' ), // Name
                array( 
                    'classname' => 'sportstm-archives-widget',
                    'description' => __( 'A Widget that shows Radio Show Archives.', THEME_ID ),
                ) // Args
            );
        }

        /**
        * Front-end display of widget.
        *
        * @see WP_Widget::widget()
        *
        * @param array $args     Widget arguments.
        * @param array $instance Saved values from database.
        */
        public function widget( $args, $instance ) {

            echo $args['before_widget'];

                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                }
                else {
                    echo $args['before_title'] . apply_filters( 'widget_title', __( 'Radio Show Archives', THEME_ID ) ) . $args['after_title'];
                }

                if ( empty( $args['before_content'] ) ) {
                    $args['before_content'] = '<div class="bl_box">';
                }

                if ( empty( $args['before_content'] ) ) {
                    $args['after_content'] = '</div>';
                }

                echo $args['before_content'];

                ?>

                    <ul>

                            <?php
                                $exp_uri = explode("/",$_SERVER['REQUEST_URI']);
                                $station = str_replace( '-', '_', $exp_uri[1] );

                                if ( strpos( $station, '?s=' ) >= 0 ) {
                                    $station = 'summit_radio';
                                }

                                $args = array(
                                    'post_type'=>$station,
                                    'numberposts'=>-1,
                                    'orderby'=>'post_date',
                                    'order'=>'ASC'
                                );

                                $radio_shows = new WP_Query( $args );
                                $years = array();
                                if ( $radio_shows->have_posts() ) : 

                                    while ( $radio_shows->have_posts() ) : $radio_shows->the_post();

                                        $post_year = get_the_time( 'Y' );
                                        $post_month = get_the_time( 'F' );
                                        $years[$post_year][$post_month]['total']++;
                                        $years[$post_year][$post_month]['posts'][] = array( 'title'=> get_the_title(), 'permalink'=>get_permalink( get_the_ID() ) );

                                    endwhile;

                                    wp_reset_postdata();

                                endif;
                                foreach ( $years as $year_key => $year ) : ?>

                                    <li class="radio_archive_year"><?php echo $year_key; ?>

                                        <ul>

                                        <?php foreach ( $year as $month_key => $month ) : ?>

                                            <li class="radio_archive_month">
                                                <a href="/<?php echo str_replace( '_', '-', $station ); ?>/radio-show/?month=<?php echo $month_key?>-<?php echo $year_key?>">
                                                    <?php echo $month_key; ?> (<?php echo $month['total']; ?>)</a>
                                            </li>

                                        <?php endforeach; ?>

                                        </ul>

                                    </li>

                                <?php endforeach; ?>

                        </ul>

                <?php
            
                echo $args['after_content'];

            echo $args['after_widget'];

        }

        /**
        * Back-end widget form.
        *
        * @see WP_Widget::form()
        *
        * @param array $instance Previously saved values from database.
        */
        public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Radio Show Archives', THEME_ID );

    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEME_ID ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
        }

        /**
        * Sanitize widget form values as they are saved.
        *
        * @see WP_Widget::update()
        *
        * @param array $new_instance Values just sent to be saved.
        * @param array $old_instance Previously saved values from database.
        *
        * @return array Updated safe values to be saved.
        */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

            return $instance;
        }

    }
    
}