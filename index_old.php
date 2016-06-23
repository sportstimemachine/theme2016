<?
/* 
Template Name: Home
*/

get_template_part('home_header');
$args1480 = array( 'post_type' => '1480-upcoming-show', 'post_status'=>'publish','post_limit'=>1,'orderby'=>'post_date','order'=>'ASC');
 $args1350 = array( 'post_type' => '1350-upcoming-show', 'post_status'=>'publish','post_limit'=>1, 'orderby'=>'post_date','order'=>'ASC');
 $upcoming1480 = get_posts( $args1480 ); 
 $upcoming_show1480 = (array) $upcoming1480[0];
$upcoming1350 = get_posts( $args1350 ); 
 $upcoming_show1350 = (array) $upcoming1350[0];


?>
                <!-- Begin blBody -->
                <div id="blBody">
                    <div id="blHome">
                    	<h2>Choose your local market below:</h2>
                        <!-- Begin bl_right -->
                        <div class="bl_right">
                        	<div class="bl_button"><a href="/1350warf"></a></div>
                            <div class="bl_radiologo"><a href="#"></a></div>
                            <!-- Begin bl_highlight -->
                            <div class="bl_highlight">
                            	<h3>On The Next Radio Show</h3>
                                <div class="bl_text" style="height: 130px; overflow: hidden;">
                                    <h4><span><a href="<?=$upcoming_show1350['guid']?>"><?=$upcoming_show1350['post_title'];?></a></span></h4>
                                    <p><?=$upcoming_show1350['post_content']?></p>
                                </div>
                                <div class="bl_logo_small"><img src="<?php bloginfo('template_url'); ?>/images/640_small.png" /></div>
                            </div>
                            <!-- End bl_highlight -->
                            <!-- Begin bl_box -->
                            <div class="bl_box">
                            	<h3>Latest Articles</h3>
                                <ul>
                           			<?   $args = array( 'post_type' => '1350warfposts', 'posts_per_page' => 2 );
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post(); 
									$content = get_the_content();
     							    $content = strip_tags($content);
									?>	
                                	<li>
                                    	 <div class="bl_text">
                                            <h4><a href="<?=the_permalink()?>"><?=the_title()?></a></h4>
                                            <p><?php strip_tags(the_excerpt());  ?></p>
                                            <p align="right"><a href="<?=the_permalink()?>">Read more</a></p>
                                        </div>
                                        <div class="bl_day">
                                        	<p><?=date("F",strtotime($post->post_date))?></p>
                                            <p><b><?=date("j",strtotime($post->post_date))?></b></p>
                                        </div>
                                        <div class="blClear"></div>
                                    </li>
                                    <?  endwhile;?>
                                 </ul>
                            </div>
                            <!-- End bl_box -->
                        </div>
                        <!-- End bl_right -->
                        <!-- Begin bl_left -->
                        <div class="bl_left">
                        	<div class="bl_button"><a href="/1480whbc"></a></div>
                            <div class="bl_newslogo"><a href="#"></a></div>
                            <!-- Begin bl_highlight -->
                            <div class="bl_highlight">
                            	<h3>On The Next Radio Show</h3>
                                <div class="bl_text" style="height: 130px; overflow: hidden;">
                                	<h4><span><?=$upcoming_show1480['post_title'];?></span></h4>
                                    <p><?=$upcoming_show1480['post_content']?></p>
                                </div>
                                <div class="bl_logo_small"><img src="<?php bloginfo('template_url'); ?>/images/news-talk-logo.png" /></div>
                            </div>
                            <!-- End bl_highlight -->
                            <!-- Begin bl_box -->
                            <div class="bl_box">
                            	<h3>Latest Articles</h3>
                                <ul>
                                 <?   $args = array( 'post_type' => '1480whbcposts', 'posts_per_page' => 2 );
							$loop = new WP_Query( $args );
							while ( $loop->have_posts() ) : $loop->the_post();
							$content = get_the_content();
     					    $content = strip_tags($content);
      ?>
                                	<li>
                                    	 <div class="bl_text">
                                            <h4><a href="<?=the_permalink()?>"><?=the_title()?></a></h4>
                                            <p><? the_excerpt()?></p>
                                            <p align="right"><a href="<?=the_permalink()?>">Read more</a></p>
                                        </div>
                                        <div class="bl_day">
                                        	<p><?=date("F",strtotime($post->post_date))?></p>
                                            <p><b><?=date("j",strtotime($post->post_date))?></b></p>
                                        </div>
                                        <div class="blClear"></div>
                                    </li>
                                    <? endwhile; ?> 
                                </ul>
                            </div>
                            <!-- End bl_box -->
                        </div>
                        <!-- End bl_left -->
                        <div class="blClear"></div>
                    </div>
                </div>
                <!-- End blBody -->
<?
get_footer();
?>               
