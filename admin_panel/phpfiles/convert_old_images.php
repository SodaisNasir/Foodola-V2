<?php
// Enable error reporting and set limits to prevent timeouts
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
set_time_limit(300);

include('../connection.php');

/**
 * Function to convert, resize, and compress images to target KB size
 */
function convertToWebpWithSizeControl($sourceFile, $destinationPath, $minKB, $maxKB, $maxWidth = 800, $maxHeight = 800)
{
    if (!file_exists($sourceFile)) {
        return false;
    }

    $imageInfo = @getimagesize($sourceFile);
    if (!$imageInfo) {
        return false;
    }

    $width = $imageInfo[0];
    $height = $imageInfo[1];
    $mime = $imageInfo['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $sourceImage = @imagecreatefromjpeg($sourceFile);
            break;
        case 'image/png':
            $sourceImage = @imagecreatefrompng($sourceFile);
            if ($sourceImage) {
                @imagepalettetotruecolor($sourceImage);
                @imagealphablending($sourceImage, true);
                @imagesavealpha($sourceImage, true);
            }
            break;
        case 'image/gif':
            $sourceImage = @imagecreatefromgif($sourceFile);
            break;
        case 'image/webp':
            $sourceImage = @imagecreatefromwebp($sourceFile);
            break;
        default:
            return false;
    }

    if (!$sourceImage) {
        return false;
    }

    // Resize dimensions to reduce pixel count for large images
    $ratio = $width / $height;
    if ($width > $maxWidth || $height > $maxHeight) {
        if ($maxWidth / $maxHeight > $ratio) {
            $newWidth = $maxHeight * $ratio;
            $newHeight = $maxHeight;
        } else {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $ratio;
        }
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    $newImage = imagecreatetruecolor((int)$newWidth, (int)$newHeight);
    
    @imagealphablending($newImage, false);
    @imagesavealpha($newImage, true);
    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
    imagefilledrectangle($newImage, 0, 0, (int)$newWidth, (int)$newHeight, $transparent);

    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, (int)$newWidth, (int)$newHeight, $width, $height);
    imagedestroy($sourceImage);

    $lowQuality = 5;
    $highQuality = 85;
    $bestQuality = 40;
    
    $targetMinBytes = $minKB * 1024;
    $targetMaxBytes = $maxKB * 1024;

    // Binary search loop to hit target size range precisely
    $iterations = 0;
    while ($lowQuality <= $highQuality && $iterations < 6) {
        $midQuality = (int)(($lowQuality + $highQuality) / 2);
        @imagewebp($newImage, $destinationPath, $midQuality);
        $fileSize = file_exists($destinationPath) ? filesize($destinationPath) : 0;

        if ($fileSize >= $targetMinBytes && $fileSize <= $targetMaxBytes) {
            $bestQuality = $midQuality;
            break;
        } elseif ($fileSize > $targetMaxBytes) {
            $highQuality = $midQuality - 1;
            $bestQuality = $midQuality;
        } else {
            $lowQuality = $midQuality + 1;
            $bestQuality = $midQuality;
        }
        $iterations++;
    }

    @imagewebp($newImage, $destinationPath, $bestQuality);
    imagedestroy($newImage);

    return true;
}

$uploadDir = "../Uploads/";
$batchSize = 10; // Increased batch size to process 10 images at once

$productOffset = isset($_GET['p_offset']) ? (int)$_GET['p_offset'] : 0;
$sliderOffset = isset($_GET['s_offset']) ? (int)$_GET['s_offset'] : 0;

$finishedProducts = false;
$finishedSliders = false;

echo "<h3>--- Automated WebP Conversion & Cleanup Script (Batch Size: 10) ---</h3>";

