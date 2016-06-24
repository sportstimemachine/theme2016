<?php
/*
Template Name: Stark - Sponsors
*/
get_header();
$post_data = get_post($post->post_parent);
$parent = $post_data->post_name;
$side = $parent;
$parent = substr($parent,0,4);
$args = array( 'post_type' => 'stark_sponsors', 'post_status'=>'publish','numberposts'=>-1);

global $post;
$sponsors = new WP_Query( $args );

?>
<script>
    ( function( $ ) {

        $('.sponsor_form').submit(function() {	
            $.post('/template/sponsor_submit.php',$(this).serialize());
            $('.bl_form').html('<p style="font-size:16px;height:200px;text-align:center;">Thank you for your interest in sponsoring The Sports Time Machine! A member of our team will be in touch with you shortly to discuss the opportunities available.</p>');
            return false;
        });

    } )( jQuery );
</script>
<!-- Begin blBody -->
<div id="blBody">
    <div id="blSponsors">
        <h2></h2>
        <ul>

            <?php 
            
            $count = 0;
            
            if ( $sponsors->have_posts() ) : 
            
                while ( $sponsors->have_posts() ) : $sponsors->the_post();
            
                    $link = get_post_meta( get_the_ID(), 'link', true );
                    $has_http = preg_match_all( '/(http)?(s)?(:)?(\/\/)/i', $link, $matches );
                    if ( $has_http == 0 ) {
                        $link = '//' . $link;
                    }

                    $logo = wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'logo', true ), 'full', '' );
                    
                    if ( get_post_meta( get_the_ID(), 'coupon', true ) == '' && get_post_meta( get_the_ID(), 'coupon_active', true ) !== 'yes' ) : ?>
                
                        <li>
                            <a target="_blank" href="<?php echo $link; ?>">
                                <?php if ( $logo[0] !== '' ) : ?>
                                    <img src="<?php echo $logo[0]?>" width="122" height="105" />
                                <?php else : ?>
                                    <div style="background-color:#ffffff; color:#999999;border:1px #999999 solid;width:122px; height:105px;">
                                        <p style="font-size:16px;text-align:center;position:relative;top:30%;"><?php the_title(); ?></p>
                                    </div>
                                <?php endif; ?>
                        </li>
                            
                    <?php else : ?>
                            
                        <li>
                            <a class="sponsor" href="/<?php echo $side;?>/coupon?id=<?php the_ID(); ?>">
                                <img src="<?php echo $logo[0]?>" width="122" height="105" />
                            </a> 
                        </li>
            
                    <?php endif;
                                     
                    $count++;
                                     
                    if ( $count%5 == 0 ) : ?>
                        <div style="clear:both;"></div>
                    <?php endif;
                
                endwhile;
            
                wp_reset_postdata();
            
            endif; ?>

        </ul>
        
        <div class="blClear"></div>
        <div class="bl_form">
            <h5>Contact Us For Sponsorship Opportunities</h5>
            <form method="post" action="/template/sponsor_submit.php" class="sponsor_form">

                <table border="0" cellpadding="0" cellspacing="0">

                    <tr>
                        <td class="bl_title"><b>Name:</b></td>
                        <td><input class="bl_field required" id="name" name="name" type="text" style="width:320px;" /></td>
                    </tr>
                    <tr>
                        <td><b>Email Address:</b></td>
                        <td><input class="bl_field required" id="email" name="email" type="text" style="width:320px;" /></td>
                    </tr>
                    <tr>
                        <td><b>Message:</b></td>
                        <td>
                            <textarea style="width:320px;" id="msg" name="msg"></textarea>
                            <div class="bl_button"><input type="submit" /></div>
                            <div class="blClear"></div>
                        </td>
                    </tr>
                </table>
            </form>
        </div> 
        <div class="bl_logo"></div>   
    </div>
</div>
<!-- End blBody -->
<?php get_footer();