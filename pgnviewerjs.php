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
    error_log("PGN:'" . $cleaned . "'", 0);

    if (is_null($id)) {
        $id = generateRandomString();
    }

    if (!empty($fen)) {
        $position = $fen;
    }
    //$scrollable = $scrollable ? 'true' : 'false';
    $showNotation = $showNotation ? 'true' : 'false';

    $text = "Parameters: ";
    $text .= "ID: " . $id;
    $text .= " loc: " . $loc . " locale: " . $locale . " piecestyle: " . $piecestyle . " orientation: " . $orientation;
    $text .= " theme: " . $theme . " boardsize: " . $boardsize . " width: " . $size . " position: " . $position ;
    $text .= " showNotation: " . $showNotation . " layout: " . $layout . " movesheight: " . $movesheight;
    $text .= " colormarker: " . $colormarker . " showresult: " . $showresult . " coordsinner: " . $coordsinner;
    $text .=  " coordsfactor: " . $coordsfactor . " startplay: " . $startplay . " headers: " . $headers;

    $float = <<<EOD
<div id="$id"></div>
EOD;
    $template = <<<EOD
$float


<script>
    PGNV.$mode('$id', { pgn: '$cleaned', position: '$position', orientation: '$orientation', pieceStyle: '$piecestyle', theme: '$theme', boardSize: '$boardsize', width: '$size', locale: '$locale', showNotation: $showNotation, layout: '$layout', movesHeight: '$movesheight', colorMarker: '$colormarker', showResult: '$showresult', coordsInner: '$coordsinner', coordsFactor: '$coordsfactor', startPlay: '$startplay', headers: '$headers'});
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