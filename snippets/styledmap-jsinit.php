<?php
	/////////////////////////////////////
	// SNIPPET : $center, $style, $markers, $page

	if(!isset($page)) $page = null;
	$id = c::get('plugin.styledmap.mapid', 'styledmap');

	$useCustomMapType = false;
	$customMapType = '';
	if(isset($style)) {
		$useCustomMapType = true;
		if($page && str::contains(str::lower($style), '.json')) {
			if($file = $page->file($style)) {
				$json = f::read($file->root());
				if(styledmapIsJSON($json)) {
					$customMapType = $json;
				}
			}
		} else {
			$customMapType = snippet(c::get('plugin.styledmap.jsjson', $style), [], true);
		}
	}
	$customMapTypeIDs = c::get('plugin.styledmap.jsmaptypeids', 'google.maps.MapTypeId.ROADMAP');

	$mapOptions = c::get('plugin.styledmap.jsoptions', [
		'draggable' 		=> true,
		'fullscreenControl'	=> true,
		'mapTypeControl' 	=> true,
		'rotateControl' 	=> true,
		'scaleControl' 		=> true,
		'scrollwheel' 		=> true,
		'streetViewControl'	=> true,
		'zoomControl' 		=> true,
		]);
	$mapOptionsJS = '';
	$tabs = '';
	foreach ($mapOptions as $key => $value) {
		$v = $value === true || $value == 'true' ? 'true' : 'false';
		$mapOptionsJS .= $tabs . $key . ': ' . $v . ',' . PHP_EOL;
		if($tabs == '') $tabs = '        ';
	}
	$mapOptionsJS = trim($mapOptionsJS, ',');

	if(!isset($center)) {
		$center = [
			'lat' 	=> c::get('plugin.styledmap.defaults.lat', c::get('map.defaults.lat', '21.437127')),
			'lng' 	=> c::get('plugin.styledmap.defaults.lng', c::get('map.defaults.lng', '-158.186699')),
			'zoom'  => c::get('plugin.styledmap.defaults.zoom', c::get('map.defaults.zoom', '15')),
			'title' => c::get('plugin.styledmap.defaults.title', c::get('map.defaults.title', ''))
			];
	}
	//a::show($center);

	if(isset($markers)) {
		$json = snippet(c::get('plugin.styledmap.jsmarker', $markers), [], true);
		$markers = json_decode($json, true);
		
	} else {
		$markers = array();
	}

	// center is a marker too
	$markers = array_merge([$center],  $markers);
	//a::show($markers);

?>
<script>
var map;
function initMap() {
	
	// map with center marker, zoom, options and maptypeids
	var map = new google.maps.Map(document.getElementById('<?= $id ?>'), {
		
		center: {lat: <?= $center['lat'] ?>, lng: <?= $center['lng'] ?>},
		zoom: <?= $center['zoom'] ?>,
		<?= $mapOptionsJS ?>
		mapTypeControlOptions: {
			mapTypeIds: [<?= $customMapTypeIDs ?><?php ecco($useCustomMapType, ', "customMapTypeId"','') ?>]
		}
	});
		
	<?php if($useCustomMapType): ?>
	// custom map type
	var customMapType = new google.maps.StyledMapType(
 		<?= $customMapType ?>
		, {
			name: 'custommaptype'
	});
	map.mapTypes.set('custommaptype', customMapType);
	map.setMapTypeId('custommaptype');
	<?php endif; ?>

	<?php if(count($markers) > 0): ?>
	// custom map markers
	<?php for($m=0; $m<count($markers); $m++){
		$mrk = $markers[$m];
		//a::show($mrk);
		if(count(a::missing($mrk, ['lat', 'lng'])) > 0) continue;

		snippet(c::get('plugin.styledmap.jsmarker', 'styledmap-marker'), [
			'm' => $m,
			'mrk' => $mrk,
			]);
	}
	?>
	<?php endif; ?>
}
</script>