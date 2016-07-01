<?php 
/**
 * The template used to display Tag Archive pages
 */
?>
<?php get_header(); ?>
<div id="blBody">

    <?php
        $url = $_SERVER["REQUEST_URI"];
        $tokens = explode('/', $url);
        $tokens = $tokens[sizeof($tokens)-2];
    ?>
    
    <?php
    query_posts('post_type=stark_radio&tag='.$tokens.'');
    if ( have_posts() ) : ?>

    <header class="page-header">
        <h1 class="page-title"><?php
            printf( __( 'Tag Archives: %s', 'default' ), '<span>' . single_tag_title( '', false ) . '</span>' );
            ?></h1>

        <?php

        $tag_description = tag_description();
        echo $tag_description;
        if ( ! empty( $tag_description ) )
            echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
        ?>
    </header>



    <?php /* Start the Loop */ ?>
    <?php while ( have_posts() ) : the_post(); ?>

    <?php
    /* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
    ?>
    <div class="bl_post">
        <div class="bl_left_side">
            <div class="bl_img"><div class="bl_img"><?php echo get_avatar($post->post_author,50);?></div></div>
            <div class="bl_post_day"><b><?php echo date("j",strtotime($post->post_date))?></b><br/><?php echo date("F",strtotime($post->post_date))?></div>
            <div class="bl_post_comments"><a href="<?php echo the_permalink()?>#disqus_thread" data-disqus-identifier="<?php echo $post->post_type?>-<?php echo $post->post_name?>"></a></div>
        </div>
        <div class="bl_left_side2">
            <a href="<?php echo the_permalink()?>"><h4><?php echo the_title()?></h4></a>
            <h5>By <? the_author();?></h5>
            <div class="bl_post_text">
                <?php the_excerpt(); // end of the bl_post_text div in excerpt via functions.php ?>
            </div>
            <?php
            if ( get_the_tag_list('', ', ','') != '' ){
            ?><div class="bl_tags"><em>Tagged:</em>  <?php echo get_the_tag_list('', ', ','');?> </div><?php
            }
            ?>
        </div>
        <div class="blClear"></div>
    </div>
    <?
    get_template_part( 'content', get_post_format() );
    ?>

    <?php endwhile; ?>

    <?php else : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'default' ); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'default' ); ?></p>

        </div><!-- .entry-content -->
    </article><!-- #post-0 -->

    <?php endif; ?>

</div><!-- #content -->
</section><!-- #primary -->
</div>
<?php get_footer();