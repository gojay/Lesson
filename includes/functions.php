<?php
/**
 * filter excerpt length
 */
function afr_ls_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'afr_ls_excerpt_length', 999 );


/**
 * load term by taxonomy
 */
function afr_ls_load_terms( $post_id, $taxonomy )
{
    global $wpdb;
    
    $query = $wpdb->prepare("
	    SELECT DISTINCT term.name
	    FROM {$wpdb->terms} term
	    INNER JOIN
		{$wpdb->term_taxonomy} tax
		ON
		term.term_id = tax.term_id
	    INNER JOIN
		{$wpdb->term_relationships} relationship
		ON
		relationship.term_taxonomy_id = tax.term_taxonomy_id
	    INNER JOIN
		{$wpdb->posts} p
		ON
		p.ID = relationship.object_id
	    WHERE
		p.ID = '%d' AND
		tax.taxonomy = '%s'", $post_id, $taxonomy );
	    
    $result =  $wpdb->get_results( $query, OBJECT );
    return $result;                 
}

/**
 * get time school
 */
function afr_ls_school_time( $lesson_time )
{
    $time = unserialize( $lesson_time );
    $st = $time['start'];
    $en = $time['end'];
    
    $start_time = $st['hour'] . '.' . $st['minute'] . $st['time'];
    $end_time   = $en['hour'] . '.' . $en['minute'] . $en['time'];
    $school_timing = $start_time . ' - ' . $end_time;
    
    return $school_timing;
}

