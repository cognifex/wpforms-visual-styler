<?php
$form_id = intval(get_query_var('wpforms_style_preview'));
$vars = $_GET;

echo "<html><head>";
echo "<link rel='stylesheet' href='".WPVS_URL."assets/preview.css'>";
echo "</head><body>";

echo "<div id='wpvs-wrapper'>";
echo do_shortcode("[wpforms id='$form_id']");
echo "</div>";

echo "</body></html>";
