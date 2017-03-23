<!DOCTYPE html>
<html>
<head>
	<title>Kirby Styledmap Examples</title>
</head>
<body style="max-width: 600px;margin:0 auto;padding-bottom:80px;font-family:'Helvetica Neue', Helvetica,Arial, sans-serif;">
	<center>
		<h1 style="margin-top:40px;">Kirby Styledmap Example</h1>
		<div><a style="border-radius: 5px;border:1px solid #666;color:#666;text-decoration:none;padding:5px;" href="https://github.com/bnomei/kirby-styledmap">Github Docs</a><br><br></div>
	</center>

	<?php 
		$examples = [
			'URL' => [   
				'title'	   => 'Lualualei Beach Park',
				'location' => 'https://www.google.com/maps/place/Lualualei+Beach+Park/@21.437127,-158.186699,15z',
				'style'    => null,
				'markers'  => null
			],
			'Lng, Lng, Zoom' => [   
				'title'	   => 'Lualualei Beach Park',
				'location' => '21.437127, -158.186699, 15',
				'style'    => null,
				'markers'  => null
			],
			
			'Map Field' => [ 
				/*
				'title'	   => 'Lualualei Beach Park',
				'location' => 'location',
				'style'    => null,
				'markers'  => null
				*/
				'error'	   => 'Not possible using this example based on route.'
			],
			'Style' => [   
				'title'	   => 'Lualualei Beach Park',
				'location' => '21.437127, -158.186699, 15',
				'style'    => 'sm-example-json',
				'markers'  => null
			],
			'Markers' => [   
				'title'	   => 'Maili',
				'location' => '21.417105 -158.177937 10',
				'style'    => null,
				'markers'  => 'sm-example-markers'
			],

		];

    	foreach ($examples as $key => $value) {
    		$canDo = !a::get($value, 'error');
    		$id = 's__' . md5($key);
    		$a = brick('a', 'show')
    			->attr('id', $id)
    			->attr('style', 'padding-left:20px;')
    			->attr('href', site()->url() . '/kirby-styledmap-route/examples/show:'.urlencode($key).'#'.$id);
    		$h2 = brick('h2', 'Example ' . $key)
    			->attr('style', 'color:#666;margin-top:40px;');
    		if($canDo) {
    			$h2->append($a);
    		}
    		echo $h2;

    		echo brick('pre', a::show($value, false))
    			->attr('style', 'background-color:#eee;padding:20px;');

    		if(urldecode(param('show')) == $key && $canDo) {
	    		echo site()->styledmap(
	    			$value['title'],
	    			$value['location'], 
	    			[],
	    			$value['style'], 
	    			$value['markers']
	    			);
	    	}
    	}
		
	?>
</body>

</html>