// 1. Process Products Batch (Target: 15 KB - 20 KB)
$query = "SELECT id, name, img FROM products LIMIT $batchSize OFFSET $productOffset";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<b>Processing Products Batch (Offset: {$productOffset})</b><br>";
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['id'];
        $productName = $row['name'];
        $oldImage = trim($row['img']);

        if (empty($oldImage)) {
            echo "Product ID {$productId}: No image found in database <br>";
            continue;
        }

        $oldImagePath = $uploadDir . $oldImage;
        if (!file_exists($oldImagePath)) {
            echo "Product ID {$productId}: Image file does not exist on disk -> {$oldImage} <br>";
            continue;
        }

        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $productName);
        if(empty($cleanName)) $cleanName = "Product";
        
        $newImageName = $cleanName . "_" . $productId . ".webp";
        $newImagePath = $uploadDir . $newImageName;

        // Convert and compress to 15KB - 20KB range
        $converted = convertToWebpWithSizeControl($oldImagePath, $newImagePath, 15, 20, 800, 800);

        if ($converted) {
            $update = "UPDATE products SET img = '$newImageName' WHERE id = '$productId'";
            if (mysqli_query($conn, $update)) {
                
                // Delete old image file from server if it's different from the new one
                if ($oldImagePath !== $newImagePath && file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
                
                echo "Successfully Converted Product ID {$productId} → {$newImageName} (" . round(filesize($newImagePath)/1024, 2) . " KB) [Old file deleted]<br>";
            } else {
                // Remove new file if database update fails
                if (file_exists($newImagePath) && $oldImagePath !== $newImagePath) {
                    @unlink($newImagePath);
                }
                echo "Database update failed for Product ID {$productId} <br>";
            }
        } else {
            echo "Conversion failed for Product ID {$productId} <br>";
        }
    }
    $nextProductOffset = $productOffset + $batchSize;
} else {
    $finishedProducts = true;
    $nextProductOffset = $productOffset;
    echo "<b>Products Conversion Completed Successfully!</b><br>";
}

echo "<br>";

// 2. Process Sliders Batch (Target: 30 KB - 50 KB)
if ($finishedProducts) {
    $sliderQuery = "SELECT id, alt_name, img FROM sliders LIMIT $batchSize OFFSET $sliderOffset";
    $sliderResult = mysqli_query($conn, $sliderQuery);

    if ($sliderResult && mysqli_num_rows($sliderResult) > 0) {
        echo "<b>Processing Sliders Batch (Offset: {$sliderOffset})</b><br>";
        while ($sRow = mysqli_fetch_assoc($sliderResult)) {
            $sliderId = $sRow['id'];
            $altName = $sRow['alt_name'];
            $oldSliderImg = trim($sRow['img']);

            if (empty($oldSliderImg)) {
                echo "Slider ID {$sliderId}: No image found in database <br>";
                continue;
            }

            $oldSliderPath = $uploadDir . $oldSliderImg;
            if (!file_exists($oldSliderPath)) {
                echo "Slider ID {$sliderId}: Image file does not exist on disk -> {$oldSliderImg} <br>";
                continue;
            }

            $cleanSliderName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $altName);
            if (empty($cleanSliderName)) {
                $cleanSliderName = "Slider";
            }
            
            $newSliderName = date('YmdHis') . "_" . $sliderId . "_" . $cleanSliderName . ".webp";
            $newSliderPath = $uploadDir . $newSliderName;

            // Convert and compress sliders to 30KB - 50KB range
            $convertedSlider = convertToWebpWithSizeControl($oldSliderPath, $newSliderPath, 30, 50, 1400, 1400);

            if ($convertedSlider) {
                $updateSlider = "UPDATE sliders SET img = '$newSliderName' WHERE id = '$sliderId'";
                if (mysqli_query($conn, $updateSlider)) {
                    
                    // Delete old slider image file from server
                    if ($oldSliderPath !== $newSliderPath && file_exists($oldSliderPath)) {
                        @unlink($oldSliderPath);
                    }
                    
                    echo "Successfully Converted Slider ID {$sliderId} → {$newSliderName} (" . round(filesize($newSliderPath)/1024, 2) . " KB) [Old file deleted]<br>";
                } else {
                    if (file_exists($newSliderPath) && $oldSliderPath !== $newSliderPath) {
                        @unlink($newSliderPath);
                    }
                    echo "Database update failed for Slider ID {$sliderId} <br>";
                }
            } else {
                echo "Conversion failed for Slider ID {$sliderId} <br>";
            }
        }
        $nextSliderOffset = $sliderOffset + $batchSize;
        $finishedSliders = false;
    } else {
        $finishedSliders = true;
        $nextSliderOffset = $sliderOffset;
        echo "<b>Sliders Conversion Completed Successfully!</b><br>";
    }
} else {
    $nextSliderOffset = 0;
}

// Auto-refresh script to process next batch automatically
if (!$finishedProducts || !$finishedSliders) {
    $nextUrl = "?p_offset=" . $nextProductOffset . "&s_offset=" . $nextSliderOffset;
    echo "<br><b style='color:blue;'>Batch completed. Automatically loading next 10 items in 1 second...</b>";
    echo "<script>
        setTimeout(function() {
            window.location.href = '{$nextUrl}';
        }, 1000);
    </script>";
} else {
    echo "<br><h2 style='color:green;'>All Products and Sliders Have Been Successfully Converted, Optimized, and Cleaned!</h2>";
}
?>