<?php
$ancestors = get_post_ancestors($post->ID);
$parent = $ancestors[0];

if ( is_page() ){
	if( $parent) { //if its a CHILD page
		$parent = get_page($parent);
		$links = get_pages(array("child_of"=>$parent->ID,'sort_column'=>'menu_order'));
	} else { //if it's a PARENT page
		$parent = $post;
		$links = get_pages(array("child_of"=>get_the_ID(),'sort_column'=>'menu_order'));
	}
} else {
	$parent = get_page_by_path(str_replace('posts','',$post->post_type));
	$links = get_pages(array("child_of"=>$parent->ID, 'sort_column'=>'menu_order'));
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<link href="<?php bloginfo('template_url'); ?>/style.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_url'); ?>js/jquery.fancybox/jquery.fancybox.css"  rel="stylesheet" type="text/css"/>
<link rel="alternate" type="application/rss+xml" title="Stark Posts" href="http://sportstimemachine.net/feed/?post_type=1480whbcposts" />
<link rel="alternate" type="application/rss+xml" title="Summit Posts" href="http://sportstimemachine.net/feed/?post_type=1350warfposts" />

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.fancybox/jquery.fancybox.js"></script>
<script src="http://www.google.com/jsapi"></script>
	
<script>google.load("swfobject", "2.2");</script>
<script>
	$(document).ready(function(){
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = '<?php bloginfo('template_url'); ?>/images/buttons2.png';
        // Alternatively you could use:
        // (new Image()).src = this;
    });
}

		if($('#blContent').height() < 1350){
			$('#blContent').css('background-image','url(<?php bloginfo('template_url'); ?>/images/bg2_short.png)');
		}
		else{
			$('#blContent').css('background-image','url(<?php bloginfo('template_url'); ?>/images/bg2.png)');
		}		
		$('#blBody').append('<div id="bodyBottom"></div>');
		$('.modal').fancybox({
			'width' : 'auto',
			'height' : 'auto',
			'scrolling' : 'no'
		});
	})

</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30047922-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php wp_head(); ?>
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
                				<td><a class="stark_button <?=$header_stark;?>" href="<?php bloginfo('url'); ?>/stark-radio"><span>STARK</span></a></td>
                                <td style="font-size:20px; color:#ffffff;">|</td>
                                <td><a class="summit_button <?=$header_summit;?>" href="<?php bloginfo('url'); ?>/summit-radio"><span>SUMMIT</span></a></td>
                			</tr>
                		</table>
                	</div>
                    <div class="bl_header">
                    	<h1><a href="/"></a></h1>
                    	<?php
                    	if ( $post->post_name != 'terms-and-conditions-of-use-agreement' && $post->post_name != 'privacy-policy' && $post->post_name != 'rss-feeds' ){
                    	
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