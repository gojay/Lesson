<?php
    
    $meta = get_post_meta( $post->ID );
    
    // $terms = wp_get_post_terms( $post->ID, 'difficulty_taxonomy' );
    $terms = afr_ls_load_terms( $post->ID, 'difficulty_taxonomy' );   
	
    $level = array_pop( $terms );
    
    $schollID 	 = $meta['lesson-school'][0];
    $school      = get_post( $schollID );
    $school_meta = get_post_meta( $schollID );
    
    $school_rate_vote  = intval( get_post_meta( $schollID, 'school-vote', true ) );
    $school_rate_count = intval( get_post_meta( $schollID, 'school-count', true ) );
    $school_rating = ( $school_rate_vote > 0 ) ? round($school_rate_vote/$school_rate_count) : 0 ;
    
    $school_timing = afr_ls_school_time( $meta['lesson-time'][0] );
    
    //dump('',$school_meta);
    
?>
    
    <div id="lesson-<?php echo $post->ID ?>" class="lesson-result-wrapper school-<?php echo $schollID ?>">
	<div class="lrw-left">
	    <div class="lrwl-image">
		<?php
		if( $isAjax ){
		    $img_url = wp_get_attachment_image_src( $meta['_thumbnail_id'][0], array(140,85) );
		    ?>
		    
		    <img src="<?php echo $img_url[0] ?>" width="<?php echo $img_url[1] ?>" height="<?php echo $img_url[2] ?>" />
		    
		    <?php
		} else {
		    echo get_the_post_thumbnail( $post->ID, array(140,85) );
		}
		?>
	    </div>
	    <div class="lrwl-compare">
		<div class="comp-check">
		    <input class="compare-lesson" name="compare[]" type="checkbox" value="<?php echo $post->ID ?>">
		</div>
		<div class="comp-text">Compare</div>
	    </div>
	</div>
	<div class="lrw-center">
	    <div class="lrwc-title">
		<a href="<?php echo get_permalink() ?>"><?php the_title() ?></a>
	    </div>
	    <div class="lrwc-by">
		<span>By</span>
		<?php echo $school->post_title ?>
	    </div>
	    <div class="lrwc-desc">
		<?php the_excerpt() ?>
	    </div>
	    <div class="lrwc-rate">
		<div class="lrwcr-box">9</div>
		<div class="lrwcr-text">out of 10</div>
		<div class="lrwcr-equivalent">Excellent</div>
		<div class="lrwcr-ratethis"><a href="#">Rate this</a></div>
		<div class="lrwcr-rating" id="<?php echo $school_rating ?>_<?php echo $schollID ?>" data-parameter="lesson-<?php echo $post->ID ?>"></div>
	    </div>
	</div>
	<div class="lrw-right">
	    <div class="lrwr-price">
		$<?php echo $meta['lesson-price-amount'][0] ?><br/>
	    </div>
	    <div class="lrwr-details">
		<?php echo date("j F Y", strtotime( $meta['lesson-date'][0] )); ?><br/>
		<?php echo $school_timing ?><br/>
		<?php echo $level->name ?><br/>
	    </div>
	    <div class="lrwr-open">OPEN</div>
	</div>
    </div>