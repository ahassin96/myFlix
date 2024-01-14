<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Viewer</title>
</head>
<body>

<?php
$videoId = "659e63a802fa8b2ac177aef7"; // Replace with the actual video ID

// Make a request to the Flask API
$apiUrl = "http://3.90.74.38:5000/watch/{$videoId}";
$response = file_get_contents($apiUrl);

if ($response) {
    $data = json_decode($response, true);

    if (isset($data['video_details'])) {
        $videoUrl = $data['video_details']['url']; // Assuming the video URL is present in the response
        echo "<video controls width='640' height='360'>";
        echo "<source src='{$videoUrl}' type='video/mp4'>";
        echo "Your browser does not support the video tag.";
        echo "</video>";
    } else {
        echo "Error: Video details not found.";
    }
} else {
    echo "Error: Unable to fetch video details.";
}
?>

</body>
</html>