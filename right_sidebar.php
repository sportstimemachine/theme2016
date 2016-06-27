<?php
if ( strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], 'stark' ) >= 0 ) {
    $args = array( 'post_type' => 'stark_sponsors', 'post_status'=>'publish', 'numberposts' => 8);
}

if( strpos( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], 'summit' ) >= 0 ) {
    $args = array( 'post_type' => 'summit_sponsors', 'post_status'=>'publish','numberposts' => 8);
}

if ( strpos( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], '?s=' ) >= 0 ) {
    $args = array( 'post_type' => 'summit_sponsors', 'post_status'=>'publish','numberposts' => 8);
}

global $post;

$sponsors = new WP_Query( $args );
$slug = $post->post_name;
?>	

<div id="fb-root"></div>

<!-- Begin bl_right -->
<div class="bl_right">     
    <ul>
        <?php if ( $slug !== 'radio-show' ) : 
        
            dynamic_sidebar( 'right-sidebar' );
        
            ?>
        
            <li>
                <h3 class="box_header">Our Sponsors</h3>
                <div class="bl_box" style="margin:0;padding:5px;">
                    <ul style="margin:0;padding:0;display:inline;">
                        <?php 

                        if ( $sponsors->have_posts() ) : 

                            while ( $sponsors->have_posts() ) : $sponsors->the_post();
                        
                                $logo = wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'logo', true ), 'full', '' );
                                $link = get_post_meta( get_the_ID(), 'link', true );
                        
                                $has_http = preg_match_all( '/(http)?(s)?(:)?(\/\/)/i', $link, $matches );
                                if ( $has_http == 0 ) {
                                    $link = '//' . $link;
                                }

                                if ( get_post_meta( get_the_ID(), 'coupon', true ) == '' && get_post_meta( get_the_ID(), 'coupon_active', true ) !== 'yes' ) : ?>
                                    <li style="border:none;display:inline-block;margin:0;padding:4px 2px;">
                                        <a target="_blank" href="<?php echo $link?>" style="margin:0;padding:0px;">

                                            <img src="<?php echo $logo[0]?>" width="122" height="105"> 


                                        </a> 
                                    </li>
                                <?php else : ?>
                                    <li style="border:none;display:inline-block;padding:4px 2px;margin:0;">
                                        <a class="sponsor" cursor="pointer" href="<?php echo $post->post_name?>/coupon?id=<?php echo $id?>"><img src="<?php echo $logo[0]?>" width="122"></a>  
                                    </li>
                                <?php endif; 

                            endwhile;

                            wp_reset_postdata();

                        endif; ?>

                    </ul>
                </div>
            </li>
            <li>
                <h3 class="box_header">Newsletter Signup</h3>
                
                <div class="bl_box">
                    <!-- Begin MailChimp Signup Form -->
                    <style type="text/css">
                        #mce-EMAIL{color: #3d3d3d; font-style:italic; background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/search-field-bg.gif) repeat-x left top; height: 22px; padding: 2px 5px 0 5px; width:148px; border: none; border-left: 1px solid #FFF; border-top: 1px solid #FFF;}
                        #mc-embedded-subscribe{color:transparent;background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/submit.png) no-repeat; width: 67px; height: 25px; border:none;float: right;}
                    </style>
                    
                    <div id="mc_embed_signup">
                        <form action="http://sportstimemachine.us4.list-manage.com/subscribe/post?u=323531635e3b2122e47ba090e&amp;id=a48f0545b9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                            <input type="submit"  name="subscribe" id="mc-embedded-subscribe" >
                        </form>
                    </div>

                    <!--End mc_embed_signup-->
                </div>
            </li>

            <li>
                <h3 class="box_header">Facebook</h3>
                <div class="bl_box">
                    <div class="fb-like-box" style="background-color:#fff;" data-href="https://www.facebook.com/pages/Sports-Time-Machine/241806463316" data-width="245" data-height="342" data-show-faces="true" data-stream="false" data-header="false"></div>
                </div>
            </li>
            <li>
                <h3 class="box_header">Twitter</h3>
                <div class="bl_box">
                    <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
                    <script>
                        new TWTR.Widget({
                            version: 2,
                            type: 'profile',
                            rpp: 3,
                            interval: 30000,
                            width: 250,
                            height: 300,
                            theme: {
                                shell: {
                                    background: '#3e7286',
                                    color: '#ffffff'
                                },
                                tweets: {
                                    background: '#ffffff',
                                    color: '#333333',
                                    links: '#1b82a8'
                                }
                            },
                            features: {
                                scrollbar: false,
                                loop: false,
                                live: false,
                                behavior: 'all'
                            }
                        }).render().setUser('SportsTM').start();
                    </script>
                </div>
            </li>
            <li>
                <h3 class="box_header">Articles By Topic</h3>
                <div class="bl_box">

                    <?php 
                        $tags = get_tags();
                        $html = '<ul class="post_tags">';

                        foreach ($tags as $tag){
                            $tag_link = get_tag_link($tag->term_id);
                            $html .= "<li style='border:none;padding:0px;margin:10px 0;'><a style='color:#00b8fd;text-decoration:underline;font-size:12px;' href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                            $html .= "{$tag->name}</a></li>";
                        }

                        $html .= '</ul>';
                        echo $html; 
                    ?>

                </div>
            </li>
        
        <?php else : 
        
            dynamic_sidebar( 'radio-show-sidebar' ); 

        endif; ?>
        
    </ul>
</div>
<!-- End bl_right -->