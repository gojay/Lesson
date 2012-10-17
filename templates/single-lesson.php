
<?php get_header();  ?>

<?php include('banner-lesson.php') ?>

<div class="left_section">
    <div id="container">
        <div class="tab_section content-template">
            <div class="lesson-details-title"><?php the_title(); ?></div>
	    <?php
	    $post_meta = get_post_meta( $post->ID );
	    
	    // term
	    $term = afr_ls_load_terms( $post->ID, 'difficulty_taxonomy' );   	
	    $level = array_pop( $term ); 
	    
	    // galleries	    
	    $galleries = unserialize( $post_meta['lesson-images'][0] );
	    
	    // school
	    $schollID 	 = $post_meta['lesson-school'][0];
	    $school      = get_post( $schollID );
	    $school_meta = get_post_meta( $schollID );
	    $school_map  = unserialize($school_meta['school-map'][0]);
	    $school_timing = afr_ls_school_time( $post_meta['lesson-time'][0] );
	    ?>
            <div id="lesson-details-details">
            	<div class="ldd-gallery">
                    <div class="lddg-showcase">
			<?php echo get_the_post_thumbnail( $post->ID ); ?>
		    </div>
		    <div class="lddg-thumb-wrapper">
                    <?php
		    /** Galleries **/
		    if( $galleries ){
			$i = 1; ?>
			<?php foreach( $galleries as $gallery ) :
			    $last = ($i % 5) == 0;
			    $wrap = ($i % 6) == 0;
			    if( $wrap ){
				echo '</div><div class="lddg-thumb-wrapper">';
			    }?>			    
			    
			    <div class="lddgtw-thumb<?php echo ( $last ) ? '-last' : '' ; ?>">
				<img src="<?php echo $gallery ?>" class="pointer"/>
			    </div>
			    
			    <?php $i++;
			endforeach;
			
			// set blank image
			$count = count($galleries) % 5;
			if( $count != 0 ){
			    $empty = 5 - $count;
			    for($im = 1; $im <= $empty; $im++) : ?>
				<div class="lddgtw-thumb<?php echo ( $im == $empty ) ? '-last' : '' ; ?>">
				    <img src="<?php echo get_template_directory_uri() ?>/images/lessons-gallery/thumb.gif "/>
				</div>	
			    <?php endfor;
			}
		    }
		    /** end Galleries **/
		    ?>
		    </div>
                </div>
                <div class="ldd-date">
                	<div class="lddd-text">
                    	<ul>
                            <li><strong>Date:</strong><?php echo date("l, j F Y", strtotime( $post_meta['lesson-date'][0] )); ?></li>
                            <li><strong>Timing:</strong> <?php echo $school_timing; ?></li>
                            <li>
				<strong>Price:</strong> $<?php echo $post_meta['lesson-price-amount'][0] ?> nett<br/>
				Limited to <?php echo $post_meta['lesson-price-tax'][0] ?> pax.<br/>
				<?php echo ( $post_meta['lesson-price-prepayment'][0]  == 'Y' ) ? 'Prepayment Required' : '' ; ?>
			    </li>
			    <li><strong>Level:</strong> <?php echo $level->name; ?></li>
                        </ul>
                    </div>
                    <div class="lddd-btn"><a href="#"><img src="<?php echo get_template_directory_uri() ?>/images/booknow-btn.gif" border="0"></a></div>
                </div>
		
		<script type="text/javascript">
		    jQuery(document).ready(function($) {
			
			var position = new google.maps.LatLng(
			    <?php echo $school_map['lat']; ?>,
			    <?php echo $school_map['lng']; ?>
			);
			
			$('#maps').gmap3(		
			    {
				action: 'addMarker',
				latLng: position,
				map:{
				    center: position,
				    zoom: 15
				}
			    }
			);
			$("#mapBox").dialog({
			    autoOpen: false,
			    width: 535,
			    height: 400,
			    //modal: true,    
			});
			$("a#popupmap").click(function(){
			    $( "#mapBox" ).dialog( "open" );
			    return false;
			});
		    });
		</script>
		
                <div class="ldd-overall-rating">
                	<div class="lddor-title">OVERALL RATING</div>
                    <div class="lddor-rate">
                    	<div class="lddorr-left">10</div>
                        <div class="lddorr-right">out of 10<br/><span>Excellent</span></div>
                    </div>
                    <div class="lddor-address">
                    	<ul>
                            <li><strong><?php echo $school->post_title ?></strong> </li>
                            <li><strong>Address:</strong> <?php echo $school_meta['school-address'][0] ?></li>
                            <li><strong>Tel:</strong> <?php echo $school_meta['school-telphone'][0] ?></li>
                            <li><strong>Fax:</strong> <?php echo $school_meta['school-fax'][0] ?></li>
                            <li>
				<div id="mapBox" title="Location <?php echo $school->post_title ?>">
				    <div id="maps" class="gmap3"></div>    
				</div>
				<a href="#mapBox" id="popupmap">How to get there?</a>
			    </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="lesson-details-header"><span>Details</span></div>
            <div class="lesson-details-content"><?php echo the_content() ?></div>
	    <div class="lesson-details-booknow">
		<a href="#"><img src="<?php echo get_template_directory_uri() ?>/images/booknow-btn.gif" border="0"></a>
	    </div>			
            
	    <?php include( 'review-lesson.php' ); ?>
	    
        </div>
    </div>
</div>

<?php include( 'sidebar-right-lesson.php' ); ?>

<?php get_footer() ?>