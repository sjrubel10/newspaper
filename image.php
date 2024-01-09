<?php
function resizeImageLanczos($inputImagePath, $outputImagePath, $newWidth, $newHeight) {
    // Get image dimensions
    list($originalWidth, $originalHeight) = getimagesize($inputImagePath);

    // Create image resources
    $sourceImage = imagecreatefromjpeg($inputImagePath); // Change this based on the input image type
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // Perform Lanczos resampling
    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    // Save the resized image to the output file
    imagejpeg($resizedImage, $outputImagePath); // Change this based on the desired output format

    // Free up resources
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);
}


function cropAndStoreImage($inputImagePath, $outputFolder, $targetWidth, $targetHeight, $targetSize)
{
    // Get image dimensions
    list($originalWidth, $originalHeight) = getimagesize($inputImagePath);

    // Create an image resource from the input image
    $sourceImage = imagecreatefromjpeg($inputImagePath); // Change this based on the input image type

    // Calculate the aspect ratio of the original image
    $originalAspectRatio = $originalWidth / $originalHeight;

    // Calculate the aspect ratio of the target dimensions
    $targetAspectRatio = $targetWidth / $targetHeight;

    // Calculate new dimensions for cropping
    if ($originalAspectRatio > $targetAspectRatio) {
        $newWidth = $originalHeight * $targetAspectRatio;
        $newHeight = $originalHeight;
    } else {
        $newWidth = $originalWidth;
        $newHeight = $originalWidth / $targetAspectRatio;
    }

    // Calculate crop points
    $cropX = ($originalWidth - $newWidth) / 2;
    $cropY = ($originalHeight - $newHeight) / 2;

    // Create a new image resource for the cropped image
    $croppedImage = imagecrop($sourceImage, ['x' => $cropX, 'y' => $cropY, 'width' => $newWidth, 'height' => $newHeight]);

    // Resize the cropped image to the target dimensions
    $resizedImage = imagescale($croppedImage, $targetWidth, $targetHeight);

    // Ensure the output folder exists
    if (!file_exists($outputFolder)) {
        mkdir($outputFolder, 0777, true);
    }

    // Generate a unique filename for the output image (you may need a more sophisticated approach)
    $outputImagePath = $outputFolder . '/' . uniqid() . '_cropped_resized.jpg'; // Change this based on the desired output format

    // Save the resized and cropped image to the output file
    imagejpeg($resizedImage, $outputImagePath);

    // Free up resources
    imagedestroy($sourceImage);
    imagedestroy($croppedImage);
    imagedestroy($resizedImage);

    return $outputImagePath;
}

// Example usage:
$inputImagePath = 'assets/uploads/1697690835_ebbdf7a712de9aa89580d2abd7458dfd.jpeg';
echo $inputImagePath;
$outputFolder = 'assets/uploads/createdImage';
$targetWidth = 300;
$targetHeight = 200;
$targetSize = 100; // Size in KB

$outputImagePath = cropAndStoreImage($inputImagePath, $outputFolder, $targetWidth, $targetHeight, $targetSize);

echo 'Cropped and resized image saved to: ' . $outputImagePath;

