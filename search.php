<?php
/**
*Template Name: Search
* The template for displaying Search Results pages.
*/

get_header();
?>			
<!-- Begin blBlog -->
<div id="blBlog">
    
    <?php get_template_part('right_sidebar'); ?>
    
    <!-- Begin bl_left -->
    <div class="bl_left">
        
        <h2 style="text-align: left; margin: 0px; margin-bottom: 25px; border-bottom: 1px solid #999;">Results for search: <?php echo $s; ?></h2>

        <?php while ( have_posts() ) : the_post(); ?>
        
            <!-- Begin bl_post -->
            <div class="bl_post">
                
                <div class="bl_left_side">

                    <div class="bl_img"><?php echo get_avatar($post->post_author,50);?></div>
                    <div class="bl_post_day"><b><?php echo date("j",strtotime($post->post_date))?></b><br/><?php echo date("M",strtotime($post->post_date))?></div>
                    <div class="bl_post_comments"><a href="<?php echo the_permalink()?>#disqus_thread" data-disqus-identifier="<?php echo $post->post_type?>-<?php echo $post->post_name?>"></a></div>
                    
                </div>
                
                <div class="bl_left_side2">
                    
                    <a href="<?php echo the_permalink()?>">
                        <h4><?php the_title();?></h4>
                    </a>
                    
                    <h5>By <?php the_author();?></h5>
                    
                    <div class="bl_post_text">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <?php
                    if ( get_the_tag_list('', ', ','') != '' ) { ?>
                        <div class="bl_tags"><em>Tagged:</em>  <?php echo get_the_tag_list('', ', ','');?> </div>
                    <?php } ?>
                    
                </div>
                
                <div class="blClear"></div>
                
            </div>
            <!-- End bl_post -->   
        
        <?php endwhile; 
        
        wp_reset_postdata(); ?>
        
        <div id="prev_next">
            <div id="next_link" id="prev_link"><?php previous_posts_link( '' ) ?></div>
            <div id="prev_link"><?php next_posts_link ('') ?></div>
        </div>
        
    </div>
    
    <!-- End bl_left -->
    <div class="blClear"></div>
    <div class="bl_mech"></div>
    
</div>
<!-- End blBlog -->				

<?php get_footer();
