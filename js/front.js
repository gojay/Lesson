jQuery(function($) {
    
    $('#ajax-loader').ajaxStart(function(){
	$(this).show();
	$('#lesson-results').css({ opacity:0.3 });
    }).ajaxStop(function(){
	$(this).hide();
	$('#lesson-results').css({ opacity:1 });
    });
    
    /** ======================== AJAX ======================== */
    
    var parameters = { action:'AFR-ls-ajax', nonce:Ajax.ajaxLessonNonce };
    var do_params = function( data, event ){
	for(var key in data){
	    switch( event ){
		case 'add':
		    parameters[key] = data[key];
		    break;
		    
		case 'unset':
		    delete parameters[key];
		    break;
	    }
	}		
    }
    
    var ajax = function(data, callback){
	
	do_params( data, 'add' ); // add params
	
	console.log( parameters );
	    
	$.ajax({
	    type: 'POST',
	    data: parameters,
	    url : Ajax.ajaxurl,
	    success: function(response){
		
		console.log(response); // debug
		
		callback(null, response);
	    },  
	    error: function(jqXHR, textStatus, errorThrown) {  
		var error = jqXHR + " :: " + textStatus + " :: " + errorThrown;  
		callback(error, null);
	    }  
	});
    };
    
    /** ======================== Event ======================== */
    
    /** Slider Range */
    
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 500,
        values: [ 0, 500 ],
        slide: function( event, ui ) {
	    setRange( ui.values[ 0 ], ui.values[ 1 ] );
	    
	    var params = { sortby:'price-range', min_price: ui.values[ 0 ], max_price: ui.values[ 1 ] };
	    ajax( params , function(err, response){
		if(err){
		    console.log(err);
		} else {
		    $('#lesson-results').html( response );
		}
	    });
        }
    });
	
    // default
    setRange(
	$( "#slider-range" ).slider( "values", 0 ),
	$( "#slider-range" ).slider( "values", 1 )
    );
    
    function setRange( min, max ){
	$('.slsnwsr-min input').val( "$" + min );
	$('.slsnwsr-max input').val( "$" + max );
    }
    
    /** Tab Sorting */
    
    function currentTab(toggle){
	
	console.log(toggle);
	
	$('.sorting-lesson').find('div').each(function(){
	    $(this).removeClass('active');
	})
	$(toggle).addClass('active');
    }
	
    $('.sorting-lesson a').click(function(){
	var data    	= $(this).attr('data-parameter'),
	    arrSort 	= data.split('-'),
	    sortBy 	= arrSort[0],
	    sortOrder 	= arrSort[1];
	
	var params = { sortby:sortBy, order:sortOrder };
	ajax( params , function(err, response){
	    if(err){
		console.log(err);
	    } else {
		$('#lesson-results').html( response );
	    }
	});
	
	// set current this tab
	currentTab($(this).parent());
	
	return false;
	
    });
    
    /**
     * event checkbox compare
     */ 
    $("#lesson-results :checkbox").click(function(){
					 
	var checked   = $("#lesson-results :checkbox:checked").length,
	    wrapper   = $(this).parents('.lesson-result-wrapper'),
	    wrapperID = wrapper.attr('id'),
	    imgDiv    = $(this).parents('.lrwl-compare').siblings('.lrwl-image'),
	    imgSrc    = imgDiv.find('img').attr('src');
	
	var bool = ( checked == 3 );
	$("#lesson-results :checkbox:not(:checked)").attr("disabled", bool);		
	
	if( $(this).is(':checked') ){
	    // is checked, add compare thumb
	    $('#compare-box-' + checked).html(
		'<a href="#" id="'+ wrapperID +'"><img src="'+ imgSrc +'" style="width:35px; height:25px; text-align:center" /></a>'
	    );
	} else {
	    removeCompare( wrapperID ); // if is unchecked, remove compare thumb    
	}
    });
    
    /**
     * event link img compare
     */    
    $('.sfr1c-box a').live('click', function(){
	var id = $(this).attr('id');
	
	removeCompare( id );
	
	return false;
    })
    
    /**
     * remove lesson compare
     *
     * remove thumb
     * uncheck lesson
     */
    function removeCompare( id )
    {
	// remove compare thumb
	$('.sfr1c-box a#'+id).parent().html('');
	// unchecked
	$('#'+id+' .compare-lesson').attr('checked', false);
    }
    
    $('#formLesson').submit(function(){
	var checkCount = $("#lesson-results :checkbox:checked").length;
	
	if( checkCount <= 1 ){
	    alert('Please choose the lesson gt 1');
	    return false;	    
	}
	
	return true;
    });
    
    /**
     *
     * single page
     * lesson thumb image
     *
     */
    $('.lddgtw-thumb, .lddgtw-thumb-last').on('click', function(){
	var showcase = $('.lddg-showcase'),
	    img      = $(this).find('img'),
	    isThumb  = img.hasClass('pointer'),
	    src      = img.attr('src');
	    
	if( isThumb ){
	    showcase.find('img').attr('src', src);
	}
	
	return false;
    });
});