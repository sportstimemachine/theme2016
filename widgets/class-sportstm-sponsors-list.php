<?php

if ( ! class_exists( 'SportsTM_Sponsors_List' ) ) {

    class SportsTM_Sponsors_List extends WP_Widget {

        /**
        * Register widget with WordPress.
        */
        function __construct() {
            parent::__construct(
                'sportstm_sponsors_list', // Base ID
                __( 'Sports Time Machine - Sponsors List', THEME_ID ), // Name
                array( 
                    'classname' => 'sportstm-sponsors-list-widget',
                    'description' => __( 'A Widget that shows a list of Sponsor Logos.', THEME_ID ),
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
                    echo $args['before_title'] . apply_filters( 'widget_title', __( 'Our Sponsors', THEME_ID ) ) . $args['after_title'];
                }

                ?>

                    <ul style="margin:0;padding:0;display:inline;">
                        
                        <?php 
                        
                        if ( strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], 'stark' ) >= 0 ) {
                            $args = array( 'post_type' => 'stark_sponsors', 'post_status'=>'publish', 'numberposts' => 8);
                        }

                        if( strpos( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], 'summit' ) >= 0 ) {
                            $args = array( 'post_type' => 'summit_sponsors', 'post_status'=>'publish','numberposts' => 8);
                        }

                        if ( strpos( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], '?s=' ) >= 0 ) {
                            $args = array( 'post_type' => 'summit_sponsors', 'post_status'=>'publish','numberposts' => 8);
                        }

                        global $post;

                        $sponsors = new WP_Query( $args );

                        if ( $sponsors->have_posts() ) : 

                            while ( $sponsors->have_posts() ) : $sponsors->the_post();
                        
                                $logo = wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'logo', true ), 'full', '' );
                                $link = get_post_meta( get_the_ID(), 'link', true );
                        
                                $has_http = preg_match_all( '/(http)?(s)?(:)?(\/\/)/i', $link, $matches );
                                if ( $has_http == 0 ) {
                                    $link = '//' . $link;
                                }

                                if ( get_post_meta( get_the_ID(), 'coupon', true ) == '' && get_post_meta( get_the_ID(), 'coupon_active', true ) !== 'yes' ) : ?>
                                    <li style="border:none;display:inline-block;margin:0;padding:4px 2px;">
                                        <a target="_blank" href="<?php echo $link?>" style="margin:0;padding:0px;">

                                            <img src="<?php echo $logo[0]?>" width="122" height="105"> 


                                        </a> 
                                    </li>
                                <?php else : ?>
                                    <li style="border:none;display:inline-block;padding:4px 2px;margin:0;">
                                        <a class="sponsor" cursor="pointer" href="<?php echo $post->post_name?>/coupon?id=<?php echo $id?>"><img src="<?php echo $logo[0]?>" width="122"></a>  
                                    </li>
                                <?php endif; 

                            endwhile;

                            wp_reset_postdata();

                        endif; ?>

                    </ul>

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
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Our Sponsors', THEME_ID );

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