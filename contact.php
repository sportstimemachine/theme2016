<?php
/*
Template Name: Contact
*/

get_header();

?>
<script>
	$(function() {
	   $('#contact_form').submit(function() {	
	   		$.post('/template/contact_submit.php',$(this).serialize());
		 $('.bl_form').html('<p style="font-size:16px;height:200px;text-align:center;">Thank you for your interest in The Sports Time Machine! If your message requires a reply, you will hear from us shortly. We thank you for your feedback and hope to hear from you again!</p>');
        return false;
      });

});</script>
                <!-- Begin blBody -->
                <div id="blBody">
                    <div id="blContact">
                    	<div class="bl_map" style="width:432px"></div>
                        <!--<ul>
                        	<li class="bl_ico_address">2209 Fulton Rd. NW<br/>Canton, OH 44709</li>
                            <li class="bl_ico_phone">Phone: 330-489-9999</li>   
                            <li class="bl_ico_fax">Fax: 330-489-9988</li>  
                            <li class="bl_ico_email">Email: <a href="mailto: contact@sportstimemachine.net">contact@sportstimemachine.net</a></li>                      
                        </ul>-->
                     <?php   if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content();?>
                        <?php endwhile; endif;?>
                        
                        
                        
                      <div class="bl_logo"></div>   
                  </div>
                </div>
                
                <!-- End blBody -->
<?
get_footer();
?>