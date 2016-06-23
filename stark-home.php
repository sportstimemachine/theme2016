<?php
/*
Template Name: Stark - Home
*/
get_header();
$post_data = get_post($post->post_parent);
$parent = $post_data->post_name;
$parent = substr($parent,0,4);
$args = array( 'post_type' => 'stark_sponsors', 'post_status'=>'publish','meta_key'=>'banner','meta_compare'=>'>','meta_value'=>'0','numberposts'=>10);
$sponsors = (array) get_posts( $args ); 
shuffle($sponsors);
$sponsor_count = 0;

?>
				<!-- Begin blBlog -->
                    <div id="blBlog">
                    	<?php get_template_part('right_sidebar'); ?>
                        <!-- Begin bl_left -->
                        <div class="bl_left">
                        	<?php $count = 1;
                        	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        	$args = array( 
                        		'post_status'=>'publish',
                        		'caller_get_posts'=>1,
                        		//'post_type' => $post->post_name.'posts',
                        		'post_type' => 'stark_radio', 
//                        		'posts_per_page' => 4,
                        		'showposts'=>10,
                        		'paged'=>$paged,
                        		'orderby'=> 'post_date'
                        	);
							$loop = new WP_Query( $args );
							// globalize $wp_query
							global $wp_query;
							// copy $wp_query into a temporary variable
							$temp_wp_query = $wp_query;
							// nullify $wp_query
							$wp_query = null;
							// move $myquery into $wp_query
							$wp_query = $loop;
							while ( $loop->have_posts() ) : $loop->the_post();
							?>
							<?php $count++;
									if($count%3==0){
										if ( $sponsors[$sponsor_count] ){
											$random_sponsor_link = get_post_custom($sponsors[$sponsor_count]->ID);
											$banner = wp_get_attachment_image_src($random_sponsor_link['banner'][0], 'full', '');
											?>
											<div class="bl_post">
											<?php if($random_sponsor_link['link'][0] != ''){?>
												<a target="_blank" href="http://<?=$random_sponsor_link['link'][0]?>">
													<img src="<?=$banner[0]?>" height="90"/>
												</a>
											<?php } else{ ?>
												<img src="<?=$banner[0]?>" height="90"/>
										<?php	}?>
											</div>
											<?php 
										}
									$sponsor_count++;
								} ?>
	                        	<!-- Begin bl_post -->
	                            <div class="bl_post">
	                                <div class="bl_left_side">
	                                	<div class="bl_img"><?=get_avatar($post->post_author,50);?></div>
	                                    <div class="bl_post_day"><b><?=date("j",strtotime($post->post_date))?></b><br/><?=date("M",strtotime($post->post_date))?></div>
	                                    <div class="bl_post_comments"><a href="<?=the_permalink()?>#disqus_thread" data-disqus-identifier="<?=$post->post_type?>-<?=$post->post_name?>"></a></div>
	                                </div>
	                                <div class="bl_left_side2">
	                                	<a href="<?=the_permalink()?>"><h4><?php the_title()?></h4></a>
	                                    <h5>By <?php the_author();?></h5>
	                                    <div class="bl_post_text">
	                                    	<?php
	                                    	global $more;
	                                    	$more = 0;
											the_content('<div class="bl_read_more">Read the rest of this article</div>');
											?>
										</div>
										<?php
										if ( get_the_tag_list('', ', ','') != '' ){
											?><div class="bl_tags"><em>Tagged:</em>  <?=get_the_tag_list('', ', ','');?> </div><?php
										}
	                                    ?>
	                                </div>
	                                <div class="blClear"></div>
	                            </div>
	                            <!-- End bl_post -->  
	                           <?php
	                           endwhile;
	                        /*
                            <div class="bl_banner"><img src="/images/banner.jpg" /></div>
                            */
                            ?>
                            <div id="prev_next">								
								<div id="prev_link"><?=next_posts_link('') ?></div>
								<div id="next_link" id="prev_link"><?=previous_posts_link('') ?></div>
							</div>
                        </div>
                        <!-- End bl_left -->
                        <div class="blClear"></div>
                        <div class="bl_mech"></div>
                    </div>
                    <!-- End blBlog -->				
<?php get_footer(); ?> 