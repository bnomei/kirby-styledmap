<?php
	/////////////////////////////////////
	// SNIPPET: $m, $mrk
	
	$info = trim(a::get($mrk, 'info', ''));
	$infoOpen = boolval(a::get($mrk, 'infoOpen', c::get('plugin.styledmap.jsmarker.infoOpen', true)));
	$infoMaxWidth = trim(a::get($mrk, 'infoMaxWidth', c::get('plugin.styledmap.jsmarker.infoMaxWidth', '200')));
	$hasInfo = strlen($info) > 0;

	$url = url(a::get($mrk, 'info', ''));
	$hasURL = v::url($url);

	$icon = trim(a::get($mrk, 'icon', c::get('plugin.styledmap.jsmarker.icon', '')));
	$iconURL = url($icon);
	$hasIcon = strlen($icon) > 0 && v::url($iconURL);
?>
	var marker_<?= $m ?> = new google.maps.Marker({
		position: {lat: <?= $mrk['lat'] ?>, lng: <?= $mrk['lng'] ?>},
		title: "<?= $mrk['title'] ?>",
		map: map<?php 
			ecco($hasIcon, ','. PHP_EOL . '        icon: "'.$iconURL.'"', '') 
		?>
	});

	<?php if($hasInfo && !$hasURL): ?>
	var infowindow = new google.maps.InfoWindow({
		content: '<?= $info ?>',
		maxWidth: <?= $infoMaxWidth ?>
		});
	<?php if($infoOpen): ?>
	infowindow.open(map, marker_<?= $m ?>);
	<?php endif; ?>
	marker_<?= $m ?>.addListener('click', function() {
		infowindow.open(map, marker_<?= $m ?>);
	});
	<?php elseif($hasURL): ?>
	marker_<?= $m ?>.addListener('click', function() {
		window.location.href = '<?= $url ?>';
	});
	<?php endif; ?>
