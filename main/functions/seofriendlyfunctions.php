<?php
function generateSEOUrl($postTitle) {
    // Convert special characters to ASCII
    $postTitle = iconv('UTF-8', 'ASCII//TRANSLIT', $postTitle);

    // Replace non-alphanumeric characters with hyphens
    $postTitle = preg_replace('/[^a-zA-Z0-9\s]/', '', $postTitle);

    // Replace spaces with hyphens
    $postTitle = preg_replace('/\s+/', '-', $postTitle);

    // Convert to lowercase
    $postTitle = strtolower($postTitle);

    // Remove leading/trailing hyphens
    $postTitle = trim($postTitle, '-');

    return $postTitle;
}

function generateMetaDescription($postContent, $maxLength = 160) {
    // Strip HTML tags
    $postContent = strip_tags($postContent);

    // Truncate to specified length
    if (mb_strlen($postContent) > $maxLength) {
        $postContent = mb_substr($postContent, 0, $maxLength);
        // Make sure it ends at the end of a word
        $postContent = preg_replace('/\s+?(\S+)?$/', '', $postContent);
    }

    // Return the truncated content
    return $postContent;
}

