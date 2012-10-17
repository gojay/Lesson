<?php
/**
 * Lesson
 * Main Class
 * 
 */

class AFRLesson
{
    const LESSON = 'lesson';
    const SCHOOL = 'school';
    
    /** default map coordinates */    
    const LAT = 1.3517397728121416;
    const LNG = 103.81992183068849;
    
    const PREFIX_LS_FIELD = 'lesson-';
    const PREFIX_SC_FIELD = 'school-';
    
    const NONCE_META_BOX_FIELD = 'lesson-meta-box';
    const NONCE_AJAX = 'ajax-lesson';
    
    public function __construct()
    {
	// register post type
        add_action( 'init', array( &$this, 'register_post_type' ) );
	// register taxonomy
	add_action( 'init', array( &$this, 'register_taxonomy' ) );
	// register taxonomy
	add_action( 'init', array( &$this, 'add_rewrite_compare' ) );
	
	// admin menu
	add_action( 'admin_menu', array( &$this, 'add_menu_lesson' ) );
	// add map scripts
	// add_action( 'admin_head', array( &$this, 'init_gmap' ) );
	// add meta box
	add_action( 'add_meta_boxes', array( &$this, 'add_meta_box' ) );
	// save meta box
	add_action( 'save_post', array( $this, 'save_meta_box' ) );
	
	// template redirect
	add_action( 'template_redirect', array( &$this, 'template_redirect' ) );
	
	// admin print scripts
	add_action( 'admin_print_scripts-post.php', array(&$this, 'backend_scripts') );
	add_action( 'admin_print_scripts-post-new.php', array(&$this, 'backend_scripts') );
	// register scripts
	add_action( 'wp_enqueue_scripts', array(&$this, 'frontend_scripts') );
	add_action( 'wp_head', array(&$this, 'head_scripts') );
	
	// setting AJAX in Plugins
	add_action( 'wp_ajax_nopriv_AFR-ls-ajax-sorting', array(&$this, 'ajax_sorting') );
	add_action( 'wp_ajax_AFR-ls-ajax-sorting', array(&$this, 'ajax_sorting') );
	
	add_action( 'wp_ajax_nopriv_AFR-ls-ajax-rating', array(&$this, 'ajax_rating') );
	add_action( 'wp_ajax_AFR-ls-ajax-rating', array(&$this, 'ajax_rating') );
    }
    
    /**
     *
     * Activation Hook
     *
     */
    public function install()
    {
	global $wpdb;
	
	if( !get_page_by_title('Lesson') )
	{
	    $wpdb->insert( $wpdb->posts, array(
		'post_title' => 'Lesson',
		'post_name'  => 'lesson',
		'post_type'  => 'page',
		'post_status'=> 'publish'
	    ));
	}
    }
    
    /**
     *
     * Uninstall Hook
     *
     */
    public function uninstall()
    {
	
    }
    
    /**
     *
     * Register Post Type
     * 
     */
    public function register_post_type()
    {
	register_post_type(
	    'lesson', 
	    array(
		'labels' => array(
		    'name' => 'Lessons',
		    'singular_name' => 'All Lessons',
		    'add_new' => 'Add Lesson',
		    'add_new_item' => 'Add New Lesson',
		    'edit_item' => 'Edit Lesson',
		    'new_item' => 'New Lesson',
		    'view_item' => 'View Lesson',
		    'search_items' => 'Search Lessons',
		    'not_found' => 'No lessons found',
		    'not_found_in_trash' => 'No lessons found in Trash'
		),
		'hierarchical'	=> false,
		'public'	=> true,
		'has_archive'	=> true,
		'rewrite'	=> true,
		'supports'	=> array( 'title', 'editor', 'thumbnail' )
	    )
	);
	
	register_post_type(
	    'school', 
	    array(
		'labels' => array(
		    'name' => 'Schools',
		    'singular_name' => 'Schools',
		    'add_new' => 'Add New',
		    'add_new_item' => 'Add New School',
		    'edit_item' => 'Edit School',
		    'new_item' => 'New School',
		    'view_item' => 'View School',
		    'search_items' => 'Search Schools',
		    'not_found' => 'No school found',
		    'not_found_in_trash' => 'No schools found in Trash'
		),
		'public'	=> true,
		'show_in_menu'  => 'edit.php?post_type=lesson',
		'supports' 	=> array( 'title' )
	    )
	);  
    }
    
