<?php
/**
 * Plugin Name: Reusable Cards
 * Description: Create reusable sets of cards with icon, title, and subtitle. Display with shortcode [cards_set id="123"] or [cards_set category="seo"].
 * Version: 1.1
 * Author: Kenneth Alvarenga
 * License: GPL2+
 */

if (!defined('ABSPATH')) exit;

class ReusableCards {

    public function __construct() {
        add_action('init', [$this, 'register_cards']);
        add_shortcode('cards_set', [$this, 'render_cards']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    /** Register custom post type and taxonomy */
    public function register_cards() {
        register_post_type('card', [
            'labels' => [
                'name'          => 'Cards',
                'singular_name' => 'Card'
            ],
            'public'      => true,
            'has_archive' => false,
            'menu_icon'   => 'dashicons-screenoptions',
            'supports'    => ['title', 'editor', 'thumbnail'],
        ]);

        // Add taxonomy for categories
        register_taxonomy('card_category', 'card', [
            'labels' => [
                'name'          => 'Card Categories',
                'singular_name' => 'Card Category'
            ],
            'public'       => true,
            'hierarchical' => true,
        ]);

        // Add meta fields for icon and subtitle
        add_action('add_meta_boxes', function() {
            add_meta_box('card_meta', 'Card Details', [$this, 'render_meta_box'], 'card', 'normal', 'default');
        });

        add_action('save_post', [$this, 'save_meta']);
    }

    /** Meta box */
    public function render_meta_box($post) {
        $icon     = get_post_meta($post->ID, '_card_icon', true);
        $subtitle = get_post_meta($post->ID, '_card_subtitle', true);
        $color    = get_post_meta($post->ID, '_card_color', true);
        ?>
        <p>
            <label>Icon (emoji or Dashicon class)</label><br>
            <input type="text" name="card_icon" value="<?php echo esc_attr($icon); ?>" style="width:100%;">
        </p>
        <p>
            <label>Subtitle</label><br>
            <input type="text" name="card_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width:100%;">
        </p>
        <p>
            <label>Background color (HEX or name)</label><br>
            <input type="text" name="card_color" value="<?php echo esc_attr($color); ?>" style="width:100%;" placeholder="#f5f5f5">
        </p>
        <?php
    }

    public function save_meta($post_id) {
        if (isset($_POST['card_icon'])) {
            update_post_meta($post_id, '_card_icon', sanitize_text_field($_POST['card_icon']));
        }
        if (isset($_POST['card_subtitle'])) {
            update_post_meta($post_id, '_card_subtitle', sanitize_text_field($_POST['card_subtitle']));
        }
        if (isset($_POST['card_color'])) {
            $color = sanitize_text_field($_POST['card_color']);
            update_post_meta($post_id, '_card_color', $color);
        }
    }

    /** Shortcode renderer */
    public function render_cards($atts) {
        $atts = shortcode_atts([
            'id'       => '',
            'category' => '',
        ], $atts, 'cards_set');

        $args = [
            'post_type'      => 'card',
            'posts_per_page' => -1,
        ];

        if (!empty($atts['id'])) {
            $ids = array_map('intval', explode(',', $atts['id']));
            $args['post__in'] = $ids;
            $args['orderby']  = 'post__in';
        } elseif (!empty($atts['category'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'card_category',
                    'field'    => 'slug',
                    'terms'    => sanitize_title($atts['category']),
                ]
            ];
        }

        $query = new WP_Query($args);
        if (!$query->have_posts()) {
            return '<p>No cards found.</p>';
        }

        ob_start();
        echo '<div class="cards-grid">';
        while ($query->have_posts()) : $query->the_post();
            $icon     = get_post_meta(get_the_ID(), '_card_icon', true);
            $subtitle = get_post_meta(get_the_ID(), '_card_subtitle', true);
            $color    = get_post_meta(get_the_ID(), '_card_color', true);
            ?>
            <div class="card-item" style="background:<?php echo esc_attr($color ? $color : '#fafafa'); ?>;">
                <div class="card-icon"><?php echo esc_html($icon); ?></div>
                <h3 class="card-title"><?php the_title(); ?></h3>
                <?php if ($subtitle): ?>
                    <p class="card-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
            <?php
        endwhile;
        echo '</div>';
        wp_reset_postdata();
        return ob_get_clean();
    }

    /** Enqueue assets */
    public function enqueue_assets() {
        wp_register_style('reusable-cards', plugins_url('style.css', __FILE__));
        wp_enqueue_style('reusable-cards');
    }
}

new ReusableCards();
