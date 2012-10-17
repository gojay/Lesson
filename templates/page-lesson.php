
<?php get_header(); //dump('', $wp_query) ;?>

<?php include('banner-lesson.php') ?>

<div class="template-full-noborder">
    <div id="container">
        <div>
	    <div class="serverResponse">
		Server response :
		<p></p>
	    </div>
	    <!-- Sidebar -->
	    <?php include('sidebar-left-lesson.php') ?>
	    <!-- End Sidebar -->
	    
	    <div class="innerpage-right3">
		<form id="formLesson" action="<?php echo get_bloginfo('url') ?>/lesson/compare" method="POST">
	    
		<!-- Search Filter Top -->
		<?php include( 'searchform-lesson.php' ); ?>
		<!-- Search Filter End -->
		
		<div id="ajax-loader"></div>
		
		<!-- lesson results -->	       
		<div id="lesson-results">
		
		<?php	
		
		$args = array(
		    'post_type'   => 'lesson',
		    'post_status' => array( 'publish', 'draft' )
		);
		
		query_posts( $args );		
		
		if( have_posts() ) :
		
		    while( have_posts() ) :
		    
			the_post();
			
			include( 'loop-lesson.php' );
		    
		    endwhile; // end loop
		
		endif;
		
		?>
		</div>
		<!-- lesson result end -->
	       
		<!-- Search Filter Bottom -->
		<?php include( 'searchform-lesson.php' ); ?>
		<!-- Search Filter End -->
		</form>
	   </div>
    	</div>
    </div>
</div>

<?php get_footer() ?>