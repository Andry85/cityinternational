<?php

// Google Map shortcode
// ============================================================================
// 
// A Google API key must be defined in wp-config.php, e.g.
// 
// define('IW_GOOGLE_MAP_API_KEY', 'AIzaSyD0Ta9JFYRvyG60ydTNeBp_4zqosJAEAjk');
// 
// Example usage:
// 
// [gmap lat="50.747846" lng="-3.4172227" info="Hello world!"]

// Required attrs (fails silently if not set):
//  - lng {double}
//  - lat {double}
//  
// Optional attrs:
//  - zoom {int} Zoom level
//  - info {string} Text content for info box

//todo gmap api key in wp options

namespace IllicitWeb;

add_shortcode('gmap', function ($attr=null) {
	if (!defined('IW_GOOGLE_MAP_API_KEY'))
	{
		return;
	}

	if (empty($attr['lng']) || empty($attr['lat']))
	{
		return '';
	}

	$lng = (double)$attr['lng'];
	$lat = (double)$attr['lat'];

	$info = empty($attr['info']) ? null : trim($attr['info']);
	$zoom = empty($attr['zoom']) ? 15 : (int)$attr['zoom'];

    ob_start();

    static $counter = 0;
    
    $div_id = 'iw-gmap-'.$counter;
    $callback_name = 'iwGMapInit'.$counter;
    ++$counter;

    ?>
    <div id="<?= $div_id ?>" class="gmap" style="min-height: 400px; "></div>

    <script>
    window["<?= $callback_name ?>"] = function () {
    	var center = {
    		lat: <?= $lat ?>,
    		lng: <?= $lng ?>
    	};

    	var map = new google.maps.Map(document.getElementById("<?= $div_id ?>"), {
    		center: center,
    		zoom: <?= $zoom ?>
    	});

    	var marker = new google.maps.Marker({
    		map: map,
    		position: center
    	});

    	<?php if ($info): ?>
    	var infoWindow = new google.maps.InfoWindow({
    		map: map,
    		content: <?= json_encode($info) ?>
    	});

    	infoWindow.open(map, marker);

    	<?php endif ?>
    };
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= 
    	IW_GOOGLE_MAP_API_KEY ?>&callback=<?= $callback_name ?>"></script>
    <?php

    return ob_get_clean();
});
