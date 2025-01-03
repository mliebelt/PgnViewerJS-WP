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
    global $post;
    if ($post && (
        has_shortcode($post->post_content, 'pgnv') ||
        has_shortcode($post->post_content, 'pgne') ||
        has_shortcode($post->post_content, 'pgnb') ||
        has_shortcode($post->post_content, 'pgnp') ||
        has_block('pgn-viewer/block-editor', $post->post_content)
    )) {
        wp_enqueue_script('pgnviewerjs');
        wp_enqueue_style('pgnviewerjs-styles');
    }

    wp_register_script(
        'pgnviewerjs', plugins_url('js/dist.js', __FILE__), [], '1.6.10', true);
    wp_register_style(
        'pgnviewerjs-styles', plugins_url('css/wp-pgnv.css', __FILE__), [], '1.6.10');
}
add_action('wp_enqueue_scripts', 'pgn_viewer_enqueue_assets');
add_action('enqueue_block_editor_assets', 'pgn_viewer_enqueue_scripts');

// helper for formatting the  attributes in JSON
function format_attribute_value($key, $value) {
    $boolean_attributes = ['headers', 'showCoords', 'coordsInner', 'resizable'];
    $integer_attributes = ['timertime', 'coordsFontSize'];
    $float_attributes = ['coordsFactor'];

    if (in_array($key, $boolean_attributes)) {
            return $value ? 'true' : 'false';
        } elseif (in_array($key, $integer_attributes)) {
            return is_numeric($value) ? (int)$value : 'null';
        } elseif (in_array($key, $float_attributes)) {
            return is_numeric($value) ? (float)$value : 'null';
        } else {
            return json_encode($value);
        }
}

function pgn_viewer_render(array $attributes, string $content = '', string $mode = 'pgnView'): string {
    ob_start();
    // Extract block attributes
    $position = $attributes['position'] ?? '';
    $pgn = $content ?: ''; // Use empty string if content is null or empty
    $layout = $attributes['layout'] ?? 'left';
    $orientation = $attributes['orientation'] ?? 'white';
    $piecestyle = $attributes['piecestyle'] ?? 'merida';
    $theme = $attributes['theme'] ?? 'zeit';
    $boardsize = $attributes['boardsize'] ?? '400px';
    $width = $attributes['width'] ?? '500px';
    $movesheight = $attributes['movesheight'] ?? null;
    $moveswidth = $attributes['moveswidth'] ?? null;
    $timertime = $attributes['timertime'] ?? null;
    $notationLayout = $attributes['notationLayout'] ?? 'inline';
    $notation = $attributes['notation'] ?? 'short';
    $headers = $attributes['headers'] ?? true;
    $showCoords = isset($attributes['showCoords']) ? filter_var($attributes['showCoords'], FILTER_VALIDATE_BOOLEAN) : true;
    $coordsInner = isset($attributes['coordsInner']) ? filter_var($attributes['coordsInner'], FILTER_VALIDATE_BOOLEAN) : true;
    $coordsFactor = $attributes['coordsFactor'] ?? 1;
    $coordsFontSize = $attributes['coordsFontSize'] ?? null;
    $figurine = $attributes['figurine'] ?? null;
    $locale = $attributes['locale'] ?? 'en';
    $resizable = $attributes['resizable'] ?? true;
    $colorMarker = $attributes['colorMarker'] ?? null;
    $figurine = $attributes['figurine'] ?? '';


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
            'notationLayout' => $notationLayout,
            'timerTime' => $timertime,
            'notation' => $notation,
            'headers' => $headers,
            'showCoords' => $showCoords,
            'coordsInner' => $coordsInner,
            'coordsFactor' => $coordsFactor,
            'coordsFontSize' => $coordsFontSize,
            'layout' => $layout,
            'figurine' => $figurine,
            'locale' => $locale,
            'resizable' => $resizable,
            'colorMarker' => $colorMarker,
            'figurine' => $figurine,
        ], function($value) { return $value !== null && $value !== ''; });

    // Modify the JavaScript initialization based on the mode
        $jsFunction = $mode;

        // Generate the config string with proper type handling
        $configString = '';
        foreach ($config as $key => $value) {
            $formattedValue = format_attribute_value($key, $value);
            $configString .= sprintf('"%s": %s,', esc_attr($key), $formattedValue);
        }
        $configString = rtrim($configString, ','); // Remove trailing comma


        // Render the PGN Viewer block
        $output = sprintf(
            '<div id="%s" class="pgn-viewer-block-wrapper"></div>
            <script type="application/javascript">
                setTimeout(function () {
                    if (typeof PGNV !== "undefined") {
                        console.log("Initializing PGNV");
                        PGNV.%s("%s", { %s });
                    } else {
                        console.error("PGNV is not loaded properly!");
                    }
                }, 100);
            </script>',
            esc_attr($id),
            $mode,
            esc_attr($id),
            $configString
        );
        return $output;
}

// Shortcode callbacks
function pgn_viewer_shortcode(array $attributes, string $content = ''): string {
    return pgn_viewer_render($attributes, $content, 'pgnView');
}

function pgn_board_shortcode(array $attributes, string $content = ''): string {
    return pgn_viewer_render($attributes, $content, 'pgnBoard');
}

function pgn_edit_shortcode(array $attributes, string $content = ''): string {
    return pgn_viewer_render($attributes, $content, 'pgnEdit');
}

function pgn_print_shortcode(array $attributes, string $content = ''): string {
    return pgn_viewer_render($attributes, $content, 'pgnPrint');
}
add_shortcode('pgnv', 'pgn_viewer_shortcode');
add_shortcode('pgnb', 'pgn_board_shortcode');
add_shortcode('pgne', 'pgn_edit_shortcode');
add_shortcode('pgnp', 'pgn_print_shortcode');

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
    // Frontend and editor styles
    wp_enqueue_style(
        'pgnviewerjs-styles',
        plugins_url('css/pgnv_styles.css', __FILE__),
        [],
        '1.6.10'
    );

    // Block editor script
    wp_enqueue_script(
        'pgnviewerjs-editor',
        plugins_url('build/index.js', __FILE__),
        ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components'],
        '1.6.10',
        true
    );
}
add_action('enqueue_block_assets', 'pgnv_block_assets');
add_action('enqueue_block_editor_assets', 'pgnv_block_assets');

// Registration of element block
function pgn_viewer_register_block() {
    if (function_exists('register_block_type')) {
        register_block_type('pgn-viewer/block-editor', array(
            'editor_script' => 'pgnviewerjs-editor',
            'render_callback' => 'pgn_viewer_render_block'
        ));
    }
}
add_action('init', 'pgn_viewer_register_block');

function pgn_viewer_render_block($attributes, $content) {
    $mode = $attributes['mode'] ?? 'view';
    $jsFunction = 'pgn' . ucfirst($mode); // This will create pgnView, pgnEdit, pgnPrint, or pgnBoard

    // Use content if pgn is not set in attributes
    $pgn = $attributes['pgn'] ?? $content;

    return pgn_viewer_render($attributes, $pgn, $jsFunction);
}
