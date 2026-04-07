<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class EMC_Mobile_Carousel_Widget extends Widget_Base {
    public function get_name() {
        return 'emc_mobile_carousel';
    }

    public function get_title() {
        return esc_html__( 'Mobile Carousel', 'emc-mobile-carousel' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
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
                'label' => esc_html__( 'Slides', 'emc-mobile-carousel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'   => esc_html__( 'Title', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Card title', 'emc-mobile-carousel' ),
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label'   => esc_html__( 'Text', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Short description for this card.', 'emc-mobile-carousel' ),
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label'   => esc_html__( 'Button text', 'emc-mobile-carousel' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Learn more', 'emc-mobile-carousel' ),
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label'       => esc_html__( 'Button link', 'emc-mobile-carousel' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'       => esc_html__( 'Slides', 'emc-mobile-carousel' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'title' => 'Card 1', 'text' => 'Description for card 1.' ],
                    [ 'title' => 'Card 2', 'text' => 'Description for card 2.' ],
                    [ 'title' => 'Card 3', 'text' => 'Description for card 3.' ],
                ],
                    'title_field' => '{{{ title }}}',
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

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Card', 'emc-mobile-carousel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg',
            [
                'label' => esc_html__( 'Background', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .emc-card' => 'background: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title color', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#111111',
                'selectors' => [ '{{WRAPPER}} .emc-card__title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text color', 'emc-mobile-carousel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [ '{{WRAPPER}} .emc-card__text' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .emc-card__title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .emc-card__text',
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
        ?>
        <div id="<?php echo esc_attr( $widget_id ); ?>" class="emc-mobile-carousel" data-emc-config='<?php echo wp_json_encode( $config ); ?>'>
            <div class="swiper emc-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $settings['slides'] as $slide ) : ?>
                        <div class="swiper-slide">
                            <div class="emc-card">
                                <?php if ( ! empty( $slide['title'] ) ) : ?>
                                    <h3 class="emc-card__title"><?php echo esc_html( $slide['title'] ); ?></h3>
                                <?php endif; ?>

                                <?php if ( ! empty( $slide['text'] ) ) : ?>
                                    <div class="emc-card__text"><?php echo esc_html( $slide['text'] ); ?></div>
                                <?php endif; ?>

                                <?php if ( ! empty( $slide['button_text'] ) ) :
                                    $url = ! empty( $slide['button_link']['url'] ) ? $slide['button_link']['url'] : '#';
                                    $target = ! empty( $slide['button_link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
                                ?>
                                    <a class="emc-card__button" href="<?php echo esc_url( $url ); ?>"<?php echo $target; ?>><?php echo esc_html( $slide['button_text'] ); ?></a>
                                <?php endif; ?>
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
}
