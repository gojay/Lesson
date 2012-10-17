
jQuery(function(jQuery) {
	
    /*jQuery('.repeatable-add').click(function() {
	field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
	field.find('.repeatable-img').html('');
	
	fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
	jQuery('input', field).val('').attr('name', function(index, name) {
	    return name.replace(/(\d+)/, function(fullMatch, n) {
		return Number(n) + 1;
	    });
	})
	console.log(fieldLocation);
	field.insertAfter(fieldLocation, jQuery(this).closest('td'))
	return false;
    });
    
    jQuery('.repeatable-remove').click(function(){
	var len = jQuery(this).parents('ul').children().length;
	if(len == 1)
	    jQuery(this).parent()
	    .find(':input').each(function(){
		    jQuery(this).val('');
	    })
	else
	    jQuery(this).parent().remove();
	return false;
    });
	    
    jQuery('.custom_repeatable').sortable({
	opacity: 0.6,
	revert : true,
	cursor : 'move',
	handle : '.sort'
    });*/
    
    jQuery('.repeatable-add2').click(function() {
	field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
	field.find('.repeatable-img').html('');
	
	fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
	jQuery('input', field).val('').attr('name', function(index, name) {
	    return name.replace(/(\d+)/, function(fullMatch, n) {
		return Number(n) + 1;
	    });
	})
	console.log(fieldLocation);
	field.insertAfter(fieldLocation, jQuery(this).closest('td'))
	return false;
    });
  
    function validateURL( textval ) {
	var urlregex = new RegExp(
            "^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
	return urlregex.test(textval);
    }
    
    jQuery('.input-img').focusout(function(){
	var url     = jQuery(this).val(),
	    prvImg  = jQuery(this).siblings('.repeatable-img');
	
	if( validateURL( url ) ){
	    prvImg.html('<img src="'+ url +'" style="width:32px; vertical-align:bottom;"/>');
	} else {
	    prvImg.html('');
	}
	
    });
    
    function findDifference( h1, m1, am1, h2, m2, am2 )
    {
	var difference,
	    mdiff = 1;
	    hdiff = 2,
	    result = {};
	
	ph1 = parseInt(h1,10);
	ph2 = parseInt(h2,10);
	pm1 = parseInt(m1,10);
	pm2 = parseInt(m2,10);
	
	if(am1 == 'pm' & ph1 < 12) ph1 = ph1 + 12;
	if(am2 == 'pm' & ph2 < 12) ph2 = ph2 + 12;
	if(am1 == 'am' & ph1 == 12) ph1 = 24;
	if(am2 == 'am' & ph2 == 12) ph2 = 24;
	if(am1 == 'pm' & am2 == 'am' & ph2 < 24) ph2 = ph2 + 24;
	if(am1 == am2 & ph1 > ph2) ph2 = ph2 + 24;
	
	if(pm2 < pm1){
	    pm2 = pm2 + 60;
	    ph2 = ph2 - 1;
	}
	
	mdiff = pm2 - pm1;
	hdiff = ph2 - ph1;
	
	var hours = (hdiff * 60) + mdiff
	
	if( hdiff == 0 )
	    difference = mdiff + ' minutes'
	else if( hdiff == 1 ){
	    difference = '1 hour'
	    if( mdiff > 0 )
		difference = difference + ' and ' + mdiff + ' minutes'
	} else{
	    difference = hdiff + ' hours'
	    if( mdiff > 0 )
		difference = difference + ' and ' + mdiff + ' minutes'
	}    
	result = { hours:hours, message:difference }
	
	return result
    }
    
    jQuery('#lesson-duration').focusin(function(){
	// alert('duration');
	var in_hr   	= jQuery('#timing-start-hour').val(),
	    in_min   	= jQuery('#timing-start-minute').val(),
	    in_am  	= jQuery('#timing-start-time').val(),
	    /*--------------------------------------------------------------*/
	    out_hr  	= jQuery('#timing-end-hour').val(),
	    out_min   	= jQuery('#timing-end-minute').val(),
	    out_am 	= jQuery('#timing-end-time').val();	
	
	var diff = findDifference(
	    in_hr, in_min, in_am,   // start time
	    out_hr, out_min, out_am // end time
	);
	
	jQuery(this).val( diff.hours );
	jQuery(this).siblings('.description').html( diff.message );
    });

});