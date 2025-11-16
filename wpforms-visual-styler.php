<?php
/**
 * Plugin Name: WPForms Visual Styler
 * Description: Live Styling für WPForms inkl. Blocksy-Colorpicker.
 */

if (!defined('ABSPATH')) exit;

define('WPVS_PATH', plugin_dir_path(__FILE__));
define('WPVS_URL',  plugin_dir_url(__FILE__));

class WPVS {

    function __construct() {

        // Admin Menü
        add_action('admin_menu', [$this, 'menu']);

        // Admin Assets
        add_action('admin_enqueue_scripts', [$this, 'assets']);

        // Preview Endpoint
        add_action('init', [$this,'preview_endpoint']);
        add_action('template_redirect', [$this,'preview_loader']);

        // Frontend CSS
        add_action('wp_head', [$this,'css_output']);

        // AJAX Save
        require_once WPVS_PATH . "admin/ajax.php";
    }

    function menu(){
        add_submenu_page(
            'wpforms-overview',
            'Styles',
            'Styles',
            'manage_options',
            'wpforms-styles',
            function(){ include WPVS_PATH . "admin/page.php"; }
        );
    }

    function assets($hook){
        if ($hook !== "wpforms_page_wpforms-styles") return;

        wp_enqueue_style("wpvs-admin", WPVS_URL."assets/admin.css");

        // React + Gutenberg
        wp_enqueue_script("wp-element");
        wp_enqueue_script("wp-components");
        wp_enqueue_script("wp-block-editor");

        // Blocksy Colorpicker
        wp_enqueue_script("blocksy-options", plugins_url("blocksy-companion/static/bundle/options.min.js"), [], null, true);

        // React App
        wp_enqueue_script("wpvs-react", WPVS_URL."admin/react-app.js", ['wp-element'], null, true);
        wp_localize_script("wpvs-react", "WPVS", [
            "ajax" => admin_url("admin-ajax.php"),
            "previewBase" => site_url("/wpforms-style-preview/")
        ]);
    }

    function preview_endpoint(){
        add_rewrite_rule('wpforms-style-preview/([^/]+)/?', 'index.php?wpforms_style_preview=$matches[1]', 'top');
        add_filter('query_vars', fn($v)=>array_merge($v,['wpforms_style_preview']));
    }

    function preview_loader(){
        $style = get_query_var('wpforms_style_preview');
        if (!$style) return;
        include WPVS_PATH . "public/preview.php";
        exit;
    }

    function css_output(){
        include WPVS_PATH . "public/css-output.php";
    }
}

new WPVS();
