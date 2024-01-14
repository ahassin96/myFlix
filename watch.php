<?php


session_start();
require 'vendor/autoload.php';

$videoTitle = isset($videoDetails['video_details']['title']) ? $videoDetails['video_details']['title'] : 'Video Title Not Available';
$videoDescription = isset($videoDetails['video_details']['description']) ? $videoDetails['video_details']['description'] : 'Video Description Not Available';
$videoUrl = isset($videoDetails['video_details']['url']) ? $videoDetails['video_details']['url'] : '';

$apiUrl = 'http://3.90.74.38:5000/watch/' . $videoId;
$videoDetailsJson = file_get_contents($apiUrl);
$videoDetails = json_decode($videoDetailsJson, true);

var_dump($videoDetails); 

$videoUrl = isset($videoDetails['url']) ? $videoDetails['url'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Watch Video - MyFlix</title>
</head>
<body>

    <h1>Watch Video - MyFlix</h1>

   <div id="videoDetailsContainer">
    <h2 id="videoTitle"><?php echo $videoTitle; ?></h2>
    <p id="videoDescription"><?php echo $videoDescription; ?></p>
</div>

<video id="watchVideo" controls>
    <source src="<?php echo $videoUrl; ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>

</body>
</html>
