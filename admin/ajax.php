<?php

if (!defined('ABSPATH')) exit;

add_action('wp_ajax_wpvs_save', function(){

    $id = intval($_POST['form_id']);
    $settings = json_decode(stripslashes($_POST['settings']), true);

    update_option("wpvs_style_$id", $settings);

    wp_die("ok");
});
