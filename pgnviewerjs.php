<?php

/*
Plugin Name: PgnViewerJS
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Integrates the PgnViewerJS into Wordpress
Version: 0.9.0
Author: Markus Liebelt
Author URI: http://URI_Of_The_Plugin_Author
License: Apache License Version 2.0
*/

function pgnv_js_and_css(){
    $loc = get_locale();
    wp_enqueue_script("jquery");
    wp_enqueue_script('pgnviewerjs', 'http://mliebelt.bplaced.net/pgnvjs/dist/js/pgnviewerjs.js');
    wp_enqueue_style('jqueryui-css', 'http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('chessboard-css', 'http://mliebelt.bplaced.net/pgnvjs/dist/css/chessboard.css');
    wp_enqueue_style('pgnviewerjs-css', 'http://mliebelt.bplaced.net/pgnvjs/dist/css/pgnvjs.css');
}

add_action('wp_enqueue_scripts', 'pgnv_js_and_css');

// [pgnv id=board] 1. e4 e5 2. Nf3 Nc6 3. Bb5 [/pgnv]
function pgnviewer($attributes, $content = NULL) {
    extract( shortcode_atts( array(
        'id' => 'demo',
        'fen' => NULL
    ), $attributes ) );
    $cleaned = cleanup_pgnv($content);
    if (is_null($fen)) {
        $pgnpart = "pgn: '$cleaned'";
    } else {
        $pgn = '[FEN "' . $fen . ']" ' . $cleaned;
        $pgnpart = "pgnString: '$pgn'";
    }

    $float = <<<EOD
<div id="$id" style="width: 400px"></div>
EOD;
    $text = "";
    $text .= var_dump($attributes);
    $text .= "ID: $id ";
    $template = <<<EOD
$float

<script>
    var pgn = '$cleaned';
    pgnView('$id', { $pgnpart });
</script>

EOD;
    return $text . $template;
}

add_shortcode( 'pgnv', 'pgnviewer');

// Cleanup the content, so it will not have any errors. Known are
// * line breaks ==> Spaces
// * Pattern: ... ==> ..
function cleanup_pgnv( $content ) {
    $search = array("...", "&#8230;");
    $replace = array("..", "..");
    $tmp = str_replace($search, $replace, $content);
    return str_replace (array("\r\n", "\n", "\r", "<br />"), ' ', $tmp);
}

?>