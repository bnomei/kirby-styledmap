<?php
    if (!isset($varname)) {
        $varname = '';
    }
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= c::get('plugin.styledmap.apikey', c::get('map.key', 'YOUR_API_KEY_HERE')) ?>&callback=initMap<?php echo $varname; ?>"></script>