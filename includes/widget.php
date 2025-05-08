<?php
defined('ABSPATH') || exit;

class Eskim_Views_Counter_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'eskim_views_counter_widget',
            'Licznik wyświetleń',
            ['description' => __('Wyświetla liczbę wyświetleń posta.', 'simple_page_views_counter_eskim_pl')]
        );
    }

    public function widget($args, $instance): void {
        if (is_singular()) {
            echo esc_html(evc_get_views(get_the_ID()));
        }
    }
}

add_action('widgets_init', fn() => register_widget(Eskim_Views_Counter_Widget::class));
