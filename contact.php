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
        
        <?php if ( have_posts() ) : 
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif; ?>
        
        <div class="bl_logo"></div>   
    </div>
</div>

<!-- End blBody -->
<?php
get_footer();