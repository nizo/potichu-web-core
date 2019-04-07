<?php
	global $avia_config;

	$avia_config['analytics_code'] = avia_option('analytics', false, false, true);
	if(empty($avia_config['analytics_code'])) return;

	echo $avia_config['analytics_code'];

	?>

	ga('send', 'event', 'Contact', 'Contact form', 'Contact form submitted', 1);"

<?php
	?>