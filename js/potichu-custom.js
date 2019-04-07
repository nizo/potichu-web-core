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


/*
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
				jQuery('#' + allSections[i]).
*/