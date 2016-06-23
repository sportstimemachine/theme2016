<?php
/**
 * The Template for displaying all single posts.
 *
 */

get_header();
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer/jquery.jplayer.min.js"></script>
<link href="<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer/jplayer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer/blue_monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

<?php
global $post;

$radio = get_post_meta( get_the_ID(), 'audio', true );
$radio = wp_get_attachment_url( $radio );

?> 						

<!-- Begin blBlog -->
<div id="blBlog">

    <?php get_template_part('right_sidebar'); ?>

    <!-- Begin bl_left -->
    <div class="bl_left">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <!-- Begin bl_post -->
        <div class="bl_post">
            <div class="bl_left_side">
                <div class="bl_img"><?php echo get_avatar($post->post_author,50);?></div>
                <div class="bl_post_day"><b><?php echo date("j",strtotime($post->post_date))?></b><br/><?php echo date("M",strtotime($post->post_date))?></div>
                <!--<div class="bl_post_comments"><b>30</b><br/>Comments</div>-->
            </div>
            <div class="bl_left_side2">
                <a href="<?php echo the_permalink()?>"><h4><?php the_title()?></h4></a>
                <h5>By <?php the_author();?></h5>

                <div class="bl_post_text">
                    <?php the_content();?>
                    <?php if($radio != ''){
    if ( stripos($_SERVER['HTTP_USER_AGENT'],'msie') !== FALSE ){
                    ?>

                    <div style="text-align:center;margin-bottom:10px;">
                        <object type="application/x-shockwave-flash" data="/template/player_mp3_mini.swf" width="200" height="20">
                            <param name="movie" value="/template/player_mp3_mini.swf" />
                            <param name="bgcolor" value="#27475E" />
                            <param name="FlashVars" value="mp3=<?php echo $radio;?>" />
                        </object>
                    </div>
                    <?php
    } else{ ?>
                    <div style="margin-bottom:10px;">
                        <div id="jquery_jplayer_<?php echo get_the_ID();?>" class="jp-jplayer"></div>
                        <div id="jp_container_<?php echo get_the_ID();?>" class="jp-audio" style="margin: 0px auto">
                            <div class="jp-type-single">
                                <div class="jp-gui jp-interface">
                                    <ul class="jp-controls">
                                        <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                        <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                        <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                        <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                    </ul>
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-volume-bar">
                                        <div class="jp-volume-bar-value"></div>
                                    </div>
                                    <div class="jp-time-holder">
                                        <div class="jp-current-time"></div>
                                        <div class="jp-duration"></div>

                                        <ul class="jp-toggles">
                                            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="jp-title">
                                    <ul>
                                        <li><?php echo get_the_title();?></li>
                                    </ul>
                                </div>
                                <div class="jp-no-solution">
                                    <span>Update Required</span>
                                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                </div>
                            </div>
                        </div>
                    </div>


                    <script>
                        ( function( $ ) {
                            $(document).ready(function(){
                                $("#jquery_jplayer_<?php echo get_the_ID();?>").jPlayer({
                                    cssSelectorAncestor: "#jp_container_<?php echo get_the_ID();?>",
                                    play: function() { // To avoid both jPlayers playing together.
                                        $(this).jPlayer("pauseOthers");
                                    },
                                    ready: function (event) { $(this).jPlayer("setMedia", {
                                        mp3:"<?php echo $radio;?>"
                                    });
                                                            },
                                    swfPath: "<?php echo get_stylesheet_directory_uri(); ?>/js/jplayer",
                                    supplied: "mp3",
                                    wmode: "window"
                                });
                            })
                        } )( jQuery );
                    </script>
                    <?php
          }
}  ?>    


                </div>
                <div class="bl_tags"><em>Tagged:</em>  <?php echo get_the_tag_list('', ', ','');?> </div>
            </div>
            <div class="blClear"></div>
        </div>
        <!-- End bl_post -->  

        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'stmachine'; // required: replace example with your forum shortname
            var disqus_identifier = '<?php echo $post->post_type?>-<?php echo $post->post_name?>';

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>


        <?php
    endwhile;
            /*
                            <div class="bl_banner"><img src="/template/images/banner.jpg" /></div>
                            */
        ?>
    </div>
    <!-- End bl_left -->
    <div class="blClear"></div>
    <div class="bl_mech"></div>
</div>
<!-- End blBlog -->				

<?php get_footer();