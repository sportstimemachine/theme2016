<?php
/*
Template Name: Summit Sponsors
*/
get_header();
$post_data = get_post($post->post_parent);
 $parent = $post_data->post_name;
$side = $parent;
 $parent = substr($parent,0,4);
 $args = array( 'post_type' => 'summit_sponsors', 'post_status'=>'publish','numberposts'=>-1);
 $sponsors = get_posts( $args ); 
 $sponsors = (array) $sponsors;

?>
<script>
	$(function() {
	   $('.sponsor_form').submit(function() {	
	   		$.post('/template/sponsor_submit.php',$(this).serialize());
		 $('.bl_form').html('<p style="font-size:16px;height:200px;text-align:center;">Thank you for your interest in sponsoring The Sports Time Machine! A member of our team will be in touch with you shortly to discuss the opportunities available.</p>');
        return false;
      });

});
</script>
				<!-- Begin blBody -->
                <div id="blBody">
                    <div id="blSponsors">
                    	<h2></h2>
                        <ul>
                        
                        <?php 
                        $count= 0;
                        foreach($sponsors as $sponsor){
                        			$sponsor_array = (array) $sponsor;
                        			$id = $sponsor_array['ID'];
                                    $sponsor = get_post_custom($sponsor->ID);
               
                                    if(stripos($sponsor['link'][0],'http:') !== FALSE){
                                    	$link = $sponsor['link'][0];
                                    }else{
                                    	$link = 'http://'.$sponsor['link'][0].'';
                                    }

                                    $logo = wp_get_attachment_image_src($sponsor['logo'][0], 'full', '');
                                    
                                    if($sponsor['coupon'][0] == '' && $sponsor['coupon_active'][0] != 'yes'){?>
				                                   <li>
				                				 		<a target="_blank" href="<?=$link?>">
				  								 		<?php if($logo[0] != ''){?>
				  								 				<img src="<?=$logo[0]?>" width="122" height="105"></a> 
				  								 		<?php } else{ ?>
						  								 		<div style="background-color:#ffffff; color:#999999;border:1px #999999 solid;width:122px; height:105px;">
						  								 			<p style="font-size:16px;text-align:center;position:relative;top:30%;"><?=$sponsor_array['post_title']?></p>
						  								 		</div>
				  										<?php } ?>
				                                   </li>
				              <?php }else{?>
                                   <li>
  								 		<a class="sponsor" href="/<?=$side;?>/coupon?id=<?=$id?>"  >
  								 				<img src="<?=$logo[0]?>" width="122" height="105">
  								 		</a> 
                                   </li>
							<?php } ?>
                  <?php $count++; 
	                 	 if($count%5 == 0){
	                  	?>
	                  		<div style="clear:both;"></div>
	                  	<?php
	                 	 }
                   } ?>

                                            
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
<?php get_footer(); ?> 