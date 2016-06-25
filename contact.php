<?php
/*
Template Name: Contact
*/

get_header();

?>

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
<?php
get_footer();