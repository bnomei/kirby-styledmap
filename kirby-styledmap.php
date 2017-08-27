<?php

function styledmapIsJSON($string){
   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

function styledmapLocation($page, $field, $title = '', $more = []) {
  $defaultZoom = c::get('plugin.styledmap.defaults.zoom', c::get('map.defaults.zoom', 12));

  ///////////////////////////////////////
  // STRING
  if(gettype($field) == 'string') {
    // Field
    $validField = false;
    if($page) {
      $tryfield = $page->$field();
      if($tryfield != null) {
        if(is_a($tryfield, 'Field') && $tryfield->isNotEmpty()) {
          $field = $tryfield->yaml();
          $validField = true;
        }
      }
    }
    // String
    if(!$validField) {
      $loc = array();
      // URL
      if(v::url($field)) {
        foreach (explode('/', (string)$field) as $mup) {
          if(substr($mup, 0, 1) === '@') {
            $loc = explode(',', substr($mup, 1));
            break;
          }
        }
      } 
      // comma-seperated string
      else {
        $loc = explode(' ', str_replace([', ',',','  '], [' ',' ', ' '], $field));
      }

      $field = $loc;
    }
  }

  ///////////////////////////////////////
  // ARRAY
  if (gettype($field) == 'array') {
    
    $lat = a::get($field, 0, 0); 
    $lng = a::get($field, 1, 0); 
    $zoom = a::get($field, 2, $defaultZoom);
    $title = trim(a::get($field, 'title', $title));
    $lat   = a::get($field, 'lat', $lat);
    $lng   = a::get($field, 'lng', $lng);
    $zoom  = intval(str_replace('z', '', a::get($field, 'zoom', $defaultZoom)));

    $l = [
      'title' => $title,
      'lat'   => $lat, 
      'lng'   => $lng, 
      'zoom'  => $zoom,
    ];
    if(gettype($more) == 'array') {
      return array_merge($l, $more);
    } else {
      return $l;
    }
  }

  // else
  return null;
}

/****************************************
  SNIPPETS
 ***************************************/

$snippets = new Folder(__DIR__ . '/snippets');
foreach ($snippets->files() as $file) {
  if(!c::get('plugin.styledmap.examples', true) && str::contains('sm-example-', $file->name())) continue;
  if($file->extension() == 'php') {
    $kirby->set('snippet', $file->name(), $file->root());  
  }
}

/****************************************
  ROUTES
 ***************************************/

if(c::get('plugin.styledmap.examples', true)) {
  $kirby->set('route', 
    array(
        'pattern' => 'kirby-styledmap-route/(:any)/label.svg',
        'action' => function($any) {
            $svg = __DIR__ . DS . 'assets' . DS . 'sm-example-label.svg';
            $label = rawurldecode(str_replace('.svg', '', $any));
            if(f::exists($svg)) {
              return new Response(tpl::load($svg, $data = ['label'=>$label]), f::extensionToMime('svg'));
            }
            //return false;
        }
    )
  );
  $kirby->set('route',
    array(
      'pattern' => 'kirby-styledmap-route/examples',
        'action' => function() {
            $html = snippet('sm-example-html', [], true);
            return new Response($html);
        }
    )
  );
}

/****************************************
  PAGE METHOD
 ***************************************/

$kirby->set('page::method', 'styledmap', 
  function( 
    $page, 
    $title,
    $location = null,
    $centerData = [],
    $snippet_style = null,
    $snippet_markers = null
    ) {

    $map = snippet('styledmap', [
        'page'            => $page,
        'title'           => $title,
        'location'        => $location,
        'centerData'      => $centerData,
        'snippet_style'   => $snippet_style,
        'snippet_markers' => $snippet_markers,
        ], true);
      return $map;
});

/****************************************
  SITE METHOD
 ***************************************/

$kirby->set('site::method', 'styledmap', 
  function( 
    $site, 
    $title,
    $location = null,
    $centerData = [],
    $snippet_style = null,
    $snippet_markers = null
    ) {

    $map = snippet('styledmap', [
        'page'            => site(),
        'title'           => $title,
        'location'        => $location,
        'centerData'      => $centerData,
        'snippet_style'   => $snippet_style,
        'snippet_markers' => $snippet_markers,
        ], true);
      return $map;
});

/****************************************
  KIRBY TAG
 ***************************************/

$kirby->set('tag', 'styledmap', array(
  'attr' => array(
    'location',
    'info',
    'style',
    'markers',
  ),
  'html' => function($tag) {

    $title = (string)$tag->attr('styledmap');
    $location = (string)$tag->attr('location');
    $snippet_style = (string)$tag->attr('style');
    $snippet_markers = (string)$tag->attr('markers');
    $info = (string)$tag->attr('info');
    
    $map = snippet('styledmap', [
        'title'           => $title ? $title : '',
        'location'        => $location ? $location : null,
        'centerData'      => $info ? ['info'=>$info] : [],
        'snippet_style'   => $snippet_style ? $snippet_style : null,
        'snippet_markers' => $snippet_markers ? $snippet_markers : null,
        ], true);
      return $map;
  }
));

/****************************************
  WIDGET
 ***************************************/

if(str::length(c::get('plugin.styledmap.license', '')) != 40) {
  // Hi there, play fair and buy a license. Thanks!
  $kirby->set('widget', 'styledmap', __DIR__ . '/widgets/styledmap');
}
