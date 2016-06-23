<?php
/*
Template Name: Radio Show
*/

get_header(); ?>

<script type="text/javascript" src="/template/js/jplayer/jquery.jplayer.min.js"></script>
<link href="/template/js/jplayer/jplayer.css" rel="stylesheet" type="text/css" />
<link href="/template/js/jplayer/blue_monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<?php 
/* WHICH STATION */
$station =  get_post_ancestors($post->ID);
$station = $station[0];
$station = get_post($station);
$station = (array) $station; 
?>

<script>
	$(function() {
	   $('.cd_request').submit(function() {	
	   		$.post('/template/cd_request_submit.php',$(this).serialize());
		 $('.bl_form').html('<p style="font-size:16px;height:200px;width:400px;">Thank you!<br/>  We will be sending you a CD of the requested episode.</p>');
        return false;
      });
      
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
                    <?php //$args = array( 'post_type' =>'1480whbcposts', 'posts_per_page' => 10, 'post_status'=>'publish');
                    $args = array(
                    	'post_type'=>'stark_radio',
                    	'numberposts'=>-1,
                    	'meta_key'=>'radio_show',
                    	'meta_compare'=>'>',
                    	'meta_value'=>'0'
                    );
                    
                    if ( $_REQUEST['month'] ){
                    	$args['year'] = date("Y",strtotime($_REQUEST['month']));
                    	$args['monthnum'] = date("m",strtotime($_REQUEST['month']));
                    }
                    
                    $posts = query_posts($args);
                    	//$posts = get_posts( $args );
                    	$array = (array) $posts;         
                    	$count = 1;           	
                    	foreach($array as $radio){
                    	
                    		$audio = get_post_custom($radio->ID);
                    		      $radio = (array) $radio;
                    	?>
                        	<li class="post">
                            	<a href="/<?=$station['post_title']?>/<?=$radio['post_name']?>"><h3><?=$radio['post_title']?></h3></a>
                            </li>
                            <?php $count++; } ?>
                         
                        </ul>
                      </div>
                        <div class="blClear"></div>
                    </div>
                    <?php get_footer(); ?> 
                    </div>
                    </div>
          
                <!-- End blBody -->
