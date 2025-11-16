<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('wpforms')) return;

$form_id = intval(get_query_var('wpforms_style_preview'));
if (!$form_id) return;

$allowed_fields = ['card_bg','card_border','input_bg','input_border','input_text','btn_bg','btn_bg_hov'];
$incoming = array_intersect_key(array_map('sanitize_text_field', $_GET), array_flip($allowed_fields));
$saved = get_option("wpvs_style_{$form_id}", []);
$settings = is_array($saved) ? array_merge($saved, $incoming) : $incoming;

$sel = "#wpforms-{$form_id}";

ob_start();
echo "{$sel} .wpforms-container {";
if (!empty($settings['card_bg'])) echo "--wpforms-container-background-color: {$settings['card_bg']};";
if (!empty($settings['card_border'])) echo "--wpforms-container-border-color: {$settings['card_border']};";
echo "}";

echo "{$sel} input, {$sel} textarea {";
if (!empty($settings['input_bg'])) echo "--wpforms-field-background-color: {$settings['input_bg']};";
if (!empty($settings['input_border'])) echo "--wpforms-field-border-color: {$settings['input_border']};";
if (!empty($settings['input_text'])) echo "--wpforms-field-text-color: {$settings['input_text']};";
echo "}";

echo "{$sel} button.wpforms-submit {";
if (!empty($settings['btn_bg'])) echo "--wpforms-button-background-color: {$settings['btn_bg']};";
echo "}";

echo "{$sel} button.wpforms-submit:hover {";
if (!empty($settings['btn_bg_hov'])) echo "--wpforms-button-background-hover-color: {$settings['btn_bg_hov']};";
echo "}";
$style = ob_get_clean();

?><!doctype html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo esc_url(WPVS_URL . 'assets/preview.css'); ?>">
    <style><?php echo $style; ?></style>
</head>
<body>
    <div id="wpvs-wrapper">
        <?php echo do_shortcode("[wpforms id='{$form_id}']"); ?>
    </div>
</body>
</html>
