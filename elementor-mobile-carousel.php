<?php
/**
 * Plugin Name: Elementor Mobile Carousel Widget
 * Description: Custom Elementor widget with mobile-only carousel features: autoplay, arrows, pagination, and loop.
 * Version: 1.0.0
 * Author: Perplexity
 * Requires Plugins: elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class EMC_Elementor_Mobile_Carousel_Plugin {
    const VERSION = '1.0.0';

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    public function init() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }

        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
    }

    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        echo '<div class="notice notice-warning is-dismissible"><p><strong>Elementor Mobile Carousel Widget</strong> requires Elementor to be installed and activated.</p></div>';
    }

    public function register_assets() {
        wp_register_style(
            'emc-swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            [],
            '11.1.14'
        );

        wp_register_script(
            'emc-swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            '11.1.14',
            true
        );

        wp_register_style(
            'emc-widget',
            plugins_url( 'assets/widget.css', __FILE__ ),
            [ 'emc-swiper' ],
            self::VERSION
        );

        wp_register_script(
            'emc-widget',
            plugins_url( 'assets/widget.js', __FILE__ ),
            [ 'jquery', 'emc-swiper' ],
            self::VERSION,
            true
        );
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category(
            'emc-category',
            [
                'title' => esc_html__( 'EMC Widgets', 'emc-mobile-carousel' ),
                'icon'  => 'fa fa-plug',
            ]
        );
    }

    public function register_widgets( $widgets_manager ) {
        require_once __DIR__ . '/widgets/class-emc-mobile-carousel-widget.php';
        $widgets_manager->register( new \EMC_Mobile_Carousel_Widget() );

        // Optional: Nested variant (Elementor "Nested Elements" experiment).
        // The widget file self-guards if required core classes are missing.
        require_once __DIR__ . '/widgets/class-emc-mobile-carousel-nested-widget.php';
        if ( class_exists( '\\EMC_Mobile_Carousel_Nested_Widget' ) ) {
            $widgets_manager->register( new \EMC_Mobile_Carousel_Nested_Widget() );
        }
    }
}

new EMC_Elementor_Mobile_Carousel_Plugin();