    /**
     *
     * Register Taxonomy
     * 
     */
    public function register_taxonomy()
    {
	// Type
	register_taxonomy(
	    'type_taxonomy',
	    'lesson',
	    array(
		'hierarchical' 	=> true,
		'label' 	=> 'Type',
		'query_var'	=> true,
		'rewrite'	=> array( 'slug' => 'lesson/refine/type' )
	    )
	);
	
	// Difficulty
	register_taxonomy(
	    'difficulty_taxonomy',
	    'lesson',
	    array(
		'hierarchical' 	=> true,
		'label' 	=> 'Difficulty',
		'query_var'	=> true,
		'rewrite'	=> array( 'slug' => 'lesson/refine/difficulty' )
	    )
	);
	
	// Location
	register_taxonomy(
	    'location_taxonomy',
	    'lesson',
	    array(
		'hierarchical' 	=> false,
		'label' 	=> 'Location',
		'query_var'	=> true,
		'rewrite'	=> array( 'slug' => 'lesson/refine/location' )
	    )
	);
    }
    
    /**
     *
     * Add meta box
     *
     */
    public function add_meta_box()
    {
	add_meta_box(
	    'lesson-meta',
	    'Description',
	    array( &$this, 'lesson_meta_box' ),
	    'lesson',
	    'normal',
	    'low'
	);
	
	add_meta_box(
	    'school-meta',
	    'Description',
	    array( &$this, 'school_meta_box' ),
	    'school',
	    'normal',
	    'low'
	);
    }
    
    /**
     *
     * add school in lesson menu
     *
     */
    public function add_menu_lesson()
    {
	global $menu, $submenu;
	
	$submenu['edit.php?post_type=lesson'][] = array(
		0   => 'Add Scholl',
		1   => 'edit_posts',
		2   => 'post-new.php?post_type=school'
	);
    }
    
    /** ============================================ ADMIN ============================================ */
    
