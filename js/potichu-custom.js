window.onload=function(){
	FB.Event.subscribe('comment.create', function(response){
			var dummyImage = new Image;
			dummyImage.src = 'http://potichu.sk/potichu-fb-notify.php?path='+response.href.replace('http://','');
			
	});
};


function setDefaultSections() {
	data = [
		'back-button',
		'noise-type-section',
		'noise-originator-section',
		'results',
		'results-konstrukcie-akustika',
		'results-konstrukcie-profesionali',
		'results-konstrukcie-hluk-vo-vyrobe',
		'results-konstrukcie-krocajovy-hluk',
		'construction-width-section',
		'construction-approach-section'		
	];
	
	restoreSectionsVisibility(data);
}



function restoreSectionsVisibility(data, backNavigation) {
	backNavigation = backNavigation || false;
	allSections = [
		'problem-section',
		'back-button',
		'noise-type-section',
		'noise-originator-section',
		'results',
		'results-konstrukcie-akustika',
		'results-konstrukcie-profesionali',
		'results-konstrukcie-hluk-vo-vyrobe',
		'results-konstrukcie-krocajovy-hluk',
		'construction-width-section',
		'construction-approach-section'		
	];
	
	for (i = 0; i < allSections.length; i++) {				
		if (jQuery.inArray(allSections[i], data) != -1) {			
		
			if ( allSections[i] == 'back-button')
				jQuery('#' + allSections[i]).addClass('hiddenContainer');
			else
				jQuery('#' + allSections[i]).hide();
		}
		else {
			if ( allSections[i] == 'back-button')
				jQuery('#' + allSections[i]).removeClass('hiddenContainer');
			else
				jQuery('#' + allSections[i]).show();
		}
	}
		
	if (!backNavigation) {
		history.pushState(data, '');
	}
}

function removeFromArray(elements, value) {
	elements.splice( jQuery.inArray(value, elements), 1 );
	return elements;
}

var selectedWidth = '';
var selectedOriginator = '';
var selectedNoiseType = '';

function fetchConstructions() {

	jQuery("#constructions #results").empty();
	jQuery('html, body').css("cursor", "wait");
			
	jQuery.ajax({
		url: ajaxurl,
		type: 'post',
		data: {
			action: 'fetchConstructions',
			width: selectedWidth,
			originator: selectedOriginator,
			noiseType: selectedNoiseType
		},		
		success: function( result ) {
			jQuery("#constructions #results").append(result);
			jQuery('html, body').css("cursor", "auto");
		},
		error: function( result ) {			
			jQuery('html, body').css("cursor", "auto");
		}
	});
}

jQuery(function() {

	setDefaultSections();
	jQuery("#problem-section > div").click(function() {		
	
		var hiddenSections = history.state;
		
		if (jQuery(this).attr("data-last-step")) {
			if (jQuery(this).attr("data-link")) {				
				hiddenSections = removeFromArray(hiddenSections, 'results-' + jQuery(this).attr("data-link"));
			}
		} else {
			if (jQuery(this).attr("data-id") == 'loud-me') {								
				hiddenSections = removeFromArray(hiddenSections, 'noise-type-section');
			}
			else if (jQuery(this).attr("data-id") == 'loud-neighboor') {
				hiddenSections = removeFromArray(hiddenSections, 'noise-originator-section');
				selectedNoiseType = '';
			}
		}
		
		hiddenSections.push('problem-section');
		hiddenSections = removeFromArray(hiddenSections, 'back-button');
		
		restoreSectionsVisibility(hiddenSections);
	});	
	
	
	jQuery("#noise-type-section > div").click(function() {	
		var hiddenSections = history.state;			
		selectedNoiseType = jQuery(this).attr("data-noise-type");
		
		hiddenSections.push('noise-type-section');
		
		if (selectedNoiseType == 'bezny') {
			hiddenSections = removeFromArray(hiddenSections, 'construction-approach-section');		
		}
		else if (selectedNoiseType == 'atypicky') {
			hiddenSections = removeFromArray(hiddenSections, 'results-konstrukcie-akustika');
		}
		else if (selectedNoiseType == 'krocajovy') {
			hiddenSections = removeFromArray(hiddenSections, 'results-konstrukcie-krocajovy-hluk');
		}
				
		restoreSectionsVisibility(hiddenSections);
	});	
	
	jQuery("#construction-approach-section > div").click(function() {		
		var hiddenSections = history.state;	
		hiddenSections.push('construction-approach-section');		
			
		if (jQuery(this).attr("data-approach") == 'priestorova-akustika') {
			hiddenSections = removeFromArray(hiddenSections, 'results-konstrukcie-akustika');
			console.log('static page');
		}
		else hiddenSections = removeFromArray(hiddenSections, 'noise-originator-section');		

		restoreSectionsVisibility(hiddenSections);
	});	
		
	jQuery("#noise-originator-section > div").click(function() {		
		var hiddenSections = history.state;			
		hiddenSections.push('noise-originator-section');		
				
		selectedOriginator = jQuery(this).attr("data-originator");
		hiddenSections = removeFromArray(hiddenSections, 'construction-width-section');
		
		restoreSectionsVisibility(hiddenSections);
	});	
	
	jQuery("#construction-width-section > div").click(function() {		
		var hiddenSections = history.state;
		hiddenSections.push('construction-width-section');
		
		jQuery("#constructions #results").empty();
		selectedWidth = jQuery(this).attr("data-width");
		
		hiddenSections = removeFromArray(hiddenSections, 'results');
		
		restoreSectionsVisibility(hiddenSections);	

		fetchConstructions();
	});	
		
	jQuery("#constructions #back-button").click(function() {	
		window.history.back();		
	});		
});

window.addEventListener('popstate', function(e){	
    var data = e.state;

    if (data == null) {
		setDefaultSections();
    } else {
		restoreSectionsVisibility(data, true);
    }
})
 
 
 