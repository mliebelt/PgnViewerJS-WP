<?php

/*
Plugin Name: PgnViewerJS
Plugin URI: https://github.com/mliebelt/PgnViewerJS-WP
Description: Integrates the PgnViewerJS into Wordpress
Version: 0.9.7
Author: Markus Liebelt
Author URI: https://github.com/mliebelt
License: Apache License Version 2.0
*/

function pgnv_js_and_css(){
    //wp_enqueue_script("jquery");  // no need of jQuery any more
    wp_enqueue_script('pgnviewerjs', plugins_url('js/pgnvjs.js', __FILE__));
    //wp_enqueue_style('jqueryui-css', 'http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('pgnviewerjs-css', plugins_url('css/pgnvjs.css', __FILE__));
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
        'theme' => 'blue',
        'boardsize' => NULL,
        'size' => '400px',
        'show_notation' => 1,
        'layout' => NULL,
        'movesheight' => NULL,
        'colormarker' => NULL,
        'showresult' => false,
        'coordsinner' => true,
        'coordsfactor' => 1,
        'startplay' => NULL,
        'headers' => true

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
    //$scrollable = filter_var( $args['scrollable'], FILTER_VALIDATE_BOOLEAN );
    $showNotation = filter_var( $args['show_notation'], FILTER_VALIDATE_BOOLEAN );
    $layout = $args['layout'];
    $movesheight = $args['movesheight'];
    $colormarker = $args['colormarker'];
    $showresult = $args['showresult'];
    $coordsinner = $args['coordsinner'];
    $coordsfactor = $args['coordsfactor'];
    $startplay = $args['startplay'];
    $headers = $args['headers'];

    $cleaned = cleanup_pgnv($content);
//    if (is_null($fen)) {
        $pgnpart = "pgn: '$cleaned'";
//    } else {
//        $pgn = '[FEN "' . $fen . '"] ' . $cleaned;
//        $pgnpart = "pgnString: '$pgn'";
//    }
    if (is_null($id)) {
        $id = generateRandomString();
    }

    if (is_null($fen)) {
        $fen = $position;
    }
    //$scrollable = $scrollable ? 'true' : 'false';
    $showNotation = $showNotation ? 'true' : 'false';

    $text = "Parameters: ";
    $text .= "ID: " . $id;
    $text .= " loc: " . $loc . " locale: " . $locale . " fen: " . $fen . " piecestyle: " . $piecestyle . " orientation: " . $orientation . " theme: " . $theme;
    $text .= " boardsize: " . $boardsize . " width: " . $size . " position: " . $position . " showNotation: " . $showNotation . " layout: " . $layout . " movesheight: " . $movesheight;
    $text .= " colormarker: " . $colormarker . " showresult: " . $showresult . " coordsinner: " . $coordsinner . " coordsfactor: " . $coordsfactor . " startplay: " . $startplay . " headers: " . $headers;

    $float = <<<EOD
<div id="$id" style="width: $size"></div>
EOD;
    $template = <<<EOD
$float


<script>
    $mode('$id', { pgn: '$cleaned', position: '$position', orientation: '$orientation', pieceStyle: '$piecestyle', theme: '$theme', boardSize: '$boardsize', width: '$size', locale: '$locale', showNotation: $showNotation, layout: '$layout', movesHeight: '$movesheight', colorMarker: '$colormarker', showResult: '$showresult', coordsInner: '$coordsinner', coordsFactor: '$coordsfactor', startPlay: '$startplay', headers: '$headers'});
</script>

EOD;
   //return $text . $template;  // Uncomment this  line to see parameters displayed
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
function cleanup_pgnv( $content ) {
    $search = array("...", "&#8230;", '&#8221;', '&#8220;', '&#8222;');
    $replace = array("..", "..", '"', '"', '"');
    $tmp = str_replace($search, $replace, $content);
    return str_replace (array("\r\n", "\n", "\r", "<br />"), ' ', $tmp);
}

// Taken from https://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    return 'id' . substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

?>