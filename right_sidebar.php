<?php $slug = $post->post_name; ?>

<!-- Begin bl_right -->
<div class="bl_right">     
    <ul>
        
        <?php if ( $slug !== 'radio-show' ) : 
        
            dynamic_sidebar( 'right-sidebar' );
        
        else : 
        
            dynamic_sidebar( 'radio-show-sidebar' ); 

        endif; ?>
        
    </ul>
</div>
<!-- End bl_right -->