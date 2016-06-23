<?php
/*
Template Name: Radio Show
*/

get_header();

global $post;

?>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer/jquery.jplayer.min.js"></script>
<link href="<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer/jplayer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer/blue_monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

<script>

    ( function( $ ) {
        $('.cd_request').submit(function() {	
            $.post('/template/cd_request_submit.php',$(this).serialize());
            $('.bl_form').html('<p style="font-size:16px;height:200px;width:400px;">Thank you!<br/>  We will be sending you a CD of the requested episode.</p>');
            return false;
        } )( jQuery );

    });
</script>

<!-- Begin blBody -->




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
                $args['year'] = date("Y",strtotime($_REQUEST['month']));
                $args['monthnum'] = date("m",strtotime($_REQUEST['month']));
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