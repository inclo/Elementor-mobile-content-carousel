<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Nested elements (containers inside a repeater) are an experimental feature in Elementor.
// This widget is only available when the required core classes exist.
if ( ! class_exists( '\\Elementor\\Modules\\NestedElements\\Base\\Widget_Nested_Base' ) ) {
    return;
}

if ( ! class_exists( '\\Elementor\\Modules\\NestedElements\\Controls\\Control_Nested_Repeater' ) ) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;
use Elementor\Repeater;

class EMC_Mobile_Carousel_Nested_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

    public function get_name() {
        return 'emc_mobile_carousel_nested';
    }

    public function get_title() {
        return esc_html__( 'Mobile Carousel (Nested)', 'emc-mobile-carousel' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return [ 'emc-category' ];
    }

    public function show_in_panel() {
        // Match Elementor Pro Nested Carousel gating: nested-elements + container experiments.
        if ( ! class_exists( '\\Elementor\\Plugin' ) ) {
            return false;
        }

        $experiments = \Elementor\Plugin::instance()->experiments;

        return $experiments
            && $experiments->is_feature_active( 'nested-elements' )
            && $experiments->is_feature_active( 'container' );
    }

    public function get_style_depends() {
        return [ 'emc-widget' ];
    }

    public function get_script_depends() {
        return [ 'emc-widget' ];
    }

    protected function get_default_children_elements() {
        return [
            [
                'elType' => 'container',
                'settings' => [
                    '_title' => __( 'Slide #1', 'emc-mobile-carousel' ),
                ],
            ],
            [
                'elType' => 'container',
                'settings' => [
                    '_title' => __( 'Slide #2', 'emc-mobile-carousel' ),
                ],
            ],
            [
                'elType' => 'container',
                'settings' => [
                    '_title' => __( 'Slide #3', 'emc-mobile-carousel' ),
                ],
            ],
        ];
    }

    protected function get_default_repeater_title_setting_key() {
        return 'slide_title';
    }

    protected function get_default_children_title() {
        return esc_html__( 'Slide #%d', 'emc-mobile-carousel' );
    }

    protected function get_default_children_placeholder_selector() {
        return '.swiper-wrapper';
    }

    protected function get_default_children_container_placeholder_selector() {
        return '.swiper-slide';
    }

    protected function get_initial_config(): array {
        return array_merge( parent::get_initial_config(), [
            'support_improved_repeaters' => true,
            'target_container' => [ '.emc-swiper > .swiper-wrapper' ],
            'node' => 'div',
            'is_interlaced' => true,
        ] );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__( 'Slides', 'emc-mobile-carousel' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'slide_title',
            [
                'label' => esc_html__( 'Title', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Slide Title', 'emc-mobile-carousel' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'carousel_name',
            [
                'label' => esc_html__( 'Carousel Name', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Carousel', 'emc-mobile-carousel' ),
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label' => esc_html__( 'Carousel Items', 'emc-mobile-carousel' ),
                'type' => Control_Nested_Repeater::CONTROL_TYPE,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'slide_title' => esc_html__( 'Slide #1', 'emc-mobile-carousel' ) ],
                    [ 'slide_title' => esc_html__( 'Slide #2', 'emc-mobile-carousel' ) ],
                    [ 'slide_title' => esc_html__( 'Slide #3', 'emc-mobile-carousel' ) ],
                ],
                'frontend_available' => true,
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'emc-mobile-carousel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__( 'Mobile max width', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 767,
            ]
        );

        $this->add_control(
            'slides_per_view',
            [
                'label' => esc_html__( 'Slides per view', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 1.15,
                'step' => 0.05,
            ]
        );

        $this->add_control(
            'space_between',
            [
                'label' => esc_html__( 'Space between', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 12,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => esc_html__( 'Autoplay delay (ms)', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 2500,
                'condition' => [ 'autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__( 'Arrows', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Pagination', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__( 'Loop', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__( 'Pause on hover', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = 'emc-carousel-' . $this->get_id();

        $config = [
            'breakpoint' => (int) $settings['mobile_breakpoint'],
            'slidesPerView' => (float) $settings['slides_per_view'],
            'spaceBetween' => (int) $settings['space_between'],
            'autoplay' => ( 'yes' === $settings['autoplay'] ),
            'autoplayDelay' => (int) $settings['autoplay_delay'],
            'showArrows' => ( 'yes' === $settings['show_arrows'] ),
            'showPagination' => ( 'yes' === $settings['show_pagination'] ),
            'loop' => ( 'yes' === $settings['loop'] ),
            'pauseOnHover' => ( 'yes' === $settings['pause_on_hover'] ),
        ];

        $slides = $settings['carousel_items'] ?? [];
        $aria_label = ! empty( $settings['carousel_name'] ) ? $settings['carousel_name'] : 'Carousel';
        ?>
        <div id="<?php echo esc_attr( $widget_id ); ?>" class="emc-mobile-carousel emc-mobile-carousel--nested" aria-label="<?php echo esc_attr( $aria_label ); ?>" data-emc-config='<?php echo wp_json_encode( $config ); ?>'>
            <div class="swiper emc-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $slides as $index => $slide ) : ?>
                        <div class="swiper-slide">
                            <?php $this->print_child( $index ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="emc-nav emc-nav-prev" aria-label="Previous slide"></div>
                <div class="emc-nav emc-nav-next" aria-label="Next slide"></div>
                <div class="emc-pagination"></div>
            </div>
        </div>
        <?php
    }

    protected function content_template_single_repeater_item() {
        ?>
        <#
        const slideWrapperKeyItem = {
            'class': 'swiper-slide',
        };
        view.addRenderAttribute( 'single-slide', slideWrapperKeyItem, null, true );
        #>
        <div {{{ view.getRenderAttributeString( 'single-slide' ) }}}></div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        if ( settings.carousel_items ) {
            const elementUid = view.getIDInt().toString().substr( 0, 3 ),
                wrapperKey = 'emc-wrapper-' + elementUid,
                swiperKey = 'emc-swiper-' + elementUid,
                swiperInsideKey = 'emc-swiper-inside-' + elementUid;

            view.addRenderAttribute( wrapperKey, {
                'class': 'emc-mobile-carousel emc-mobile-carousel--nested',
                'data-emc-config': JSON.stringify({})
            } );

            view.addRenderAttribute( swiperKey, {
                'class': 'swiper emc-swiper'
            } );

            view.addRenderAttribute( swiperInsideKey, {
                'class': 'swiper-wrapper'
            } );
        #>
            <div {{{ view.getRenderAttributeString( wrapperKey ) }}}>
                <div {{{ view.getRenderAttributeString( swiperKey ) }}}>
                    <div {{{ view.getRenderAttributeString( swiperInsideKey ) }}}>
                        <# _.each( settings.carousel_items, function( slide, index ) { #>
                            <div class="swiper-slide"></div>
                        <# } ); #>
                    </div>
                    <div class="emc-nav emc-nav-prev" aria-label="Previous slide"></div>
                    <div class="emc-nav emc-nav-next" aria-label="Next slide"></div>
                    <div class="emc-pagination"></div>
                </div>
            </div>
        <# } #>
        <?php
    }
}
