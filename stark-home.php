<?php
/*
Template Name: Stark - Home
*/

get_header();
global $post;

?>

<!-- Begin blBlog -->
<div id="blBlog">
    
    <?php get_template_part('right_sidebar'); ?>
    
    <!-- Begin bl_left -->
    <div class="bl_left">
        
        <?php 
        
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        
        $args = array( 
            'post_status' => 'publish',
            'caller_get_posts' => 1,
            'post_type' => 'stark_radio',
            'posts_per_page' => 10,
            'paged' => $paged,
            'orderby' => 'post_date'
        );
        
        $radio_shows = new WP_Query( $args );
        
        // Pagination Fix
        global $wp_query;
        $temp_query = $wp_query;
        $wp_query = NULL;
        $wp_query = $radio_shows;
        
        if ( $radio_shows->have_posts() ) :
        
            $count = 1; // Not zero-indexing so that Sponsor Ads only show up after the first three using Modulus 
        
            // Used to ensure we grab enough Sponsors based on the number of Radio Shows
            $sponsors_count = round( count( $radio_shows->posts ) / 10 ) * 3;
        
            $args = array( 
                'post_type' => 'stark_sponsors',
                'post_status' => 'publish',
                'meta_key' => 'banner',
                'meta_compare' => '>',
                'meta_value' => '0',
                'numberposts' => $sponsors_count
            );
        
            $sponsors = get_posts( $args );
            shuffle( $sponsors );
            $sponsor_count = 0;
        
            while ( $radio_shows->have_posts() ) : $radio_shows->the_post();
        
                if ( $count % 3 == 0 ) : 
        
                    if ( $sponsors[$sponsor_count] ) : 
        
                        $random_sponsor_link = get_post_custom();
                        $banner = wp_get_attachment_image_src( get_post_meta( $sponsors[$sponsor_count]->ID, 'banner', true ), 'full', '' );
                    ?>
        
                        <div class="bl_post">
                            
                            <?php 
                            
                            $link = get_post_meta( $sponsors[$sponsor_count]->ID, 'link', true );
                            $has_http = preg_match_all( '/(http)?(s)?(:)?(\/\/)/i', $link, $matches );
                            if ( $has_http == 0 ) {
                                $link = '//' . $link;
                            }
                            
                            if ( $link !== '//' ) : ?>
                                <a target="_blank" href="<?php echo $link; ?>">
                                    <img src="<?php echo $banner[0]; ?>" height="90"/>
                                </a>
                            <?php else : ?>
                                <img src="<?php echo $banner[0]; ?>" height="90"/>
                            <?php endif; ?>
                            
                        </div>
        
                    <?php endif;
                        
                    $sponsor_count++;
        
                endif; ?>
        
                <!-- Begin bl_post -->
                <div class="bl_post">
                    
                    <div class="bl_left_side">
                        
                        <div class="bl_img"><?php echo get_avatar($post->post_author,50);?></div>
                        
                        <div class="bl_post_day"><b><?php echo date("j",strtotime($post->post_date))?></b><br/><?php echo date("M",strtotime($post->post_date))?></div>
                        
                        <div class="bl_post_comments"><a href="<?php echo the_permalink()?>#disqus_thread" data-disqus-identifier="<?php echo $post->post_type; ?>-<?php echo $post->post_name; ?>"></a></div>
                        
                    </div>
                    
                    <div class="bl_left_side2">
                        
                        <a href="<?php echo the_permalink()?>"><h4><?php the_title()?></h4></a>
                        <h5>By <?php the_author(); ?></h5>
                        
                        <div class="bl_post_text">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <?php if ( get_the_tag_list('', ', ','') !== '' ) : ?>
                            <div class="bl_tags"><em>Tagged:</em>  <?php echo get_the_tag_list('', ', ','');?> </div>
                        <?php endif; ?>
                        
                    </div>
                    
                    <div class="blClear"></div>
                    
                </div>
                <!-- End bl_post -->  
        
            <?php 
        
            $count++;
        
            endwhile;
        
            wp_reset_postdata();
        
        endif; ?>
        
        <div id="prev_next">								
            <div id="prev_link"><?php echo next_posts_link(''); ?></div>
            <div id="next_link"><?php echo previous_posts_link(''); ?></div>
        </div>
        
        <?php
        
            // Reset main query object after Pagination is done.
            $wp_query = NULL;
            $wp_query = $temp_query;
        
        ?>
        
    </div>
    <!-- End bl_left -->
    
    <div class="blClear"></div>
    <div class="bl_mech"></div>
    
</div>
<!-- End blBlog -->

<?php get_footer();