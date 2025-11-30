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
 * Uses getimagesize() to verify actual image content (W3Schools approach)
 * @param string $fieldName - The name of the file input field
 * @param string $prefix - Prefix for generated filename (e.g., 'answer_', 'question_')
 * @return array - ['success' => bool, 'filename' => string|null, 'error' => string|null]
 */
function handleImageUpload($fieldName, $prefix = 'img_') {
    $uploadDir = IMAGES_PATH; // Use absolute path from config
    $maxSize = 2 * 1024 * 1024; // 2MB
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
    
    // Check if file was uploaded
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => true, 'filename' => null, 'error' => null]; // No file is OK
    }
    
    $file = $_FILES[$fieldName];
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'filename' => null, 'error' => 'File could not be uploaded.'];
    }
    
    // Check file size (2MB limit)
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'filename' => null, 'error' => 'File too large. Max 2MB allowed.'];
    }
    
    // Check extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        return ['success' => false, 'filename' => null, 'error' => 'Invalid file type. Only JPG, PNG, GIF allowed.'];
    }
    
    // Verify it's a real image using getimagesize (reads actual file bytes)
    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return ['success' => false, 'filename' => null, 'error' => 'File is not a valid image.'];
    }
    
    // Generate unique filename
    $newFilename = $prefix . time() . '_' . uniqid() . '.' . $ext;
    $targetPath = $uploadDir . $newFilename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $newFilename, 'error' => null];
    } else {
        return ['success' => false, 'filename' => null, 'error' => 'File could not be uploaded.'];
    }
}

