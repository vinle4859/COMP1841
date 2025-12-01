<?php
/**
 * Terms of Service and Community Guidelines
 */
include 'includes/config.php';
include FUNCTIONS_PATH . 'SessionFunctions.php';
initRequest();

$title = 'Terms of Service';
$activePage = 'terms';

ob_start();
include PUBLIC_TEMPLATES . 'terms.html.php';
$output = ob_get_clean();
include PUBLIC_TEMPLATES . 'layout.html.php';
