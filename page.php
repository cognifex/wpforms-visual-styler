<?php if (!defined('ABSPATH')) exit;

$forms = wpforms()->form->get();
?>

<div id="wpvs-wrapper">

    <div id="wpvs-left">
        <h2>Formular auswählen</h2>

        <ul id="wpvs-form-list">
            <?php foreach ($forms as $form): ?>
                <li data-id="<?php echo $form->ID; ?>">
                    <?php echo esc_html($form->post_title); ?> (#<?php echo $form->ID; ?>)
                </li>
            <?php endforeach; ?>
        </ul>

        <hr>

        <div id="wpvs-settings-root"></div>
    </div>

    <div id="wpvs-right">
        <iframe id="wpvs-iframe" src="" loading="lazy"></iframe>
    </div>

</div>
