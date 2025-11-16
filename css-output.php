<?php

$forms = wpforms()->form->get();

foreach ($forms as $form) {

    $opt = get_option("wpvs_style_".$form->ID);
    if (!$opt) continue;

    echo "<style>";

    $sel = "#wpforms-".$form->ID;

    echo "$sel .wpforms-container {";
    if (!empty($opt['card_bg'])) echo "--wpforms-container-background-color: ".$opt['card_bg'].";";
    if (!empty($opt['card_border'])) echo "--wpforms-container-border-color: ".$opt['card_border'].";";
    echo "}";

    echo "$sel input, $sel textarea {";
    if (!empty($opt['input_bg'])) echo "--wpforms-field-background-color: ".$opt['input_bg'].";";
    if (!empty($opt['input_border'])) echo "--wpforms-field-border-color: ".$opt['input_border'].";";
    if (!empty($opt['input_text'])) echo "--wpforms-field-text-color: ".$opt['input_text'].";";
    echo "}";

    echo "$sel button.wpforms-submit {";
    if (!empty($opt['btn_bg'])) echo "--wpforms-button-background-color: ".$opt['btn_bg'].";";
    echo "}";

    echo "$sel button.wpforms-submit:hover {";
    if (!empty($opt['btn_bg_hov'])) echo "--wpforms-button-background-hover-color: ".$opt['btn_bg_hov'].";";
    echo "}";

    echo "</style>";
}
