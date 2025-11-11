<?php

include 'includes/DataBaseFunctions.php';
include 'includes/InputHelpers.php';
if (isset($_POST['submit'])) {
    try {
        include 'includes/DatabaseConnection.php';
        $name = validateAndTrim('name');
        $email = validateAndTrim('email');
        $subject = validateAndTrim('subject');
        $body = validateAndTrim('body');

        if ($name === '' || $email === '' || $subject === '' || $body === '') {
            $error = 'Please fill all required fields.';
        } else {
            // no authentication yet; guest submission — store sender_name/sender_email
            $user_id = null;
            addMessage($pdo, $subject, $body, $name, $email, $user_id);
            $success = 'Message sent! Thank you for contacting us.';
            // clear form values
            $name = $email = $subject = $body = '';
        }
    } catch (PDOException $e) {
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
}

$title = 'Contact';
ob_start();
include 'templates/contact.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
