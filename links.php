<?php
/*
Template Name: Links
*/
get_header();
$post_data = get_post($post->post_parent);
 $parent = $post_data->post_name;
 $parent = substr($parent,0,4);
 $args = array( 'post_type' =>'1480-links', 'post_status'=>'publish');
 $links = get_posts( $args ); 
 $links = (array) $links;
 print_r($links);
?> 
 <!-- Begin blBody -->
                <div id="blBody">
                    <div id="blLinks">
                    	<h2>Recommended Links</h2>
                        <ul>
                        <? foreach($links as $link){
                        print_r($link);
                                    $link = get_post_custom($link->ID); ?>
                                    <li><a href="<?=$link['link'][0]?>">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                                    
                          <?
                           }
                           ?>
                        	<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a><br/>Fusce magna arcu, faucibus eu fringilla ut, venenatis ut eros Vivamus orci odio, blandit in facilisis sed, faucibus sagittis nisi Aliquam nunc arcu, sagittis vitae pellentesque</li>
                        </ul>
                        <div class="blClear"></div>
                    </div>
                </div>
                <!-- End blBody -->              
<?
get_footer();
?>                