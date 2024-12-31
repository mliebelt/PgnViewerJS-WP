<?php
declare(strict_types=1);

/*
Plugin Name: PgnViewerJS
Plugin URI: https://github.com/mliebelt/pgn-viewer
Description: Integrates the PgnViewerJS into WordPress
Version: 1.6.10
Author: Markus Liebelt
Author URI: https://github.com/mliebelt
License: Apache License Version 2.0
Text Domain: pgn-viewer
Domain Path: /languages
*/

// Load plugin text domain for translations
function pgn_viewer_load_textdomain(): void {
    load_plugin_textdomain('pgn-viewer', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'pgn_viewer_load_textdomain');

// Register and enqueue scripts and styles
function pgn_viewer_enqueue_assets(): void {

    // Enqueue scripts and styles conditionally
//    if (has_shortcode(get_post()->post_content ?? '', 'pgnv') ||
//        has_shortcode(get_post()->post_content ?? '', 'pgne') ||
//        has_shortcode(get_post()->post_content ?? '', 'pgnb') ||
//        has_shortcode(get_post()->post_content ?? '', 'pgnp')) {
        wp_enqueue_script('pgnviewerjs');
        wp_enqueue_style('pgnviewerjs-styles');
//    }
    wp_register_script(
        'pgnviewerjs', plugins_url('js/dist.js', __FILE__), [], '1.6.10', true);
    wp_register_style(
        'pgnviewerjs-styles', plugins_url('css/wp-pgnv.css', __FILE__), [], '1.6.10');
}
add_action('wp_enqueue_scripts', 'pgn_viewer_enqueue_assets');

function pgn_viewer_render(array $attributes, string $content = '', string $mode = 'pgnView'): string {
    ob_start();
    // Extract block attributes
    $position = $attributes['position'] ?? '';
    $pgn = $content;
    $layout = $attributes['layout'] ?? 'left';
    $orientation = $attributes['orientation'] ?? 'white';
    $piecestyle = $attributes['piecestyle'] ?? 'merida';
    $theme = $attributes['theme'] ?? 'zeit';
    $boardsize = $attributes['boardsize'] ?? '400px';
    $width = $attributes['width'] ?? '500px';
    $movesheight = $attributes['movesheight'] ?? null;
    $moveswidth = $attributes['moveswidth'] ?? null;
    $timertime = $attributes['timertime'] ?? null;
    $notationlayout = $attributes['notationlayout'] ?? 'inline';
    $notation = $attributes['notation'] ?? 'short';
    $headers = $attributes['headers'] ?? true;
    $showcoords = $attributes['showcoords'] ?? true;
    $coordsinner = $attributes['coordsinner'] ?? true;
    $figurine = $attributes['figurine'] ?? null;
    $locale = $attributes['locale'] ?? 'en';

    // Generate unique ID for the block
    $id = $attributes['id'] ?? generate_random_string();

    // Build config options passed to the viewer
    $config = array_filter([
        'position' => $position,
        'pgn' => $pgn,
        'orientation' => $orientation,
        'pieceStyle' => $piecestyle,
        'theme' => $theme,
        'boardSize' => $boardsize,
        'width' => $width,
        'movesHeight' => $movesheight,
        'movesWidth' => $moveswidth,
        'notationLayout' => $notationlayout, // inline / list
        'timerTime' => $timertime, // in millis
        'notation' => $notation, // short / long
        'headers' => $headers,
        'showCoords' => $showcoords,
        'coordsInner' => $coordsinner,
        'layout' => $layout, // left / right / top / bottom
        'figurine' => $figurine, // alpha / merida / berlin / noto / cachess
        'locale' => $locale,
    ]);

    // Generate the layout structure with attributes
    $layout = '';
    $configString = '';
    foreach ($config as $key => $value) {
        $configString .= sprintf("\"%s\": \"%s\" ,", esc_attr($key), esc_attr($value));
    }
    error_log('Config string is: ' . $configString);


    // Render the PGN Viewer block
    $output = sprintf(
        '<div id="%s" class="pgn-viewer-block-wrapper"></div>
        <script type="application/javascript">
            setTimeout(function () {
                if (typeof PGNV !== "undefined") {
                    console.log("Initializing PGNV");
                    PGNV.pgnView("%s", { %s });
                } else {
                    console.error("PGNV is not loaded properly!");
                }
            }, 500);
        </script>',
        esc_attr($id), // ID
        esc_attr($id), // Viewer JS initialization
        $configString
    );
    return $output;
}

// Shortcode callbacks
function pgn_viewer_shortcode(array $attributes, string $content = ''): string {
    return pgn_viewer_render($attributes, $content, 'pgnView');
}
add_shortcode('pgnv', 'pgn_viewer_shortcode');

// Utility: PGN Cleaning
function cleanup_pgnv(string $string): string {
    $search = [
        '…', '...', '&#8230;', '&#8221;', '&#8220;', '&#8222;',
        "\r\n", "\n", "\r", '<br />', '<br>', '<p>', '</p>', '&nbsp;'
    ];
    $replace = [
        '...', '...', '...', '"', '"', '"',
        ' ', ' ', ' ', '', '', '', '', ' '
    ];
    $string = str_replace($search, $replace, $string);
    return esc_html(trim(preg_replace('/\s+/', ' ', $string)));
}

// Generate random string
function generate_random_string(int $length = 10): string {
    return 'id' . wp_generate_uuid4();
}

// Enqueue scripts and styles for the block editor and frontend
function pgnv_block_assets() {
    // Frontend styles
    wp_enqueue_style(
        'pgnviewerjs-styles-front',
        plugins_url('css/pgnv_styles.css', __FILE__),
        [],
        '1.6.10'
    );

    // Editor styles (for block editor)
    wp_enqueue_style(
        'pgnviewerjs-styles-editor',
        plugins_url('css/pgnv_styles.css', __FILE__),
        ['wp-edit-blocks'], // Depends on the default editor styles
        '1.6.10'
    );

    // Block-specific editor script
    wp_enqueue_script(
        'pgnviewerjs-editor',
        plugins_url('build/index.js', __FILE__), // Replace with correct path to your block code
        ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'], // Dependencies
        '1.6.10',
        true
    );
}
add_action('enqueue_block_assets', 'pgnv_block_assets');
