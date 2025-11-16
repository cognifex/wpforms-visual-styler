<?php if (!defined('ABSPATH')) exit;

if (!function_exists('wpforms')) {
    echo '<div class="notice notice-error"><p>WPForms muss installiert und aktiviert sein, damit der Visual Styler funktioniert.</p></div>';
    return;
}

$forms = wpforms()->form->get();
?>

<div id="wpvs-wrapper">

    <div id="wpvs-left">
        <h2>Formular auswählen</h2>

        <?php if (empty($forms)) : ?>
            <p>Keine WPForms-Formulare gefunden.</p>
        <?php else : ?>
            <ul id="wpvs-form-list">
                <?php foreach ($forms as $form): ?>
                    <li data-id="<?php echo esc_attr($form->ID); ?>" data-settings='<?php echo esc_attr(wp_json_encode(get_option("wpvs_style_{$form->ID}", []))); ?>'>
                        <?php echo esc_html($form->post_title); ?> (#<?php echo esc_html($form->ID); ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <div id="wpvs-settings-root"></div>
    </div>

    <div id="wpvs-right">
        <iframe id="wpvs-iframe" src="" loading="lazy"></iframe>
    </div>

</div>