    /**
     * define meta fields
     * 
     * Lesson
     * 	date
     * 	price
	    limit
	    Prepayment yes/no
     * 
     * School/Company
     * 	address
     * 	telphon
     * 	fax
     *
     * @return Array
     */
    private function _meta_fields()
    {
	return array(
	    'lesson' => array(
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'school',
		    'label'		=> 'School/Company',
		    'placeholder'	=> 'Enter the school/company',
		    'type'		=> 'school',
		    'size'		=> 30
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'date',
		    'label'		=> 'Date',
		    'placeholder'	=> 'Enter the date',
		    'type'		=> 'date',
		    'size'		=> 30
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'time',
		    'label'		=> 'Time',
		    'placeholder'	=> 'Enter the date',
		    'type'		=> 'time',
		    'size'		=> 30
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'duration',
		    'label'		=> 'Duration',
		    'description'	=> 'Enter the timing duration in minutes',
		    'type'		=> 'text-description',
		    'size'		=> 30
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'price-amount',
		    'label'		=> 'Price',
		    'placeholder'	=> 'Enter the price',
		    'type'		=> 'number',
		    'size'		=> 10
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'price-tax',
		    'label'		=> 'Price Limit Tax',
		    'placeholder'	=> 'Enter the limited price',
		    'type'		=> 'number',
		    'size'		=> 2
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'price-prepayment',
		    'label'		=> 'Price Prepayment',
		    'placeholder'	=> 'Prepayment is required ?',
		    'type'		=> 'radio',
		    'values'		=> array(
					    'Yes' => 'Y',
					    'No'  => 'N'
					)
		),
		array(
		    'id'		=> self::PREFIX_LS_FIELD . 'images',
		    'label'		=> 'More Images (optional)',
		    'description'	=> 'Add images/photos from URL',
		    'type'		=> 'repeatable'
		)
	    ),
	    'school' => array(
		array(
		    'id'		=> self::PREFIX_SC_FIELD . 'address',
		    'label'		=> 'Address',
		    'placeholder'	=> 'Enter the address',
		    'type'		=> 'text',
		    'size'		=> 100
		),
		array(
		    'id'		=> self::PREFIX_SC_FIELD . 'telphone',
		    'label'		=> 'Telphone',
		    'placeholder'	=> 'Enter the telphone number',
		    'type'		=> 'text',
		    'size'		=> 30
		),
		array(
		    'id'		=> self::PREFIX_SC_FIELD . 'fax',
		    'label'		=> 'Fax',
		    'placeholder'	=> 'Enter the fax number',
		    'type'		=> 'text',
		    'size'		=> 30
		),
		array(
		    'id'		=> self::PREFIX_SC_FIELD . 'map',
		    'label'		=> 'Address',
		    'description'	=> 'Enter a physical location to display it on a map',
		    'type'		=> 'maps',
		    'size'		=> 85
		)
	    )
	);
    }
    
    /**
     *
     * Lesson Form meta box
     *
     */
    public function lesson_meta_box()
    {
	global $wpdb, $post;
	
	// create nonce field
	// see more documentaion at http://codex.wordpress.org/Function_Reference/wp_nonce_field
	wp_nonce_field( basename( __FILE__ ), self::NONCE_META_BOX_FIELD );
	
	$fields = $this->_meta_fields();
	?>
	<!-- table -->
	<table class="form-table">
	    <?php 
	    foreach( $fields['lesson'] as $field ) :
		// get post meta
		$post_meta = get_post_meta( $post->ID, $field['id'], true ); // dump('', $post_meta); ?>
		<tr>
		    <th>
			<label for="<?php echo $field['id'] ?>"><?php echo $field['label'] ?></label>
			<?php if( $field['description'] ) : ?>
			    <div class="description" style="margin-top:10px; font-style:italic;">
				<?php echo $field['description'] ?>
			    </div>
			<?php endif; ?>
		    </th>
		    <td>
		    <?php
		    // create field
		    switch( $field['type'] ) : 
			    
			case 'date'  :
			case 'number':
			case 'text'  : ?>
			    
			    <input type="<?php echo $field['type'] ?>" id="<?php echo $field['id'] ?>"
				   size="<?php echo $field['size'] ?>" placeholder="<?php echo $field['placeholder'] ?>"
				   name="<?php echo $field['id'] ?>" value="<?php echo $post_meta ?>" />
			    
			<?php break;
			
			case 'text-description'  : ?>
			    
			    <input type="text" id="<?php echo $field['id'] ?>"
				   size="<?php echo $field['size'] ?>" placeholder="<?php echo $field['placeholder'] ?>"
				   name="<?php echo $field['id'] ?>" value="<?php echo $post_meta ?>" />
			    <span class="description"></span>
			    
			<?php break;
			
			case 'school': ?>
			    <select name="<?php echo $field['id'] ?>" id="<?php echo $field['id'] ?>">
			    	<option value="0">-- Select school --</option>
			    <?php			    
			    $query = $wpdb->prepare("SELECT p.ID, p.post_title FROM $wpdb->posts p WHERE p.post_type='school' AND p.post_status = 'publish'" );
			    $schools = $wpdb->get_results( $query );
			    if( $schools ){
				foreach( $schools as $school ) : ?>
				    <option value="<?php echo $school->ID ?>" <?php echo ( $post_meta == $school->ID ) ? 'selected="selected"' : ''; ?>>
					<?php echo $school->post_title ?>
				    </option>
				<?php
				endforeach;
			    }			    
			    break;
			
			case 'time': 
			    $timing = array(
				'start' => array(
				    'msg' => 'Start Time',
				    'data' => array(
					'hour' 	  => ( $post_meta ) ? $post_meta['start']['hour'] : '' ,
					'minute'  => ( $post_meta ) ? $post_meta['start']['minute'] : '' ,
					'time' 	  => ( $post_meta ) ? $post_meta['start']['time'] : '' 
				    )
				),
				'end' => array(
				    'msg' => 'End Time',
				    'data' => array(
					'hour' 	  => ( $post_meta ) ? $post_meta['end']['hour'] : '' ,
					'minute'  => ( $post_meta ) ? $post_meta['end']['minute'] : '' ,
					'time' 	  => ( $post_meta ) ? $post_meta['end']['time'] : '' 
				    )
				) 
			    );
			    
			    foreach( $timing as $k => $time ) : ?>
				<div class="description" style="margin:5px 0; font-style:italic;">
				    <?php echo $time['msg'] ?>
				</div>
				<?php foreach( $time['data'] as $type => $value ) : ?>
				    
				    <?php if( $type == 'time' ): ?>
					<select id="timing-<?php echo $k . '-' . $type ; ?>" name="<?php echo $field['id'].'['.$k.']['.$type.']'; ?>">
					    <option value="am" <?php echo ( 'am' == $value ) ? 'selected' : '' ; ?>>AM</option>
					    <option value="pm" <?php echo ( 'pm' == $value ) ? 'selected' : '' ; ?>>PM</option>
					</select>
				    <?php else : $max = ( $type == 'hour' ) ? 12 : 59 ; ?>
					<input type="number" id="timing-<?php echo $k . '-' . $type ; ?>"
						max="<?php echo $max ?>" placeholder="<?php echo $type ?>" style="width:55px"
						name="<?php echo $field['id'].'['.$k.']['.$type.']'; ?>" value="<?php echo $value ?>" />
				    <?php endif;
				    
				endforeach;
				echo '<br/>';
			    endforeach;
			    
			    break;
			
			case 'radio' :
			
			    foreach( $field['values'] as $k => $v ) : ?>			    
			    
				<input type="radio" id="<?php echo $field['id'] ?>"
				       name="<?php echo $field['id'] ?>" value="<?php echo $v ?>"
				       <?php if( $post_meta == $v ) echo 'checked';  ?> /> <?php echo $k ?>
			    
			    <?php endforeach;
			    
			    break;
			
			case 'repeatable' : // repeatable/multiple input text ?>
			    
			    <a class="repeatable-add2 button" href="#">+</a>
			    <ul id="<?php echo $field['id'] ?>'-repeatable" class="custom_repeatable" style="margin:5px 0;">
			   
			    <?php
			    $i = 0;
			    if ( $post_meta ) :
				// loop post meta
				foreach( $post_meta as $value ) : ?>
				    <li>
					<span class="sort hndle"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/sort-handle.png"/></span>
					<input type="text" name="<?php echo $field['id'].'['.$i.']' ?>" id="<?php echo $field['id'].'['.$i.']' ?>"
					       class="input-img" size="50" placeholder="URL image" value="<?php echo $value ?>" />
					<a class="repeatable-remove button" href="#">-</a>
					<span class="repeatable-img">
					    <img src="<?php echo $value ?>" style="width:32px; vertical-align:bottom;"/>
					</span>
				    </li>
				    <?php
				    $i++;
				endforeach; // end loop meta
			    else : ?>
				<li>
				    <span class="sort hndle"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/images/sort-handle.png"/></span>.
				    <input type="text" name="<?php echo $field['id'].'['.$i.']' ?>"
					   class="input-img" size="50" placeholder="URL image" />
				    <a class="repeatable-remove button" href="#">-</a>
				    <span class="repeatable-img"></span>
				</li>
			    <?php endif; ?>
			    
			    </ul>
			    
			    <?php break;
		    
		    endswitch; // end switch ?>
		    </td>
		</tr>
	    <?php endforeach; // end loop meta_fields ?>
	</table> <!-- end table -->	
	<?php
    }
    
    /**
     *
     * School Form meta box
     *
     */
    public function school_meta_box()
    {
	global $post;
	
	// create nonce field
	// see more documentaion at http://codex.wordpress.org/Function_Reference/wp_nonce_field
	wp_nonce_field( basename( __FILE__ ), self::NONCE_META_BOX_FIELD );
	
	$fields = $this->_meta_fields();
	?>
	<!-- table -->
	<table class="form-table">
	    <?php 
	    foreach( $fields['school'] as $field ) :
		// get post meta
		$post_meta = get_post_meta( $post->ID, $field['id'], true ); // dump('', $post_meta); ?>
		<tr>
		    <th>
			<label for="<?php echo $field['id'] ?>"><?php echo $field['label'] ?></label>
			<?php if( $field['description'] ) : ?>
			    <div class="description" style="margin-top:10px; font-style:italic;">
				<?php echo $field['description'] ?>
			    </div>
			<?php endif; ?>
		    </th>
		    <td>
		    <?php
		    // create field
		    switch( $field['type'] ) : 
			    
			case 'text'  : ?>
			    
			    <input type="text" id="<?php echo $field['id'] ?>"
				   size="<?php echo $field['size'] ?>" placeholder="<?php echo $field['placeholder'] ?>"
				   name="<?php echo $field['id'] ?>" value="<?php echo $post_meta ?>" />
			    
			<?php break;
			
			case 'maps':
			    
			    // add gmap scripts
			    $this->init_gmap( $post_meta['lat'], $post_meta['lng'] ) ; ?>
			    
			    <input type="text" id="address" size="<?php echo $field['size'] ?>" name="<?php echo $field['id'].'[address]' ?>" value="<?php echo $post_meta['address'] ?>" />
			    <a href="#" id="getAddress" class="button">Search</a>
			    
			    <div id="map-location" style="margin-top:10px">
				Latitude   : <input type="text" class="lat" size="20" name="<?php echo $field['id'].'[lat]' ?>" value="<?php echo $post_meta['lat'] ?>" />
			   	Longtitude : <input type="text" class="lng" size="20" name="<?php echo $field['id'].'[lng]' ?>" value="<?php echo $post_meta['lng'] ?>" />
			    </div>
			    
			    <div id="maps" class="gmap3"></div>
			    
			 <?php break;
		    
		    endswitch; // end switch ?>
		    </td>
		</tr>
	    <?php endforeach; // end loop meta_fields ?>
	</table> <!-- end table -->
	
	<?php
    } 
    
    /**
     *
     * Save meta box
     *
     */
    public function save_meta_box()
    {
	global $post;
	
	// if doing autosave, return
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	    return;
	// if don't have nonce, return
	if ( !wp_verify_nonce( $_POST[self::NONCE_META_BOX_FIELD], basename( __FILE__ ) ) )
	    return;
	
	// looping meta fields
	foreach( $this->_meta_fields() as $f )
	{
	    foreach( $f as $field )
	    {
		$new = $_POST[$field['id']];
		if ( $new && $new != $old ) {
		    update_post_meta( $post->ID, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
		    delete_post_meta( $post->ID, $field['id'], $old );
		}
	    }
	}
    }
    
    /** ============================================ TEMPLATES ============================================ */
    
    /**
     *
     * add rewrite rule compare page
     *
     */
    public function add_rewrite_compare()
    {
	add_rewrite_rule(
	    'lesson/compare/?$',
	    'index.php?pagename=lesson&compare=true',
	    'top'
	);
	
	add_filter( 'query_vars', array( &$this, 'add_query_compare' ) );
    }    
    
    /**
     * Callback
     * add compare query vars
     */
    public function add_query_compare( $query_vars )
    {
	$query_vars[] = 'compare';
	return $query_vars;
    }
    
    /**
     *
     * Template
     *
     */
    public function template_redirect( $template )
    {
	global $wpdb, $wp_query, $post;
	
	if ( $wp_query->query_vars["post_type"] == self::LESSON )
	{
	    if( $wp_query->is_single )
		$template = $this->_get_template('single', 'lesson');
	    else
		$template = $this->_get_template('page', 'lesson');
	    
	    $this->do_redirect( $template );
	    
	} elseif ( $wp_query->query_vars["taxonomy"] == 'type_taxonomy' ||
		   $wp_query->query_vars["taxonomy"] == 'difficulty_taxonomy' ||
		   $wp_query->query_vars["taxonomy"] == 'location_taxonomy' ) {
	    
	    $template = $this->_get_template('taxonomy', 'lesson');
	    $this->do_redirect( $template );
	    
	} elseif ( $wp_query->query_vars["compare"] ) {
	    
	    $template = $this->_get_template('page', 'compare');
	    $this->do_redirect( $template );
	    	    
	} 	
	
    }
    
    /**
     * get file template
     *
     * @param String prefix file
     * @param String file name
     * @param String separator <optional>
     *
     * @return String path file php
     */
    private function _get_template( $prefix, $name, $sep = '-' )
    {
	$templatefilename = $prefix . $sep . $name . '.php';
	
        if ( file_exists( AFR_LS_PLUGIN_TPL_DIR . '/' . $templatefilename ) ) {
	    
            $template = AFR_LS_PLUGIN_TPL_DIR . '/' . $templatefilename;
	    
        } else {
	    
            $template = TEMPLATEPATH . '/' . $templatefilename;
	    
        }
	
	return $template;
    }
    
    /**
     *
     * Do redirect template
     *
     */
    public function do_redirect( $template )
    {
	global $post, $wp_query;
	
	if( file_exists( $template ) && have_posts() )
	{
	    
	    include( $template );
	    die();
	    
	} else {
	    $wp_query->is_404 = true;
	}
    }
    
    /** ============================================ SCRIPTS ============================================ */
    
    /**
     *
     * Admin print scripts
     *
     */
    public function backend_scripts()
    {
	global $post;
	    
	// jquery ui
	wp_deregister_script('jquery-ui');
	wp_register_script('jquery-ui','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js',array('jquery')); // CDN
	wp_enqueue_script('jquery-ui');
	wp_enqueue_style( 'jquery-ui', 'http://code.jquery.com/ui/1.8.4/themes/start/jquery-ui.css'); // CDN
	
	if( $post->post_type == self::LESSON ){
	    
	    wp_enqueue_script('custom-lesson-box', AFR_LS_PLUGIN_URL . '/js/custom-lesson-box.js');
	    wp_enqueue_style('jquery-ui-custom', AFR_LS_PLUGIN_URL . '/css/jquery-ui-custom.css');
	    
	} elseif( $post->post_type == self::SCHOOL ) {
	    
	    wp_enqueue_script( 'googlemapsapi', 'http://maps.google.com/maps/api/js?sensor=false', array(), '3', false );
	    wp_enqueue_script( 'gmap3', AFR_LS_PLUGIN_URL . '/js/gmap3/gmap3.min.js');
	    
	}
    }
    
    /**
     *
     * Front print scripts
     *
     */
    public function frontend_scripts()
    {
	// styles
	wp_enqueue_style( 'lesson-css', AFR_LS_PLUGIN_URL . '/css/style.css');
	
	// jquery core
	wp_enqueue_script('jquery');
	// jquery ui
	wp_deregister_script('jquery-ui');
	wp_register_script('jquery-ui','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js',array('jquery')); // CDN
	wp_enqueue_script('jquery-ui');
	wp_enqueue_style( 'jquery-ui', 'http://code.jquery.com/ui/1.8.20/themes/start/jquery-ui.css'); // CDN
	
	// libs-store
	wp_enqueue_script(
	    'content-libs-store',
	    AFR_LS_PLUGIN_URL . '/js/expand-content/libs-store.js',
	    array('jquery')
	);
	// common
	wp_enqueue_script(
	    'content-common',
	    AFR_LS_PLUGIN_URL . '/js/expand-content/common.js',
	    array('jquery')
	);
	// common1
	wp_enqueue_script(
	    'content-common-1',
	    AFR_LS_PLUGIN_URL . '/js/expand-content/common(1).js',
	    array('jquery')
	);
	// jquery Carousel
	wp_enqueue_script(
	    'jCarousel',
	    AFR_LS_PLUGIN_URL . '/js/jcarousel/lib.js',
	    array('jquery')
	);
	// jquery rating
	wp_enqueue_script(
	    'jRating',
	    AFR_LS_PLUGIN_URL . '/js/jrating/jRating.jquery.js',
	    array('jquery')
	);	
	wp_enqueue_style( 'jRating-css', AFR_LS_PLUGIN_URL . '/js/jrating/jRating.jquery.css'); 

	// Lesson js
	wp_enqueue_script(
	    'lesson-front-js',
	    AFR_LS_PLUGIN_URL . '/js/front.js',
	    array('jquery')
	);
	
	wp_enqueue_script( 'googlemapsapi', 'http://maps.google.com/maps/api/js?sensor=false', array(), '3', false );
	wp_enqueue_script( 'gmap3', AFR_LS_PLUGIN_URL . '/js/gmap3/gmap3.min.js');
	
	/**
	 * Localizes a script, but only if script has already been added
	 * see more documentation at http://codex.wordpress.org/Function_Reference/wp_localize_script
	 
	wp_localize_script('ajax-lesson', 'Ajax', array( 
	    'ajaxurl' => admin_url( 'admin-ajax.php' ),
	    'ajaxLessonNonce' => wp_create_nonce( self::NONCE_META_BOX_FIELD ) // create nonce for AJAX
	));*/
	
    }
    
    public function head_scripts()
    {
	?>
	<script type="text/javascript">
	    jQuery(document).ready(function($){
		
		$('.lrwcr-rating').jRating({
		    bigStarsPath : '<?php echo AFR_LS_PLUGIN_URL ?>/js/jrating/icons/bullet.png',
		    smallStarsPath : '<?php echo AFR_LS_PLUGIN_URL ?>/js/jrating/icons/small.png',
		    length  : 5,
		    rateMax : 10,
		    phpPath : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
		    action  : 'AFR-ls-ajax-rating',
		    onSuccess: function( response, element, id, rate ){
			var lessonId = $(element).data('parameter');
			$('.school-' + id).each(function(){
			    $(this).find('.lrwcr-box').html(rate);
			})
			$('.lrwcr-rating',$('#' + lessonId)).html( response.message );
		    }
		});
		
	    });
	</script>
	<?php
    }
    
    /**
     *
     * GMap scripts
     *
     */
    public function init_gmap( $lat, $lng )
    {
	$latitude     = ( $lat ) ? $lat : self::LAT ; 
	$longtitude   = ( $lng ) ? $lng : self::LNG ;
	 ?>	
	<!-- Map Scripts -->
	<!--<style>
	    .gmap3{
		margin: 10px 0;
		border: 1px dashed #C0C0C0;
		width: 500px;
		height: 300px;
	    }
	</style>-->
	<script type="text/javascript">
	    jQuery(function($){
		
		var position = new google.maps.LatLng( <?php echo $latitude; ?>, <?php echo $longtitude; ?> );
		
		$('#maps').gmap3(		
		    {
			action: 'addMarker',
			latLng: position,
			map:{
			    center: position,
			    zoom: 15
			},
			marker:{
			    options:{
				draggable: true,
			    },
			    events:{
				dragend: function(marker, event){
				    $('#map-location .lat').val( marker.position.lat() );
				    $('#map-location .lng').val( marker.position.lng() );
				}
			    }
			}
		    }
		);
		
		$('#address').autocomplete({
		    source: function(request, response) {
			$("#maps").gmap3({
			    action: 'getAddress',
			    address: request.term,
			    callback:function(results){
				if (!results) return;
				
				response($.map(results, function(item) {
				    return {
				      label : item.formatted_address,
				      value : item.formatted_address,
				      latLng: item.geometry.location
				    }
				}));
			    }
			});
		    },
		    //This bit is executed upon selection of an address
		    select: function(event, ui) {
			
			console.log(ui.item.latLng.Xa);
			console.log(ui.item.latLng.Ya);
			
			$('#map-location .lat').val( ui.item.latLng.Xa );
			$('#map-location .lng').val( ui.item.latLng.Ya );
			
			$("#maps").gmap3(
			    { action:'clear', name:'marker' },
			    {
				action: 'addMarker',
				latLng: ui.item.latLng,
				map   : {
				    zoom: 15,
				    center:true
				},
				marker:{
				    options: { draggable: true },
				    events : {
					dragend: function(marker, event){
					    $('#map-location .lat').val( marker.position.lat() );
					    $('#map-location .lng').val( marker.position.lng() );	
					}
				    }
				}
			    }
			);
		    }
		});
		
		$('#getAddress').click(function(){
		    var address = $('#address').val();
		    
		    $("#maps").gmap3({
			action:'getAddress',
			address: address,
			callback:function( result ){
			    if ( result ){
				$("#maps").gmap3({
				    action: 'addMarker',
				    latLng: result[0].geometry.location,
				    map: { center:true },
				    marker:{
					options:{
					    draggable: true
					},
					events:{
					    dragend: function(marker, event){
						$('#map-location .lat').val( marker.position.lat() );
						$('#map-location .lng').val( marker.position.lng() );
					    }
					}
				    }
				});
			    } else {
				alert('not found !');
			    }
			}
		    });
		    return false;
		})
	    });			
	</script>
	<!-- end Scripts -->
	<?php
    }
    
    /** ============================================ AJAX Handler ============================================ */
    
    /**
     *
     * AJAX Handler Sorting
     *
     */
    public function ajax_sorting()
    {
	global $wpdb, $global_order, $post;
	
	$isAjax = true;	
		
	$defaults = array(
	    'post_type'   => 'lesson',
	    'post_status' => array( 'publish', 'draft' )
	);	
	
	$sortBy    = $_POST['sortby'];
	$sortOrder = strtoupper($_POST['order']);
	$minPrice  = intval($_POST['min_price']);
	$maxPrice  = intval($_POST['max_price']);
	// nonce
	$nonce = $_POST['nonce'];
	
	/*
	// if don't have nonce, set error
	if ( !wp_verify_nonce( $nonce, self::NONCE_META_BOX_FIELD ) )
	    die ( -1 );
	*/
	
	switch( $sortBy )
	{
	    case 'price-range':
		if( isset($min_price) && isset($max_price) ){
		    $merge = array(
			'meta_query'  => array(
			    array(
				'key'     => 'lesson-price-amount',
				'value'   => array( $min_price, $max_price ),
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN'
			    ),
			    'meta_key' => 'lesson-price-amount',
			    'orderby'  => 'meta_value',
			    'order'    => 'ASC'		
			)	       
		    );
		    // no conflict
		    $global_order = sprintf('CAST(%s as SIGNED) ASC', $wpdb->postmeta . '.meta_value');
		    // end no conflict
		}
		break;
	    
	    case 'price':
		$merge = array(
		    'meta_key' => 'lesson-price-amount',
		    'orderby'  => 'meta_value',
		    'order'    => $sortOrder		  
		);
		
		// no conflict
		$global_order = sprintf('CAST(%s as SIGNED) %s', $wpdb->postmeta . '.meta_value', $sortOrder);
		// end no conflict
		break;
	    
	    case 'duration':
		$merge = array(
		    'meta_key' => 'lesson-duration',
		    'orderby'  => 'meta_value',
		    'order'    => $sortOrder	  
		);
		
		// no conflict
		$global_order = sprintf('CAST(%s as SIGNED) %s', $wpdb->postmeta . '.meta_value', $sortOrder);
		// end no conflict
		break;
	    
	    case 'date':
		$merge = array(
		    'meta_key' => 'lesson-date',
		    'orderby'  => 'meta_value',
		    'order'    => $sortOrder		  
		);
		
		// no conflict
		$global_order = sprintf('CAST(%s as DATE) %s', $wpdb->postmeta . '.meta_value', $sortOrder);
		// end no conflict
		break;
	    
	    default:
		$merge = array();
		break;
	}
	
	$args = array_merge( $defaults, $merge );
	
	query_posts( $args );

	if( have_posts() ) :
	
	    while( have_posts() ) :
	    
		the_post();
		
		$template = $this->_get_template('loop', 'lesson');
		
		include( $template ); 
	    
	    endwhile; // end loop
	
	endif;	 
	
	exit;
    }
    
    /**
     *
     * AJAX Handler Rating
     *
     */
    public function ajax_rating()
    {
	$id   = intval( $_POST['idBox'] );
	$rate = intval( $_POST['rate'] );
	
	/*$vote_key  = 'school-vote';
	$count_key = 'school-count';
	$vote  = get_post_meta( $id, $vote_key, true );
	$count = get_post_meta( $id, $count_key, true );
	if( $vote == '' && $count ){
            $count = 0;
            delete_post_meta( $id, $vote_key );
            add_post_meta( $id, $vote_key, $rate );
            delete_post_meta( $id, $rate_key );
            add_post_meta( $id, $rate_key, 1 );	    
	} else {
	    $vote = $vote + $rate;
	    $count++;
            update_post_meta( $id, $vote_key, $vote );
            update_post_meta( $id, $count_key, $count );
	}*/
		
	$aResponse['message'] = 'Your rate has been successfuly recorded. Thanks for your rate :)';
			
	// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
	$aResponse['server'] = '<strong>Success answer :</strong> Success : Your rate has been recorded. Thanks for your rate :)<br />';
	$aResponse['server'] .= '<strong>Rate received :</strong> '.$vote.'<br />';
	$aResponse['server'] .= '<strong>Count received :</strong> '.$count.'<br />';
	$aResponse['server'] .= '<strong>ID to update :</strong> '.$id;
	// END ONLY FOR DEMO

	echo json_encode($aResponse);	 
	
	exit;
    }
}