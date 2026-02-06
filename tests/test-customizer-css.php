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

    echo "Testing CSS Variables Output:
";
    if ( strpos( $output, '--ak-primary-color: #123456;' ) !== false &&
         strpos( $output, '--ak-accent-gold: #abcdef;' ) !== false ) {
        echo "PASS: CSS variables found in output.
";
        return true;
    } else {
        echo "FAIL: CSS variables not found or incorrect.
";
        echo "Output was:
$output
";
        return false;
    }
}

if ( ! test_css_variables_output() ) {
    exit(1);
}
