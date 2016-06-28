<?php

if ( ! class_exists( 'SportsTM_Facebook' ) ) {

    class SportsTM_Facebook extends WP_Widget {

        /**
        * Register widget with WordPress.
        */
        function __construct() {
            parent::__construct(
                'sportstm_facebook', // Base ID
                __( 'Sports Time Machine - Facebook', THEME_ID ), // Name
                array( 
                    'classname' => 'sportstm-facebook-widget',
                    'description' => __( 'A Widget that shows Facebook Likes for a Page.', THEME_ID ),
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
                    echo $args['before_title'] . apply_filters( 'widget_title', __( 'Facebook', THEME_ID ) ) . $args['after_title'];
                }
            
                if ( empty( $instance['page'] ) ) {
                    $instance['page'] = 'https://www.facebook.com/pages/Sports-Time-Machine/241806463316';
                }
            
                if ( empty( $instance['feed'] ) || $instance['feed'] === false ) {
                    $instance['feed'] = 'false';
                }
                else {
                    $instance['feed'] = 'true';
                }
            

                ?>

                <div class="fb-like-box" data-href="<?php echo $instance['page']; ?>" data-width="<?php echo $instance['width']; ?>" data-height="<?php echo $instance['height']; ?>" data-show-faces="true" data-stream="<?php echo $instance['feed']; ?>" data-header="false"></div>

                <?php

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
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Facebook', THEME_ID );
            $page = ! empty( $instance['page'] ) ? $instance['page'] : 'https://www.facebook.com/pages/Sports-Time-Machine/241806463316';
            $width = ! empty( $instance['width'] ) ? $instance['width'] : '245';
            $height = ! empty( $instance['height'] ) ? $instance['height'] : '342';
            $feed = ! empty( $instance['feed'] ) ? $instance['feed'] : 'false';

    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEME_ID ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'page' ); ?>"><?php _e( 'Facebook Page URL:', THEME_ID ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" type="text" value="<?php echo esc_attr( $page ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width (px):', THEME_ID ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height (px):', THEME_ID ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'feed' ); ?>"><?php _e( 'Show Posts?', THEME_ID ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'feed' ); ?>" name="<?php echo $this->get_field_name( 'feed' ); ?>" type="checkbox"<?php echo ( $feed == true ) ? ' checked = "true"' : ''; ?> />
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
            $instance['page'] = ( ! empty( $new_instance['page'] ) ) ? strip_tags( $new_instance['page'] ) : '';
            $instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '';
            $instance['height'] = ( ! empty( $new_instance['height'] ) ) ? strip_tags( $new_instance['height'] ) : '';
            $instance['feed'] = ( ! empty( $new_instance['feed'] ) ) ? strip_tags( $new_instance['feed'] ) : false;

            return $instance;
        }

    }
    
}