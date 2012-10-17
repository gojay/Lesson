<?php

query_posts( $args );

if( have_posts() ) :

    while( have_posts() ) :
    
	the_post();
	
	include( 'loop-lesson.php' );
    
    endwhile; // end loop

endif;
        
?>