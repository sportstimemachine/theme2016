<?php
/*
Template Name: Station Content
*/
get_header();

?>
				<!-- begin blBody -->
                <div id="blBody">
                	<div id="bodyContent">
						<?php if ( have_posts() ) while ( have_posts() ) : the_post(); //wordpress loop ?>
		                	<?php the_content(); ?>
	                	<?php endwhile ?>
                	</div>
                </div>
                <!-- end blBody -->
<?php get_footer(); ?> 
