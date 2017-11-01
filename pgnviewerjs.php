<?php

/*
Plugin Name: PgnViewerJS
Plugin URI: https://github.com/mliebelt/PgnViewerJS-WP
Description: Integrates the PgnViewerJS into Wordpress
Version: 0.9.5
Author: Markus Liebelt
Author URI: https://github.com/mliebelt
License: Apache License Version 2.0
*/

function pgnv_js_and_css(){
    $loc = get_locale();
    wp_enqueue_script("jquery");
    wp_enqueue_script('pgnviewerjs', plugins_url('js/pgnvjs.js', __FILE__));
    //wp_enqueue_style('jqueryui-css', 'http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('pgnviewerjs-css', plugins_url('css/pgnvjs.css', __FILE__));
    wp_enqueue_style('wp-pgnv-css', plugins_url('css/wp-pgnv.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'pgnv_js_and_css');

// [pgnv id=board pieceStyle=merida locale=fr orientation=black theme=chesscom boardSize=200px size=500px] 1. e4 e5 2. Nf3 Nc6 3. Bb5 [/pgnv]
function pgnbase($attributes, $content = NULL, $mode) {
    extract( shortcode_atts( array(
        'id' => NULL,
        'locale' => "en",
        'fen' => NULL,
        'position' => NULL,
        'piecestyle' => 'merida',
        'orientation' => 'white',
        'theme' => NULL,
        'boardsize' => NULL,
        'size' => '400px',
        'scrollbar' => false
    ), $attributes ) );
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

    $text = "Parameters: ";
    $text .= "ID: " . $id;
    $text .= " locale: " . $locale . " fen: " . $fen . " piecestyle: " . $piecestyle . " orientation: " . $orientation . " theme: " . $theme;
    $text .= " boardsize: " . $boardsize . " size: " . $size . " position: " . $position;

    $float = <<<EOD
<div id="$id" style="width: $size"></div>
EOD;
    $template = <<<EOD
$float


<script>
    $mode('$id', { $pgnpart, position: '$fen', orientation: '$orientation', pieceStyle: '$piecestyle', theme: '$theme', boardSize: '$boardsize', size: '$size', locale: '$locale', scrollbar: '$scrollbar' });
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
    $search = array("...", "&#8230;", '&#8221;', '&#8220;');
    $replace = array("..", "..", '"', '"');
    $tmp = str_replace($search, $replace, $content);
    return str_replace (array("\r\n", "\n", "\r", "<br />"), ' ', $tmp);
}

// Taken from https://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

?>