<?php
/**
 * Plugin Name:     Prettier Dashboard
 * Plugin URI:      https://plugins.wp-cli.org/demo-plugin
 * Description:     A plugin that makes a more visually appealing WordPress Dashboard
 * Author:          Alpha_LM
 * Author URI:      https://wp-cli.org
 * Text Domain:     wpcli-demo-plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Wpcli_Demo_Plugin
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}


function cdr_store_menu_items() {
    global $menu;
    update_option('cdr_menu_items', $menu);
}
add_action('admin_menu', 'cdr_store_menu_items');

// Remove the sidebar and admin bar on all pages, including the dashboard
function cdr_remove_sidebar() {
    echo '<link rel="stylesheet" href="' . plugins_url('css/admin-styles.css', __FILE__) . '">';
}
add_action('admin_head', 'cdr_remove_sidebar');

// Remove all default dashboard widgets
function cdr_remove_default_dashboard_widgets() {
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); 
}
add_action('wp_dashboard_setup', 'cdr_remove_default_dashboard_widgets', 999);

// Add custom navigation bar on all admin pages except the dashboard
function cdr_add_navigation_bar() {
    global $pagenow;
    if ($pagenow === 'index.php') return;

    $menu = get_option('cdr_menu_items');
    if (!$menu) return;

    echo '<div class="cdr-nav-bar">';
    foreach ($menu as $menu_item) {
        $menu_title = wp_strip_all_tags($menu_item[0]);
        $menu_slug = $menu_item[2];
        
        if (empty($menu_title) || strpos($menu_slug, '.php') === false) continue;
        
        $menu_url = admin_url($menu_slug);
        echo '<a href="' . esc_url($menu_url) . '">' . esc_html($menu_title) . '</a>';
    }
    echo '</div>';
}
add_action('admin_head', 'cdr_add_navigation_bar');

// Add custom blocks for dashboard menu
function cdr_add_custom_blocks() {
    $menu = get_option('cdr_menu_items');
    if (!$menu) return;

    echo '<div class="cdr-blocks-container">';
    foreach ($menu as $menu_item) {
        $menu_title = wp_strip_all_tags($menu_item[0]);
        $menu_slug = $menu_item[2];

        if (empty($menu_title) || strpos($menu_slug, '.php') === false) continue;

        $menu_url = admin_url($menu_slug);
        
        // Wrap the entire block inside the anchor tag to make it fully clickable
        echo '<a href="' . esc_url($menu_url) . '" class="cdr-block">';
        echo '<h3>' . esc_html($menu_title) . '</h3>';
        echo '</a>';
    }
    echo '</div>';
}
add_action('wp_dashboard_setup', 'cdr_add_custom_blocks');

function cdr_enqueue_admin_styles() {
    wp_enqueue_style('cdr-admin-styles', plugins_url('css/admin-styles.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'cdr_enqueue_admin_styles');

function cdr_add_dashboard_title() {
    global $pagenow;
    if ($pagenow !== 'index.php') return;

    echo '<div class="cdr-dashboard-title">Prettier Dashboard</div>';
}
add_action('admin_notices', 'cdr_add_dashboard_title');

function cdr_enqueue_admin_scripts() {
    wp_enqueue_script('cdr-admin-script', plugins_url('js/admin-scripts.js', __FILE__), array(), false, true);
}
add_action('admin_enqueue_scripts', 'cdr_enqueue_admin_scripts');


function cdr_enqueue_google_fonts() {
    wp_enqueue_style('cdr-google-fonts', 'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap', false);
}
add_action('admin_enqueue_scripts', 'cdr_enqueue_google_fonts');










