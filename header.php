<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
        <meta name="description" content="<?php bloginfo('description'); ?>" />
        
        <?php 
        
        wp_head();
        
        if ( is_front_page() ) : ?>
        
    </head>

    <body>
        <!-- Begin blContent -->
        <div id="blContent">
            <!-- Begin blContext -->
            <div id="blContext">
                <!-- Begin blHeader -->
                <div id="blHeader">
                    <div class="bl_home_header"></div>
                    <div class="bl_home_header2"></div>
                </div>
                <!-- End blHeader -->
        
        <?php else : ?>
                
        <script type="text/javascript">
            google.load("swfobject", "2.2");
        </script>
                
    </head>

    <body>


        <!-- Begin blContent -->
        <div id="blContent">
            <!-- Begin blContext -->
            <div id="blContext">
                <!-- Begin blHeader -->
                <div id="blHeader">
                    <div style="position:absolute;left:50%;top:180px;">
                        <?php $post_data = get_post($post->post_parent);
                        $post_data = (array) $post_data;
                        $url = get_permalink( $post->ID ); 
                        $url1350= strpos($url,'1350');
                        $url1480 = strpos($url,'1480');
                        ?>
                        <table>
                            <tr>
                                <?php if(strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],'stark') !== FALSE){ 
    $header_stark = 'stark_active';
} elseif(strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],'summit') !== FALSE){
    $header_summit = 'summit_active';
}
                                ?>
                                <td><a class="stark_button <?php echo $header_stark;?>" href="<?php bloginfo('url'); ?>/stark-radio"><span>STARK</span></a></td>
                                <td style="font-size:20px; color:#ffffff;">|</td>
                                <td><a class="summit_button <?php echo $header_summit;?>" href="<?php bloginfo('url'); ?>/summit-radio"><span>SUMMIT</span></a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="bl_header">
                        <h1><a href="/"></a></h1>
                        <?php
                        if ( $post->post_name !== 'terms-and-conditions-of-use-agreement' && $post->post_name !== 'privacy-policy' && $post->post_name !== 'rss-feeds' ){

                        ?>
                        <div class="bl_search">
                            <?php
                            $exp_uri = explode("/",$_SERVER['REQUEST_URI']);
                            $station = str_replace('posts','',$exp_uri[1]);
                            ?>

                            <form action="<?php bloginfo('home'); ?>" id="SearchForm" method="get">
                                <div class="bl_fied"><input class="bl_field" type="text" name="s" id="SearchInput" value="<?php echo $_GET['s']; ?>" /></div>
                                <div class="bl_buttons"><input type="submit" id="SearchSubmit" class="noStyle" value="" /></div>
                            </form>
                        </div>

                        <!-- Start Menu -->
                        <?php if(strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],'stark') !== FALSE){ 
                                wp_nav_menu( array( 'sort_column' => 'menu_order', 
                                                   'menu_class' => 'bl_active', 
                                                   'link_before'     => '<span>',
                                                   'link_after'      => '</span>', 
                                                   'menu'         => 'Stark Main Menu',) );                         
                            }
                            elseif(strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],'summit') !== FALSE){
                                wp_nav_menu( array( 'sort_column' => 'menu_order', 
                                                   'menu_class' => 'bl_active', 
                                                   'link_before'     => '<span>',
                                                   'link_after'      => '</span>', 
                                                   'menu'         => 'Summit Main Menu') );
                            }
                            elseif(strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],'s') !== FALSE){
                                wp_nav_menu( array( 'sort_column' => 'menu_order', 
                                                   'menu_class' => 'bl_active', 
                                                   'link_before'     => '<span>',
                                                   'link_after'      => '</span>', 
                                                   'menu'         => 'Summit Main Menu') );                          
                            }                           ?>
                        <div class="blClear"></div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- End blHeader -->
                
        <?php endif; ?>