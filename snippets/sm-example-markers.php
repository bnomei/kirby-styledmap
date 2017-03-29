<?php
// get markers from $page fields, methods or whatever
$markers = array(
	[	'title' => 'Makaiwa Beach Park',  // or something like: $page->title()->value()
		'lat' 	=> 21.347355, 
		'lng' 	=> -158.127777, 

		// get an icon from somewhere. could be a svg too.
		'icon'	=> site()->url() . '/assets/plugins/kirby-styledmap/sm-example-icon.svg',
		// open url on click
		'info'	=> 'https://www.google.de/maps/place/Makaha+Beach+Park/@21.3569219,-158.1442995,12z',
	],
	[	'title'	=> 'Makaha Beach Park',  // or something like: $page->location()->yaml()['adress']
		'lat' 	=> 21.477042,            // or something like: $page->location()->yaml()['lat']
		'lng' 	=> -158.2228767,         // or something like: $page->location()->yaml()['lng']

		// info popup instead of url
		'info'	=> '<h2>Makaha</h2><p>Beach Park</p>',
		// use a route to get a dynamic label
		'icon'	=> site()->url() . '/kirby-styledmap-route/'.rawurlencode('Cu$töm L4bel!').'/label.svg',
	],
	// ... 
);
echo a::json($markers);