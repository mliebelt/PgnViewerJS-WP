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
    wp_register_script(
        'pgnviewerjs',
        plugins_url('js/dist.js', __FILE__),
        [],
        '1.6.10',
        true
    );
    wp_register_style(
        'pgnviewerjs-styles',
        plugins_url('css/wp-pgnv.css', __FILE__),
        [],
        '1.6.10'
    );

    // Enqueue scripts and styles conditionally
    if (has_shortcode(get_post()->post_content ?? '', 'pgnv') ||
        has_shortcode(get_post()->post_content ?? '', 'pgne') ||
        has_shortcode(get_post()->post_content ?? '', 'pgnb') ||
        has_shortcode(get_post()->post_content ?? '', 'pgnp')) {
        wp_enqueue_script('pgnviewerjs');
        wp_enqueue_style('pgnviewerjs-styles');
    }
}
add_action('wp_enqueue_scripts', 'pgn_viewer_enqueue_assets');

// Generate the base structure for PGN Viewer
function pgn_viewer_render(array $attributes, string $content = '', string $mode = 'pgnView'): string {
    $loc = get_locale() ?? 'en_US';
    $attributes = shortcode_atts([
        'id' => null,
        'locale' => null,
        'fen' => null,
        'position' => 'start',
        'piecestyle' => null,
        'orientation' => 'white',
        'theme' => 'zeit',
        'boardsize' => '400px',
        'size' => '500px',
        'showcoords' => true,
        'layout' => null,
        'movesheight' => null,
        'colormarker' => null,
        'showresult' => false,
        'coordsinner' => true,
        'coordsfactor' => 1,
        'startplay' => null,
        'headers' => true,
        'notation' => null,
        'notationlayout' => null,
        'showfen' => false,
        'coordsfontsize' => null,
        'timertime' => null,
        'hidemovesbefore' => null,
    ], $attributes, 'shortcodeWPSE');

    // Apply stricter typing for booleans
    $showCoords = filter_var($attributes['showcoords'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    $showResult = filter_var($attributes['showresult'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    $coordsInner = filter_var($attributes['coordsinner'], FILTER_VALIDATE_BOOLEAN);

    $config = array_filter([
        'locale' => $attributes['locale'] ?? $loc,
        'pieceStyle' => $attributes['piecestyle'],
        'orientation' => $attributes['orientation'],
        'theme' => $attributes['theme'],
        'boardSize' => $attributes['boardsize'],
        'width' => $attributes['size'],
        'position' => $attributes['fen'] ?? $attributes['position'],
        'showCoords' => $showCoords,
        'layout' => $attributes['layout'],
        'movesHeight' => $attributes['movesheight'],
        'colorMarker' => $attributes['colormarker'],
        'coordsFactor' => $attributes['coordsfactor'],
        'startPlay' => $attributes['startplay'],
        'headers' => $attributes['headers'],
        'notation' => $attributes['notation'],
        'notationLayout' => $attributes['notationlayout'],
        'showFen' => $attributes['showfen'],
        'coordsFontSize' => $attributes['coordsfontsize'],
        'timerTime' => $attributes['timertime'],
        'hideMovesBefore' => $attributes['hidemovesbefore'],
    ]);

    // Generate unique ID if not provided
    $id = $attributes['id'] ?? generate_random_string();

    // Cleanup PGN content
    $cleanedContent = cleanup_pgnv($content);

    // Generate JavaScript config string
    $configString = '';
    foreach ($config as $key => $value) {
        $configString .= sprintf(", %s: %s", $key, is_bool($value) ? json_encode($value) : "'" . esc_js($value) . "'");
    }

    // Return final output
    return sprintf(
        '<div id="%1$s"></div><script>setTimeout(function () {
            if (typeof PGNV !== "undefined") {
                PGNV.pgnView("%1$s", { pgn: "%3$s" %4$s });
            } else {
                console.error("PGNV is not available even after timeout");
            }
        }, 100); // Delay execution by 100ms</script>',
        esc_attr($id),
        esc_js($mode),
        esc_js($cleanedContent),
        $configString
    );
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