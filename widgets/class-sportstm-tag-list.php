<?php

if ( ! class_exists( 'SportsTM_Tag_List' ) ) {
    
    class SportsTM_Tag_List extends WP_Widget_Tag_Cloud {
        
        /**
        * Register widget with WordPress.
        */
        function __construct() {
            WP_Widget::__construct(
                'sportstm_tag_list', // Base ID
                __( 'Sports Time Machine - Tag/Category List', THEME_ID ), // Name
                array( 
                    'classname' => 'sportstm-tag-list-widget',
                    'description' => __( 'A Widget that shows a Tag or Category List.', THEME_ID ),
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
            
            $current_taxonomy = $this->_get_current_taxonomy($instance);
            if ( ! empty( $instance['title'] ) ) {
                $title = $instance['title'];
            } 
            else {
                if ( 'post_tag' == $current_taxonomy ) {
                    $title = __( 'Articles by Topic', THEME_ID );
                } else {
                    $tax = get_taxonomy($current_taxonomy);
                    $title = $tax->labels->name;
                }
            }
            
            $tags = get_terms( $current_taxonomy, array( 'hide_empty' => true ) );

            if ( empty( $tags ) ) {
                return;
            }

            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            echo $args['before_widget'];
            
                if ( $title ) {
                    echo $args['before_title'] . $title . $args['after_title'];
                }

                ?>
                
                <ul class="post_tags">

                    <?php foreach ( $tags as $tag ) : 

                        $tag_link = get_tag_link( $tag->term_id );

                        ?>

                        <li style="border:none;padding:0px;margin:10px 0;">
                            <a style="color:#00b8fd;text-decoration:underline;font-size:12px;" href="<?php echo $tag_link; ?>" title="<?php echo $tag->name; ?> Tag" class="<?php echo $tag->slug; ?>">
                                <?php echo $tag->name; ?>
                            </a>
                        </li>

                    <?php endforeach; ?>

                </ul>

            <?php echo $args['after_widget'];

        }
        
    }

}