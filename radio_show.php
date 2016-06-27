<?php
/*
Template Name: Radio Show
*/

get_header();

global $post;

?>
<div id="blRadioShow">


    <?php get_template_part('right_sidebar'); ?>
    <div class="bl_left">
        <li class="post">
            <h3 style="color:#444646;margin-bottom:30px;margin-left:5px;">Select a radio show below and enjoy the program.</h3>
        </li>
        <ul>
            <?php
            
            $exp_uri = explode("/",$_SERVER['REQUEST_URI']);
            $station = str_replace( '-', '_', $exp_uri[1] );
            
            $args = array(
                'post_type'=>$station,
                'numberposts'=>-1,
                'meta_key'=>'radio_show',
                'meta_compare'=>'>',
                'meta_value'=>'0'
            );

            if ( $_REQUEST['month'] ){
                $args['date_query'] = array();
                $args['date_query'][]['year'] = date( "Y", strtotime($_REQUEST['month'] ) );
                $args['date_query'][]['monthnum'] = date( "m", strtotime($_REQUEST['month'] ) );
            }

            $radio_shows = new WP_Query($args);
            
            if ( $radio_shows->have_posts() ) :
            
                while ( $radio_shows->have_posts() ) : $radio_shows->the_post(); ?>
            
                    <li class="post">
                        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                    </li>
            
                <?php endwhile;
            
                wp_reset_postdata();
            
            endif; ?>

        </ul>
    </div>
    <div class="blClear"></div>
</div>

<?php get_footer();