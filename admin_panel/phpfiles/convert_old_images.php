<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
  include('../connection.php');

function convertToWebp($sourceFile, $destinationPath, $quality = 80)
{
    if (!file_exists($sourceFile)) {
        return false;
    }

    $imageInfo = getimagesize($sourceFile);

    if (!$imageInfo) {
        return false;
    }

    $mime = $imageInfo['mime'];

    switch ($mime) {

        case 'image/jpeg':
            $image = imagecreatefromjpeg($sourceFile);
            break;

        case 'image/png':
            $image = imagecreatefrompng($sourceFile);

            // Preserve transparency
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);

            break;

        case 'image/gif':
            $image = imagecreatefromgif($sourceFile);
            break;

        case 'image/webp':
            $image = imagecreatefromwebp($sourceFile);
            break;

        default:
            return false;
    }

    if (!$image) {
        return false;
    }

    $result = imagewebp($image, $destinationPath, $quality);

    imagedestroy($image);

    return $result;
}


// Uploads folder
$uploadDir = "../Uploads/";

// Fetch all products
$query = "SELECT id, name, img FROM products";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed.");
}

while ($row = mysqli_fetch_assoc($result)) {

    $productId = $row['id'];
    $productName = $row['name'];
    $oldImage = trim($row['img']);

    if (empty($oldImage)) {

        echo "Product ID {$productId} has no image <br>";
        continue;
    }

    $oldImagePath = $uploadDir . $oldImage;

    // Check file exists
    if (!file_exists($oldImagePath)) {

        echo "Image not found: {$oldImagePath} <br>";
        continue;
    }

    // Skip already webp images
    $extension = strtolower(pathinfo($oldImagePath, PATHINFO_EXTENSION));

    if ($extension === 'webp') {

        echo "Already WEBP: {$oldImage} <br>";
        continue;
    }

    // Generate new image name
    $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $productName);

    $newImageName = $cleanName . "_" . $productId . ".webp";

    $newImagePath = $uploadDir . $newImageName;

    // Convert image
    $converted = convertToWebp($oldImagePath, $newImagePath, 80);

    if ($converted) {

        // Update database
        $update = "UPDATE products 
                   SET img = '$newImageName' 
                   WHERE id = '$productId'";

        if (mysqli_query($conn, $update)) {

            // Delete old image
            unlink($oldImagePath);

            echo "Converted Product ID {$productId} → {$newImageName} <br>";

        } else {

            // Remove new image if DB update fails
            if (file_exists($newImagePath)) {
                unlink($newImagePath);
            }

            echo "DB update failed for Product ID {$productId} <br>";
        }

    } else {

        echo "Conversion failed for Product ID {$productId} <br>";
    }
}

echo "<br><b>Conversion Completed</b>";
?>