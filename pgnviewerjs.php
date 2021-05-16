<?php

/*
Plugin Name: PgnViewerJS
Plugin URI: https://github.com/mliebelt/PgnViewerJS-WP
Description: Integrates the PgnViewerJS into Wordpress
Version: 1.1.2
Author: Markus Liebelt
Author URI: https://github.com/mliebelt
License: Apache License Version 2.0
*/

function pgnv_js_and_css(){
    wp_enqueue_script('pgnviewerjs', plugins_url('js/pgnv.js', __FILE__));
    wp_enqueue_style('pgnviewerjs-css', plugins_url('css/wp-pgnv.css', __FILE__));
    wp_enqueue_style('wp-pgnv-css', plugins_url('css/wp-pgnv.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'pgnv_js_and_css');

// [pgnv id=board pieceStyle=merida locale=fr orientation=black theme=chesscom boardSize=200px size=500px] 1. e4 e5 2. Nf3 Nc6 3. Bb5 [/pgnv]
function pgnbase($attributes, $content = NULL, $mode) {
    $loc = get_locale();
    $args = shortcode_atts( array(
        'id' => NULL,
        'locale' => $loc,
        'fen' => NULL,
        'position' => 'start',
        'piecestyle' => 'merida',
        'orientation' => 'white',
        'theme' => 'zeit',
        'boardsize' => NULL,
        'size' => NULL,
        'showcoords' => true,
        'layout' => NULL,
        'movesheight' => NULL,
        'colormarker' => NULL,
        'showresult' => false,
        'coordsinner' => true,
        'coordsfactor' => 1,
        'startplay' => NULL,
        'headers' => true,
        'notation' => NULL,
        'notationlayout' => NULL,
        'showfen' => false,
        'coordsfontsize' => NULL

    ), $attributes, 'shortcodeWPSE' );
    $id = $args['id'];
    $locale = $args['locale'];
    $fen = $args['fen'];
    $position = $args['position'];
    $piecestyle = $args['piecestyle'];
    $orientation = $args['orientation'];
    $theme = $args['theme'];
    $boardsize = $args['boardsize'];
    $size = $args['size'];
    $showcoords = filter_var( $args['showcoords'], FILTER_VALIDATE_BOOLEAN );
    $layout = $args['layout'];
    $movesheight = $args['movesheight'];
    $colormarker = $args['colormarker'];
    $showresult = $args['showresult'];
    $coordsinner = $args['coordsinner'];
    $coordsfactor = $args['coordsfactor'];
    $startplay = $args['startplay'];
    $headers = $args['headers'];
    $notation = $args['notation'];
    $notationlayout = $args['notationlayout'];
    $showfen = $args['showfen'];
    $coordsfontsize = $args['coordsfontsize'];

    $cleaned = cleanup_pgnv($content);
    error_log("PGN:'" . $cleaned . "'", 0);

    if (is_null($id)) {
        $id = generateRandomString();
    }

    if (!empty($fen)) {
        $position = $fen;
    }
    $showcoords = $showcoords ? 'true' : 'false';

    $text = "Parameters: ";
    $text .= "ID: " . $id;
    $text .= " locale: " . $locale . " piecestyle: " . $piecestyle . " orientation: " . $orientation;
    $text .= " theme: " . $theme . " boardsize: " . $boardsize . " width: " . $size . " position: " . $position ;
    $text .= " showCoords: " . $showcoords . " layout: " . $layout . " movesheight: " . $movesheight;
    $text .= " colormarker: " . $colormarker . " showresult: " . $showresult . " coordsinner: " . $coordsinner;
    $text .= " coordsfactor: " . $coordsfactor . " startplay: " . $startplay . " headers: " . $headers;
    $text .= " showresult: " . $showresult . " notation: " . $notation . " notationLayout: " . $notationlayout;
    $text .= " showfen: " . $showfen . " coordsfontsize: " . $coordsfontsize;

    $config2 = array_filter(array(
        "locale"  => $locale, "pieceStyle" => $piecestyle, "orientation" => $orientation, "theme" => $theme,
        "boardSize" => $boardsize, "width" => $size, "position" => $position, "showCoords" => $showcoords,
        "layout" => $layout, "movesHeight" => $movesheight, "colorMarker" => $colormarker, "showResult" => $showresult,
        "coordsInner" => $coordsinner, "coordsFactor" => $coordsfactor, "startPlay" => $startplay, "headers" => $headers,
        "showResult" => $showresult, "notation" => $notation, "notationLayout" => $notationlayout, "showFen" => $showfen,
        "coordsFontSize" => $coordsfontsize
    ));
    $non_string = array("headers", "showCoords", "coordsInner", "showFen", "hideMovesBefore", "showResult",
        "coordsFactor", "timerTime", "coordsFontSize");
    $config_string = "";
    foreach ($config2 as $key => $value) {
        $config_string .= ", " . $key . ": ";
        if (in_array($key, $non_string)) {
            $config_string .= $value;
        } else {
            $config_string .= "'". $value . "'";
        }
    }

    $float = <<<EOD
<div id="$id"></div>
EOD;
    $template = <<<EOD
$float


<script>
    PGNV.$mode('$id', { pgn: '$cleaned' $config_string});
</script>

EOD;
//   return $text . print_r($config2) . $template;  // Uncomment this  line to see parameters displayed
   return $template;
}

function pgnviewer($attributes, $content) {
    return pgnbase($attributes, $content, "pgnView");
}

function pgnedit($attributes, $content) {
    return pgnbase($attributes, $content, "pgnEdit");
}

function pgnboard($attributes, $content) {
    return pgnbase($attributes, $content, "pgnBoard");
}

function pgnprint($attributes, $content) {
    return pgnbase($attributes, $content, "pgnPrint");
}


add_shortcode( 'pgnv', 'pgnviewer');
add_shortcode( 'pgne', 'pgnedit');
add_shortcode( 'pgnb', 'pgnboard');
add_shortcode( 'pgnp', 'pgnprint');

// Cleanup the content, so it will not have any errors. Known are
// * line breaks ==> Spaces
// * Pattern: ... ==> ..
function cleanup_pgnv( $string ) {
    $search = array("...", "&#8230;", '&#8221;', '&#8220;', '&#8222;');
    $replace = array("..", "..", '"', '"', '"');
    $tmp = str_replace($search, $replace, $string);
    $tmp = str_replace (array("\r\n", "\n", "\r", "<br />", "<br>", "<p>", "</p>", "&nbsp;"), ' ', $tmp);
    $tmp = trim($tmp," \t\n\r");
    $tmp = preg_replace('~\xc2\xa0~', ' ', $tmp);
    return preg_replace('/\s+/', ' ', $tmp);
}

// Taken from https://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    return 'id' . substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

?>