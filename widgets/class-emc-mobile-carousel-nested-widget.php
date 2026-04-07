<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class EMC_Mobile_Carousel_Nested_Widget extends Widget_Base {
    public function get_name() {
        return 'emc_mobile_carousel_nested';
    }

    public function get_title() {
        return esc_html__( 'Mobile Carousel (Nested Templates)', 'emc-mobile-carousel' );
    }

    public function get_icon() {
        return 'eicon-nested-carousel';
    }

    public function get_categories() {
        return [ 'emc-category' ];
    }

    public function get_style_depends() {
        return [ 'emc-widget' ];
    }

    public function get_script_depends() {
        return [ 'emc-widget' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__( 'Slides (Elementor templates)', 'emc-mobile-carousel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'template_id',
            [
                'label'   => esc_html__( 'Template', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_elementor_templates_options(),
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'       => esc_html__( 'Slides', 'emc-mobile-carousel' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => esc_html__( 'Template #{{{ template_id }}}', 'emc-mobile-carousel' ),
            ]
        );

        $this->add_control(
            'templates_hint',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => esc_html__( 'Create slide templates in Templates → Saved Templates. Each selected template is rendered as one slide and can contain any nested Elementor structure.', 'emc-mobile-carousel' ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
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
                'label'   => esc_html__( 'Mobile max width', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 767,
            ]
        );

        $this->add_control(
            'slides_per_view',
            [
                'label'   => esc_html__( 'Slides per view', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1.15,
                'step'    => 0.05,
            ]
        );

        $this->add_control(
            'space_between',
            [
                'label'   => esc_html__( 'Space between', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 12,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'        => esc_html__( 'Autoplay', 'emc-mobile-carousel' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label'     => esc_html__( 'Autoplay delay (ms)', 'emc-mobile-carousel' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 2500,
                'condition' => [ 'autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label'        => esc_html__( 'Arrows', 'emc-mobile-carousel' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'        => esc_html__( 'Pagination', 'emc-mobile-carousel' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'        => esc_html__( 'Loop', 'emc-mobile-carousel' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'        => esc_html__( 'Pause on hover', 'emc-mobile-carousel' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $widget_id = 'emc-carousel-' . $this->get_id();
        $config    = [
            'breakpoint'     => (int) $settings['mobile_breakpoint'],
            'slidesPerView'  => (float) $settings['slides_per_view'],
            'spaceBetween'   => (int) $settings['space_between'],
            'autoplay'       => ( 'yes' === $settings['autoplay'] ),
            'autoplayDelay'  => (int) $settings['autoplay_delay'],
            'showArrows'     => ( 'yes' === $settings['show_arrows'] ),
            'showPagination' => ( 'yes' === $settings['show_pagination'] ),
            'loop'           => ( 'yes' === $settings['loop'] ),
            'pauseOnHover'   => ( 'yes' === $settings['pause_on_hover'] ),
        ];
        ?>
        <div id="<?php echo esc_attr( $widget_id ); ?>" class="emc-mobile-carousel emc-mobile-carousel--nested" data-emc-config='<?php echo wp_json_encode( $config ); ?>'>
            <div class="swiper emc-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $settings['slides'] as $slide ) : ?>
                        <?php $template_id = ! empty( $slide['template_id'] ) ? absint( $slide['template_id'] ) : 0; ?>
                        <?php if ( ! $template_id ) : ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <div class="swiper-slide">
                            <div class="emc-nested-slide-content">
                                <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
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

    private function get_elementor_templates_options() {
        $options = [];

        $templates = get_posts(
            [
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]
        );

        foreach ( $templates as $template ) {
            $options[ $template->ID ] = sprintf( '#%d — %s', $template->ID, $template->post_title );
        }

        return $options;
    }
}
