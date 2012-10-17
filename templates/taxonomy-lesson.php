
<?php get_header(); // dump('', $wp_query); ?>

<?php include('banner-lesson.php') ?>

<div class="template-full-noborder">
    <div id="container">
        <div>
	    
	    <!-- Sidebar -->
	    <?php include('sidebar-lesson.php') ?>
	    <!-- End Sidebar -->
	    
	    <div class="innerpage-right3">
	    
		<!-- Search Filter -->
		<div id="search-filter-wrapper">
		   <div class="search-filter">
			   <div class="sf-row1">
			   <div class="sfr1-result"><strong>1-20</strong> of <span>112</span> <strong>Results</strong></div>
			   <div class="sfr1-compare">
				<div class="sfr1c-text"><strong>Compare</strong><br/><span>up to 3 items</span></div>
				<div class="sfr1c-box">&nbsp;</div>
				<div class="sfr1c-box">&nbsp;</div>
				<div class="sfr1c-box">&nbsp;</div>
				<div class="sfr1c-btn"><a href="#">Compare</a></div>
			   </div>
		       </div>
		       <div class="sf-row2">
			   <div class="sfr2-text">Sort by:</div>
			   <div class="sfr2-opt">
				<div class="sfr2o-list01"><a href="#">Rating</a></div>
				<div class="sfr2o-list02"><a href="#">Price (Low to High)</a></div>
				<div class="sfr2o-list03"><a href="#">Price (High to Low)</a></div>
				<div class="sfr2o-list04"><a href="#">Start Date</a></div>
				<div class="sfr2o-list05"><a href="#">Duration (Short to Long)</a></div>
			   </div>
		       </div>
		       <div class="sf-row3">
			   <div class="sfr3-text">Show:</div>
			   <div class="sfr3-show">
				<select class="sfr3s-select">
				    <option>10 Per Page</option>
				    <option>20 Per Page</option>
				    <option>50 Per Page</option>
				</select>
							   </div>
			   <div class="sfr3-page">
				<div class="sfr3p-next"><a href="#">Next</a></div>
				<div class="sfr3p-page">
				    <ul>
					<li>1</li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
				    </ul>
				</div>
				<div class="sfr3p-prev"><a href="#">Previous</a></div>
			   </div>
		       </div>
		   </div>
		</div>
		<!-- Search Filter End -->
	       
		<!-- lesson results -->
		<?php
		
		query_posts( array(
		    'taxonomy' => get_query_var( 'taxonomy' ) ,
		    'term'     => get_query_var( 'term' )
		));
		
		if( have_posts() ) :
		
		    while( have_posts() ) :
		    
			the_post();
			
			include( 'loop-lesson.php' );
		    
		    endwhile; // end loop
		
		endif;
		?>
	       <!-- lesson result end -->
	       
	       <!-- Search Filter -->
		<div id="search-filter-wrapper">
		   <div class="search-filter">
			   <div class="sf-row1">
			   <div class="sfr1-result"><strong>1-20</strong> of <span>112</span> <strong>Results</strong></div>
			   <div class="sfr1-compare">
				<div class="sfr1c-text"><strong>Compare</strong><br/><span>up to 3 items</span></div>
				<div class="sfr1c-box">&nbsp;</div>
				<div class="sfr1c-box">&nbsp;</div>
				<div class="sfr1c-box">&nbsp;</div>
				<div class="sfr1c-btn"><a href="#">Compare</a></div>
			   </div>
		       </div>
		       <div class="sf-row2">
			   <div class="sfr2-text">Sort by:</div>
			   <div class="sfr2-opt">
				<div class="sfr2o-list01"><a href="#">Rating</a></div>
				<div class="sfr2o-list02"><a href="#">Price (Low to High)</a></div>
				<div class="sfr2o-list03"><a href="#">Price (High to Low)</a></div>
				<div class="sfr2o-list04"><a href="#">Start Date</a></div>
				<div class="sfr2o-list05"><a href="#">Duration (Short to Long)</a></div>
			   </div>
		       </div>
		       <div class="sf-row3">
			   <div class="sfr3-text">Show:</div>
			   <div class="sfr3-show">
				<select class="sfr3s-select">
				    <option>10 Per Page</option>
				    <option>20 Per Page</option>
				    <option>50 Per Page</option>
				</select>
			    </div>
			   <div class="sfr3-page">
				<div class="sfr3p-next"><a href="#">Next</a></div>
				<div class="sfr3p-page">
				    <ul>
					<li>1</li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
				    </ul>
				</div>
				<div class="sfr3p-prev"><a href="#">Previous</a></div>
			   </div>
		       </div>
		   </div>
		</div>
		<!-- Search Filter End -->
	   </div>
    	</div>
    </div>
</div>

<?php get_footer() ?>