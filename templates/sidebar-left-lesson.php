<?php
$terms['difficulty'] = get_terms( 'difficulty_taxonomy', array(
			    'orderby'    => 'count',
			    'order'	 => 'desc',
			    'hide_empty' => 0
		    ));

$terms['location']['all']   = get_terms( 'location_taxonomy', array( 'hide_empty' => 0 ));
$terms['location']['show']  = get_terms( 'location_taxonomy', array(
				'orderby'    => 'count',
				'order'	     => 'desc',
				'number'     => 10,
				'hide_empty' => 0
			    ));

$terms['type'] 	    = get_terms( 'type_taxonomy', array(
			'orderby'    => 'count',
			'order'	     => 'desc',
			'hide_empty' => 0
		    ));
?>

<div class="innerpage-left3">

    <!-- Archives -->	
    <div class="drawer-container">
	<div class="drawer" id="facet-REF_GOALS">
	    <div class="sidenav-lsn-wrapper">                    	
		<h3>
		<div class="indicator">
		    <div class="slsnwh-left">
			<div class="slsnwhl-top">refine by</div>
			<div class="slsnwhl-bottom">Month</div>
		    </div>
		    <div class="slsnwh-right"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/lesson-arrow-up.gif"></div>
		</div>
		</h3>
		<div class="slsnw-list" style="visibility: visible; display: block; height: auto;" data-start-shown="true"> 
		<ul>
		    <li><div><a href="#">January 2012</a></div><span>(88)</span></li>
		    <li><div><a href="#">February 2012</a></div><span>(12)</span></li>
		    <li><div><a href="#">March 2012</a></div><span>(8)</span></li>
		    <li><div><a href="#">April 2012</a></div><span>(15)</span></li>
		    <li><div><a href="#">May 2012</a></div><span>(3)</span></li>
		    <li><div><a href="#">June 2012</a></div><span>(502)</span></li>
		    <li><div><a href="#">July 2012</a></div><span>(120)</span></li>
		    <li><div><a href="#">August 2012</a></div><span>(38)</span></li>
		    <li><div><a href="#">September 2012</a></div><span>(0)</span></li>
		    <li><div><a href="#">October 2012</a></div><span>(9)</span></li>
		    <li><div><a href="#">November 2012</a></div><span>(35)</span></li>
		    <li style="border-bottom:none;"><div><a href="#">December 2012</a></div><span>(105)</span></li>
		</ul>
		</div>
	    </div>
	</div>
    </div>
    <!-- End Archives -->

    <!-- Difficulties -->			
    <div class="drawer-container">
        <div class="drawer" id="facet-REF_GOALS">
	    <div class="sidenav-lsn-wrapper">
		<h3>
		<div class="indicator">
		<div class="slsnw-header">
		    <div class="slsnwh-left">
			<div class="slsnwhl-top">refine by</div>
			<div class="slsnwhl-bottom">Difficulty</div>
		    </div>
		    <div class="slsnwh-right"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/lesson-arrow-up.gif"></div>
		</div>
		</div>
		</h3>
		<div class="slsnw-list" style="visibility: visible; display: block; height: auto;" data-start-shown="true">
		    <?php if( count( $terms['difficulty'] ) > 0 ) : ?>
		    <ul>
			<?php foreach( $terms['difficulty'] as $term ) : ?>
			<li>
			    <div>
				<a href="<?php echo get_term_link( $term->slug, $term->taxonomy ) ?>">
				    <?php echo $term->name ?>
				</a>
			    </div>
			    <span>(<?php echo $term->count ?>)</span>	
			</li>
			<?php endforeach ?>
		    </ul>
		    <?php endif; ?>
		</div>
	    </div>
        </div>
    </div>
    <!-- End Difficulties -->    
    
    <!-- Prices -->
    <div class="drawer-container">
        <div class="drawer" id="facet-REF_GOALS">
	<div class="sidenav-lsn-wrapper">
	    <h3>
		<div class="indicator">
		    <div class="slsnw-header">
			<div class="slsnwh-left">
			    <div class="slsnwhl-top">refine by</div>
			    <div class="slsnwhl-bottom">Price</div>
			</div>
			<div class="slsnwh-right"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/lesson-arrow-up.gif"></div>
		    </div>
		</div>
	    </h3>
	    <div class="slsnw-list" style="visibility: visible; display: block; height: auto;" data-start-shown="true"> 
		<div class="slsnw-slider">
		    <div class="slsnws-text">Drag sliders <br/>to filter results.</div>
		    <div id="slider-range" class="slsnws-slide"></div>
		    <div class="slsnws-result">
			<div class="slsnwsr-min"><input name="" type="text" value="$0" class="min-textarea"></div>
			<div class="slsnwsr-max"><input name="" type="text" value="$500" class="max-textarea"></div>
		    </div>
		</div>
	    </div>
	</div>
        </div>
    </div>
    <!-- End Prices -->
    
    <!-- Locations -->
    <div class="drawer-container">
        <div class="drawer" id="facet-REF_GOALS">
	    <div class="sidenav-lsn-wrapper">
		<h3>
		<div class="indicator">
		    <div class="slsnw-header">
			<div class="slsnwh-left">
			    <div class="slsnwhl-top">refine by</div>
			    <div class="slsnwhl-bottom">Location</div>
			</div>
			<div class="slsnwh-right"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/lesson-arrow-up.gif"></div>
		    </div>
		</div>
		</h3>
		<div class="slsnw-list" style="visibility: visible; display: block; height: auto;" data-start-shown="true">
		    <div class="slsnw-location"><input name="" type="text" class="loc-tfield"></div>
		    <div class="slsnw-or">or</div>
		    <div class="slsnw-list">
			<?php
			if( count($terms['location']['all']) > 0 ) :
			    $count_all_types  = count( $terms['location']['all'] );
			    $count_show_types = count( $terms['location']['show'] );
			?>
			<ul>
			    <?php foreach( $terms['location']['show'] as $term ) : ?>
			    <li>
				<div>
				    <a href="<?php echo get_term_link( $term->slug, $term->taxonomy ) ?>">
					<?php echo $term->name ?>
				    </a>
				</div>
				<span>(<?php echo $term->count ?>)</span>	
			    </li>
			    <?php endforeach ?>
			    
			    <?php if( $count_all_types > $count_show_types ) : $view_all_areas = true; ?>
				<li style="border-bottom:none; margin-top:5px;">
				    <div style="float:right;">
					<a href="#" id="view-all-location">View All Areas &raquo;</a>
				    </div>
				</li>
			    <?php
			    else :
				$view_all_areas = false;
			    endif; ?>
			</ul>
			<?php endif; ?>
			
		    </div>
		    
		    <!-- Popup View All Areas -->
		    <?php if( $view_all_areas ) : ?>		    
			<div class="lvaa-wrapper" style="display:none;">
			    <div class="lvaaw-header">Full Location List</div>
			    <div class="lvaaw-col">
				<ul>
				    <li><a href="#">North</a></li>
				    <li><a href="#">South</a></li>
				    <li><a href="#">East</a></li>
				    <li><a href="#">West</a></li>
				    <li><a href="#">Central</a></li>
				    <li><a href="#">Admiralty</a></li>
				    <li><a href="#">Alexandra</a></li>
				    <li><a href="#">Aljunied</a></li>
				    <li><a href="#">Ang Mo Kio</a></li>
				    <li><a href="#">Balestier</a></li>
				    <li><a href="#">Beach Road</a></li>
				    <li><a href="#">Bedok North</a></li>
				    <li><a href="#">Bedok Reservoir</a></li>
				    <li><a href="#">Bedok South</a></li>
				    <li><a href="#">Bendemeer</a></li>
				    <li><a href="#">Bishan</a></li>
				    <li><a href="#">Boon Lay</a></li>
				    <li><a href="#">Braddell</a></li>
				    <li><a href="#">Bugis</a></li>
				    <li><a href="#">Bukit Batok</a></li>
				    <li><a href="#">Bukit Merah</a></li>
				</ul>
			    </div>
			    <div class="lvaaw-col">
				<ul>
				    <li><a href="#">Bukit Panjang</a></li>
				    <li><a href="#">Bukit Timah</a></li>
				    <li><a href="#">Buona Vista</a></li>
				    <li><a href="#">Chai Chee</a></li>
				    <li><a href="#">Changi Village</a></li>
				    <li><a href="#">Choa Chu Kang</a></li>
				    <li><a href="#">Clarke Quay</a></li>
				    <li><a href="#">Clementi</a></li>
				    <li><a href="#">Commonwealth</a></li>
				    <li><a href="#">Defu Lane</a></li>
				    <li><a href="#">Dover</a></li>
				    <li><a href="#">Dunearn Road</a></li>
				    <li><a href="#">East Coast</a></li>
				    <li><a href="#">Eunos</a></li>
				    <li><a href="#">Farrer Park</a></li>
				    <li><a href="#">Geylang</a></li>
				    <li><a href="#">Geylang Bahru</a></li>
				    <li><a href="#">Harbourfront</a></li>
				    <li><a href="#">Henderson</a></li>
				    <li><a href="#">Holland</a></li>
				    <li><a href="#">Hougang</a></li>
				</ul>
			    </div>
			    <div class="lvaaw-col">
				<ul>
				    <li><a href="#">Jalan Ahmad Ibrahim</a></li>
				    <li><a href="#">Jalan Besar</a></li>
				    <li><a href="#">Joo Chiat</a></li>
				    <li><a href="#">Joo Koon Circle</a></li>
				    <li><a href="#">Jurong East</a></li>
				    <li><a href="#">Kaki Bukit</a></li>
				    <li><a href="#">Kallang</a></li>
				    <li><a href="#">Kallang Way</a></li>
				    <li><a href="#">Katong</a></li>
				    <li><a href="#">Keppel</a></li>
				    <li><a href="#">Kovan</a></li>
				    <li><a href="#">Kranji</a></li>
				    <li><a href="#">Lavender</a></li>
				    <li><a href="#">Leng Kee</a></li>
				    <li><a href="#">Little India</a></li>
				    <li><a href="#">Loyang</a></li>
				    <li><a href="#">Macpherson</a></li>
				    <li><a href="#">Mandai Road</a></li>
				    <li><a href="#">Marine Parade</a></li>
				    <li><a href="#">Marsiling Drive</a></li>
				    <li><a href="#">Newton</a></li>
				</ul>
			    </div>
			    <div class="lvaaw-col">
				<ul>
				    <li><a href="#">Novena</a></li>
				    <li><a href="#">Orchard</a></li>
				    <li><a href="#">Outram</a></li>
				    <li><a href="#">Pandan Valley</a></li>
				    <li><a href="#">Pasir Panjang</a></li>
				    <li><a href="#">Pasir Ris</a></li>
				    <li><a href="#">Paya Lebar</a></li>
				    <li><a href="#">Pioneer</a></li>
				    <li><a href="#">Ponggol</a></li>
				    <li><a href="#">Potong Pasir</a></li>
				    <li><a href="#">Queensway</a></li>
				    <li><a href="#">Raffles Place</a></li>
				    <li><a href="#">Redhill</a></li>
				    <li><a href="#">River Valley</a></li>
				    <li><a href="#">Selegie</a></li>
				    <li><a href="#">Seletar</a></li>
				    <li><a href="#">Sembawang</a></li>
				    <li><a href="#">Sengkang</a></li>
				    <li><a href="#">Serangoon Central</a></li>
				    <li><a href="#">Shenton Way</a></li>
				    <li><a href="#">Simei</a></li>
				</ul>
			    </div>
			    <div class="lvaaw-col">
				<ul>
				    <li><a href="#">Sin Ming</a></li>
				    <li><a href="#">Stevens Road</a></li>
				    <li><a href="#">Tampines</a></li>
				    <li><a href="#">Tanjong Pagar</a></li>
				    <li><a href="#">Telok Ayer</a></li>
				    <li><a href="#">Telok Blangah</a></li>
				    <li><a href="#">Tiong Bahru</a></li>
				    <li><a href="#">Toa Payoh</a></li>
				    <li><a href="#">Toh Guan</a></li>
				    <li><a href="#">Toh Tuck</a></li>
				    <li><a href="#">Tuas</a></li>
				    <li><a href="#">Ubi</a></li>
				    <li><a href="#">Upper Thomson</a></li>
				    <li><a href="#">West Coast</a></li>
				    <li><a href="#">Woodlands</a></li>
				    <li><a href="#">Yio Chu Kang</a></li>
				    <li><a href="#">Yishun</a></li>
				</ul>
			    </div>
			</div>
		    <?php endif; ?>		
		</div>
	    </div>
	</div>
    </div>
    <!-- End Locations -->
    
    <!-- Types -->
    <div class="drawer-container">
	<div class="drawer" id="facet-REF_GOALS">
	    <div class="sidenav-lsn-wrapper">
		<h3>
		    <div class="indicator">
			<div class="slsnw-header">
			    <div class="slsnwh-left">
				<div class="slsnwhl-top">refine by</div>
				<div class="slsnwhl-bottom">Type</div>
			    </div>
			    <div class="slsnwh-right"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/lesson-arrow-up.gif"></div>
			</div>
		    </div>
		</h3>
		<div class="slsnw-list" style="visibility: visible; display: block; height: auto;" data-start-shown="true"> 		    
		    <?php if( count( $terms['type'] ) > 0 ) : ?>
		    <ul>
			<?php foreach( $terms['type'] as $term ) : ?>
			<li>
			    <div>
				<a href="<?php echo get_term_link( $term->slug, $term->taxonomy ) ?>">
				    <?php echo $term->name ?>
				</a>
			    </div>
			    <span>(<?php echo $term->count ?>)</span>	
			</li>
			<?php endforeach ?>
		    </ul>
		    <?php endif; ?>
		</div>
    	    </div>
	</div>
    </div>
    <!-- End Types -->
    
    <script type="text/javascript"><!--
	jQuery(document).ready(function($) {
				
	    $(".drawer-container").drawerSet({'messaging': 'facetDrawerSet'});
	    
	    // $('.event-trigger').eventTrigger();
	    
	    $('a#view-all-location').live('click', function(){
		$('.lvaa-wrapper').toggle();
		return false;
	    });
	
	});
    --></script>
    
</div>