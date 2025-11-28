<?php
/**
 * Input helpers — Redirect guards for required parameters.
 * Controllers use null coalescing (??) and trim() directly for field access.
 */

function get_or_redirect(string $key, string $destination) {
    if (!isset($_GET[$key]) || $_GET[$key] === '') {
        header('Location: ' . $destination);
        exit;
    }
    return $_GET[$key];
}

function post_or_redirect(string $key, string $destination) {
    if (!isset($_POST[$key]) || $_POST[$key] === '') {
        header('Location: ' . $destination);
        exit;
    }
    return $_POST[$key];
}

/**
 * Handle file upload for images
 * @param string $fieldName - The name of the file input field
 * @param string $uploadDir - Directory to save uploaded files (relative to script)
 * @param array $allowedTypes - Allowed MIME types
 * @param int $maxSize - Maximum file size in bytes
 * @return array - ['success' => bool, 'filename' => string, 'error' => string]
 */
function handleImageUpload($fieldName, $uploadDir = 'images/', $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxSize = 2097152) {
    // Check if file was uploaded
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => true, 'filename' => null, 'error' => null]; // No file uploaded is OK
    }
    
    $file = $_FILES[$fieldName];
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'Upload stopped by extension'
        ];
        return ['success' => false, 'filename' => null, 'error' => $errors[$file['error']] ?? 'Unknown upload error'];
    }
    
    // Validate file size
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'filename' => null, 'error' => 'File size exceeds ' . ($maxSize / 1048576) . 'MB limit'];
    }
    
    // Validate file type using finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'filename' => null, 'error' => 'Invalid file type. Allowed: JPG, PNG, GIF'];
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFilename = uniqid('img_', true) . '.' . strtolower($extension);
    $targetPath = $uploadDir . $newFilename;
    
    // Ensure upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $newFilename, 'error' => null];
    } else {
        return ['success' => false, 'filename' => null, 'error' => 'Failed to move uploaded file'];
    }
}

