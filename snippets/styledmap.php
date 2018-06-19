<?php
    // SNIPPET: $location, $snippet_style, $snippet_markers, $centerData
    //

    if (!isset($page)) {
        $page = null;
    }
    if (!isset($title)) {
        $title = '';
    }
    if (!isset($centerData)) {
        $centerData = [];
    }

    $w = c::get('plugin.styledmap.width', c::get('kirbytext.video.width', '100%'));
    $h = c::get('plugin.styledmap.height', c::get('kirbytext.video.height', '500px'));
    $style = 'width:'.$w.';height:'.$h.';';

    $varname = '_'. md5($location.$title.$snippet_style);

    $smMap = brick('div')
        ->attr('id', c::get('plugin.styledmap.mapid', 'styledmap'.$varname))
        ->attr('style', c::get('plugin.styledmap.cssstyle', $style))
        ->addClass(c::get('plugin.styledmap.mapclass', 'styledmap'));

    $smScriptInit = snippet(c::get('plugin.styledmap.jsinit', 'styledmap-jsinit'), [
        'center' 	=> styledmapLocation($page, $location, $title, $centerData),
        'style'		=> $snippet_style,
        'markers' 	=> $snippet_markers,
        'page'		=> $page,
        'varname'   => $varname,
        ], true);
    
    $smScriptAPI = snippet(c::get('plugin.styledmap.jsapi', 'styledmap-jsapi'), [
        'varname'   => $varname,
    ], true);

    $smContainer = brick('div')
        ->addClass(c::get('plugin.styledmap.containerclass', 'styledmap-container'))
        ->append($smMap)
        ->append($smScriptInit)
        ->append($smScriptAPI)
        ;

    echo $smContainer;
