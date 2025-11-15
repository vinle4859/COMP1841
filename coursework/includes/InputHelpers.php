<?php
// Returns trimmed string or empty string if the key is not present.
function validateAndTrim($key) {
    if (isset($_POST[$key])) {
        return trim($_POST[$key]);
    }
    return '';
}

