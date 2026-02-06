<?php
/**
 * Simple test script for Customizer CSS Variables
 */

// Mock WordPress functions
function esc_html( $text ) { return $text; }
function get_theme_mod( $name, $default = false ) {
    $mods = [
        'primary_color' => '#123456',
        'accent_gold'   => '#abcdef',
        'site_bg_color' => '#f0f0f0',
        'header_bg_color' => '#ffffff',
        'footer_bg_color' => '#222222',
        'body_text_color' => '#333333',
        'heading_text_color' => '#000000',
        'link_color' => '#0000ee',
        'link_hover_color' => '#ee0000',
    ];
    return isset( $mods[ $name ] ) ? $mods[ $name ] : $default;
}
function add_action( $hook, $callback ) {}

// Include the file to test
require_once __DIR__ . '/../inc/customizer.php';

function test_css_variables_output() {
    ob_start();
    // This is where the function we are about to write will be called.
    if ( function_exists( 'aspiring_knight_output_css_variables' ) ) {
        aspiring_knight_output_css_variables();
    }
    $output = ob_get_clean();

    echo "Testing CSS Variables Output:\n";
    $expected = [
        '--ak-primary-color: #123456;',
        '--ak-accent-gold: #abcdef;',
        '--ak-site-bg: #f0f0f0;',
        '--ak-header-bg: #ffffff;',
        '--ak-footer-bg: #222222;',
        '--ak-body-text: #333333;',
        '--ak-heading-text: #000000;',
        '--ak-link-color: #0000ee;',
        '--ak-link-hover-color: #ee0000;',
    ];

    $failed = false;
    foreach ($expected as $line) {
        if ( strpos( $output, $line ) === false ) {
            echo "FAIL: Expected line not found: $line\n";
            $failed = true;
        }
    }

    if (!$failed) {
        echo "PASS: All CSS variables found in output.\n";
        return true;
    } else {
        echo "Output was:\n$output\n";
        return false;
    }
}

if ( ! test_css_variables_output() ) {
    exit(1);
}
